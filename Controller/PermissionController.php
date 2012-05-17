<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     */
    public function indexAction()
    {
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
    		    								p.id asgroupId,
    		    								p.name as groupName,
    		    								o.name as objectType,
    		    								\'group\' as type
    	    								FROM Wixet\WixetBundle\Entity\GroupPermission pe LEFT JOIN pe.group p LEFT JOIN pe.objectType o WHERE pe.owner = ?1');
    	$query->setParameter(1,$profile);
    	 
    	$data['groupPermissions'] = $query->getArrayResult();
    	
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  array_merge($data['userPermissions'],$data['groupPermissions'] )));
    }
    
    /**
    * @Route("/{type}/{id}", name="_permission_delete")
    * @Method({"DELETE"})
    */
    public function deleteAction($type, $id)
    {
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
    * @Route("/{type}/{id}", name="_permission_put")
    * @Method({"PUT"})
    */
    public function putAction($type, $id)
    {
    	$data = json_decode(file_get_contents('php://input'),true);
    	$permissionRaw = array("readGranted"=>$data['readGranted'],
    						   "readDenied"=>$data['readDenied'],
    	                       "writeGranted"=> $data['writeGranted'],
    	                     "writeDenied"=> $data['writeDenied']);
    	
    	
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
    		
    		$item = $em->getRepository($permission->getObjectType()->getName())->find($permission->getObjectId());
    		
    		
    		//TODO completar esto
    		$ws = $this->get('wixet.permission_manager');
    		$objectType = $permission->getObjectType()->getName();
    		//TODO cambiar Wixet\WixetBundle\Entity\ItemContainer por una variable de configuración
    		if($type == "profile" && $objectType == "Wixet\WixetBundle\Entity\ItemContainer"){
    			//Updaten profile/album
    			$ws->setPermissionProfileItem($permission->getProfile(), $item, $permissionRaw);
    		}elseif($type == "profile" && $objectType != "Wixet\WixetBundle\Entity\ItemContainer"){
    			//Update profile/item
    			$ws->setPermissionProfileItemContainer($permission->getProfile(), $item, $permissionRaw);
    		}elseif($type == "group" && $objectType == "Wixet\WixetBundle\Entity\ItemContainer"){
    			//Update group/album
    			$ws->setPermissionProfileItem($permission->getGroup(), $item, $permissionRaw);
    		}elseif($type == "group" && $objectType != "Wixet\WixetBundle\Entity\ItemContainer"){
    			//Update group/item
    			$ws->setPermissionGroupItem($permission->getGroup(), $item, $permissionRaw);
    		}
    		
    		$error = false;
    	}
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' =>  array("error"=>$error) ));
    }


}
