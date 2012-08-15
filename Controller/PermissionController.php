<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Wixet\WixetBundle\Entity\GroupPermission;
use Wixet\WixetBundle\Entity\ProfilePermission;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/permission")
 */
class PermissionController extends Controller
{
    
    /**
     * @Route("/", name="_permission_index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
    	/* DPRECATED */
    	//$data = json_decode(file_get_contents('php://input'),true);
    	$data= array();
    	$em = $this->get('doctrine')->getEntityManager();
    	
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	
    	//UserPermission
    	//$query = $em->createQuery('SELECT p FROM Wixet\WixetBundle\Entity\ProfilePermission p WHERE p.owner = ?1 AND p.owner != p.profile');
    	$query = $em->createQuery('SELECT 
    									pe.id,
    									pe.object_id as objectId,
	    								pe.read_granted as readGranted,
	    								pe.read_denied as readDenied,
	    								pe.write_granted as writeGranted,
	    								pe.write_denied as writeDenied,
	    								p.id as profileId,
	    								p.first_name as firstName,
	    								p.last_name as lastName,
	    								o.name as objectType,
	    								\'profile\' as type
	    								
    								FROM Wixet\WixetBundle\Entity\ProfilePermission pe LEFT JOIN pe.profile p LEFT JOIN pe.objectType o WHERE pe.owner = ?1');
    	$query->setParameter(1,$profile);

    	$data['userPermissions'] = $query->getArrayResult();

    	//GroupPermission
    	$query = $em->createQuery('SELECT pe.object_id as objectId,
    											pe.id,
    		    								pe.read_granted as readGranted,
    		    								pe.read_denied as readDenied,
    		    								pe.write_granted as writeGranted,
    		    								pe.write_denied as writeDenied,
    		    								p.id as groupId,
    		    								p.name as groupName,
    		    								o.name as objectType,
    		    								\'group\' as type
    	    								FROM Wixet\WixetBundle\Entity\GroupPermission pe LEFT JOIN pe.group p LEFT JOIN pe.objectType o WHERE pe.owner = ?1');
    	$query->setParameter(1,$profile);
    	 
    	$data['groupPermissions'] = $query->getArrayResult();
    	
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  array_merge($data['userPermissions'],$data['groupPermissions'] )));
    }
    
    
    /**
    * Get all permission for one object
    * @Route("/{objectType}/{objectId}", name="_permission_get")
    * @Method({"GET"})
    */
    public function getPermissionsAction($objectType, $objectId)
    {
    	$em = $this->get('doctrine')->getEntityManager();
    	$repository = "Wixet\WixetBundle\Entity\\".$objectType;
    	 
    	$obj = $em->getRepository($repository)->find($objectId);
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	 

    	//Only the owner can get the permissions
    	$perms = array();
    	$ot = $em->getRepository("Wixet\WixetBundle\Entity\ObjectType")->findOneBy(array("name"=>$repository));
    	
    	if($obj != null && $obj->getProfile()->getId() == $profile->getId()){
    		$query = $em->createQuery('SELECT ot.name as object_type, p.object_id, p.id, pr.id as entity_id, pr.first_name, pr.last_name, p.read_granted, p.read_denied, p.write_granted, p.write_denied FROM Wixet\WixetBundle\Entity\ProfilePermission p JOIN p.profile pr JOIN p.objectType ot WHERE p.object_id = ?1 AND p.objectType = ?2');
    		$query->setParameter(1, $obj->getId());
    		$query->setParameter(2, $ot);
    		$perms['profile'] = $query->getArrayResult();
    		
    		$query = $em->createQuery('SELECT ot.name as object_type, p.object_id, p.id, pr.id as entity_id, pr.name, p.read_granted, p.read_denied, p.write_granted, p.write_denied FROM Wixet\WixetBundle\Entity\GroupPermission p JOIN p.group pr JOIN p.objectType ot WHERE p.object_id = ?1 AND p.objectType = ?2');
    		$query->setParameter(1, $obj->getId());
    		$query->setParameter(2, $ot);
    		$perms['group'] = $query->getArrayResult();

    	}
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  $perms ));
    }

    
    /**
     * DEPRECATED and should not be used
    * Remove profile/group permission using internal id 
    * @Route("/{type}/{id}", name="_permission_delete")
    * @Method({"DELETE"})
    */
    public function deleteAction($type, $id)
    {
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  array("error"=>$error) ));
    	$em = $this->get('doctrine')->getEntityManager();
    	$repository = "";
    	if($type == "profile")
    		$repository = "Wixet\WixetBundle\Entity\ProfilePermission";
    	else
    		$repository = "Wixet\WixetBundle\Entity\GroupPermission";
    	
    	$permission = $em->getRepository($repository)->find($id);
    	
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	
    	$error = true;
    	if($profile->getId() == $permission->getOwner()->getId()){
    		$ws = $this->get('wixet.permission_manager');
    		$ws->removePermission($permission);
    		$error = false;
    	}
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  array("error"=>$error) ));
    }
    
    /**
    * Manage permission 
    * @Route("/{entityType}/{entityId}/{itemType}/{itemId}", name="_permission_manager")
    */
    public function putAction($entityType, $entityId, $itemType, $itemId)
    {
    	
    	
    	$data = json_decode(file_get_contents('php://input'),true);
    	$permissionRaw = array("readGranted"=>(int)$data['read_granted'],
    	    						   "readDenied"=>(int)$data['read_denied'],
    	    	                       "writeGranted"=> (int)$data['write_granted'],
    	    	                       "writeDenied"=> (int)$data['write_denied']);
    	
    	$entity = null;
    	$checkOwner = false;
    	$em = $this->get('doctrine')->getEntityManager();
    	if($entityType == "group")
    		$entity = $em->getRepository("Wixet\WixetBundle\Entity\ProfileGroup")->find($entityId);
    	else{
    		$checkOwner = true;//Check that the owner is not modifying the permissios for his own items. By this way, the user cant deny acces to his own items
    		$entity = $em->getRepository("Wixet\WixetBundle\Entity\UserProfile")->find($entityId);
    	}
    	
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	
    	if(strpos($itemType,"\\") != false)
    		$item = $em->getRepository($itemType)->find($itemId);
    	else
    		$item = $em->getRepository("Wixet\WixetBundle\Entity\\".$itemType)->find($itemId);
    	

    	//Only the owner can set permission
    	if($profile->getId() == $item->getProfile()->getId()){
    		$ws = $this->get('wixet.permission_manager');
    		if($checkOwner){
    			//To avoid deny access to own items 
    			if($entity->getId() == $item->getProfile()->getId()){
    				throw new \Exception("Owner permissions cannot be changed");
    			}else
    				$ws->setPermission($entity,$item,$permissionRaw);
    		}else
    			$ws->setPermission($entity,$item,$permissionRaw);
    		
    	}
    	
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  $data ));

    }


    /**
     * DEPRECATED
    * Create a permission for a profile/group
    * @Route("/{entityType}/{id}/{itemType}/{itemId}", name="_permission_post")
    * @Method({"POST"})
    */
    public function postPermissionAction($entityType, $entityId, $itemType, $itemId)
    {
    	return $this->putAction($entityType, $entityId, $itemType, $itemId);
    	$data = json_decode(file_get_contents('php://input'),true);
    	$permissionRaw = array("readGranted"=>(int)$data['read_granted'],
    	    	    						   "readDenied"=>(int)$data['read_denied'],
    	    	    	                       "writeGranted"=> (int)$data['write_granted'],
    	    	    	                       "writeDenied"=> (int)$data['write_denied']);
    	
    	$em = $this->get('doctrine')->getEntityManager();
    	$repository = "Wixet\WixetBundle\Entity\\".$data['object_type'];
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	
    	
    	 
    	
    	$obj = $em->getRepository($repository)->find($data['object_id']);
    	//Only the owner can set permissions
    	if($obj->getProfile()->getId() == $profile->getId()){
    		if($type == "profile")
    			$receiver = $em->getRepository("Wixet\WixetBundle\Entity\UserProfile")->find($data['entity_id']);
    		else{
    			$receiver = $em->getRepository("Wixet\WixetBundle\Entity\ProfileGroup")->find($data['entity_id']);
    			if($receiver->getProfile()->getId() != $profile->getId()){
    				throw new \Exception("Only the owner of the group can set permissions to the group");
    			}
    		}
    		
    		//TODO hacer que esto lo gestione permission manager
    		$ws = $this->get('wixet.permission_manager');
    		$objectType = $data['object_type'];
    		//TODO cambiar Wixet\WixetBundle\Entity\ItemContainer por una variable de configuración
    		if($type == "profile" && $objectType == "ItemContainer"){
    			//Update profile/album
    			$ws->setPermissionProfileItemContainer($receiver, $obj, $permissionRaw);
    		}elseif($type == "profile" && $objectType != "ItemContainer"){
    			//Update profile/item
    			$ws->setPermissionProfileItem($receiver, $obj, $permissionRaw);
    		}elseif($type == "group" && $objectType == "ItemContainer"){
    			//Update group/album
    			$ws->setPermissionGroupItemContainer($receiver, $obj, $permissionRaw);
    		}elseif($type == "group" && $objectType != "ItemContainer"){
    			//Update group/item
    			$ws->setPermissionGroupItem($receiver, $obj, $permissionRaw);
    		}
    		
    		//Get the permission to return
    		$ot = $em->getRepository("Wixet\WixetBundle\Entity\ObjectType")->findOneBy(array("name"=>$repository));
    		
    		if($type == "profile"){
	    		$query = $em->createQuery('SELECT ot.name as object_type, p.object_id, p.id, pr.id as profile_id, pr.first_name, pr.last_name, p.read_granted, p.read_denied, p.write_granted, p.write_denied FROM Wixet\WixetBundle\Entity\ProfilePermission p JOIN p.profile pr JOIN p.objectType ot WHERE p.object_id = ?1 AND p.objectType = ?2 AND p.profile = ?3');
	    		$query->setParameter(1, $obj->getId());
	    		$query->setParameter(2, $ot);
	    		$query->setParameter(3, $receiver);
	    		$data = $query->getArrayResult();
    		}else{
    			$query = $em->createQuery('SELECT ot.name as object_type, p.object_id, p.id, pr.id as group_id, pr.name, p.read_granted, p.read_denied, p.write_granted, p.write_denied FROM Wixet\WixetBundle\Entity\GroupPermission p JOIN p.group pr JOIN p.objectType ot WHERE p.object_id = ?1 AND p.objectType = ?2 AND p.group = ?3');
    			$query->setParameter(1, $obj->getId());
    			$query->setParameter(2, $ot);
    			$query->setParameter(3, $receiver);
    			$data = $query->getArrayResult();
    		}

    		
    	}
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  $data[0] ));
    }
    /**
    * Add a profile to a group 
    * @Route("/addGroup/{profileId}/{groupId}", name="_group_add")
    */
    public function addProfileToGroupAction($profileId, $groupId)
    {	
    	$owner = $this->get('security.context')->getToken()->getUser()->getProfile();
    	$em = $this->get('doctrine')->getEntityManager();
    	
    	$profile = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($profileId);
    	$group = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->find($groupId);
    	
    	$data = array("error" => true);
    	//Check the ownership of the group
    	if($owner->getId() == $group->getProfile()->getId()){
    		$ws = $this->get('wixet.permission_manager');
    		
    		//Check if user is in the main group
    		$mainGroup = $owner->getMainGroup();
    		$sql = "SELECT count(userprofile_id) as exist from profilegroup_userprofile WHERE profilegroup_id = ". $mainGroup->getId() ." AND userprofile_id = ".$profile->getId();
    		$statement = $em->getConnection()->query($sql);
    		$res = $statement->fetch();
    		if($res['exist'] == 0){
    			$ws->addProfileToGroup($profile, $mainGroup);
    			//Rebuild index if is the main group
    			$index = $this->get('wixet.index_manager');
    			$index->rebuild("contacts");
    			//Notify to the user
    			$event = new \Wixet\WixetBundle\Entity\Event();
    			//Virtual object type. It does not exist as object, just in our mind :P
    			$objectType = $em->getRepository('Wixet\WixetBundle\Entity\ObjectType')->findOneBy(array('name' => 'VirtualUserMainGroup'));
    			if($objectType == null){
    				$objectType = new \Wixet\WixetBundle\Entity\ObjectType();
    				$objectType->setName('VirtualUserMainGroup');
    				$em->persist($objectType);
    				$em->flush();
    			}
    			 
    			$event->setProfile($profile);
    			$event->setObjectId($owner->getId());
    			$event->setObjectType($objectType);
    			$em->persist($event);
    			$em->flush();
    		}
    		
    		////
    		if($group->getId() != $mainGroup->getId()){
    			$ws->addProfileToGroup($profile, $group);
    		}
    		$data = array("error" => false);
    	}

    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  $data ));
    }
    
    /**
    * Remove a profile from a group 
    * @Route("/removeGroup/{profileId}/{groupId}", name="_group_remove")
    */
    public function removeProfileToGroupAction($profileId, $groupId)
    {
    	$owner = $this->get('security.context')->getToken()->getUser()->getProfile();
    	$em = $this->get('doctrine')->getEntityManager();
    	 
    	$profile = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($profileId);
    	$group = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->find($groupId);
    	 
    	$data = array("error" => true);
    	//Check the ownership of the group
    	if($owner->getId() == $group->getProfile()->getId()){
    		$ws = $this->get('wixet.permission_manager');
    
    		//If is the main group, this user is removed from all groups of the user
    		$mainGroup = $owner->getMainGroup();
    		$ws->removeProfileFromGroup($profile, $group);
    		if($group->getId() == $mainGroup->getId()){
    			$groups = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->findBy(array('profile' => $owner->getId()));
    			foreach($groups as $group){
    				$ws->removeProfileFromGroup($profile, $group);
    			}
    			//Unbind user
    			$ws->unbindProfile($owner, $profile);
    			//Rebuild index if is the main group
    			$index = $this->get('wixet.index_manager');
    			$index->rebuild("contacts");
    		}
    		$data = array("error" => false);
    		
    	}
    	 
    	
    	 
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  $data ));
    }
}
