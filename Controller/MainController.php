<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Wixet\WixetBundle\Entity\UserProfile;
use Wixet\WixetBundle\Entity\UserProfileExtension;

use Wixet\WixetBundle\Entity\ProfileUpdate;
use Wixet\WixetBundle\Entity\ProfileUpdateComment;
use Wixet\WixetBundle\Entity\ProfileGroup;

use Symfony\Component\BrowserKit\Response;

use Wixet\WixetBundle\Entity\MediaItem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Wixet\WixetBundle\Entity\Favourite;
use Wixet\WixetBundle\Entity\Cosa;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\ClassLoader\UniversalClassLoader;

class MainController extends Controller
{

	/**
	 * @Route("/changes", name="_changes")
	 */
	public function changesAction()
	{
		//$core = json_decode(file_get_contents("https://api.github.com/networks/maxpowel/WixetBundle/events"));
		$type = $_GET['type'];
		$ch = null;
		if($type == "core"){
			$ch = curl_init("https://api.github.com/networks/maxpowel/WixetBundle/events");
		}else
			$ch = curl_init("https://api.github.com/networks/maxpowel/UserInterfaceBundle/events");


		curl_exec($ch);
		curl_close($ch);

		
		exit;
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $core));

	}
	/**
	 * @Route("/test", name="_test")
	 */
	public function testAction()
	{
		
		
		$data = array();
		 
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		
		/*
		$entityManager = $this->get('doctrine')->getEntityManager();
		$objectType = new \Wixet\WixetBundle\Entity\ObjectType();
		$objectType->setName("sadfsda".rand(1,100));
		$entityManager->persist($objectType);
		$entityManager->flush();
		*/
		//$cosa = new Cosa();
		
		/*
		$ws = $this->get('wixet.permission_manager');
		$permission = array("readGranted"=>true, "readDenied"=> false, "writeGranted"=> true, "writeDenied"=> false);
		$ic = $profile->getMainItemContainer();
		$ws->setPermission($profile, $ic, $permission);
		
		$fetched = $this->fetcher->get("Wixet\WixetBundle\Entity\MediaItem", $this->md->getId(), $this->viewerProfile);
		*/
		/*$index = $this->get('wixet.index_manager');
		$index->rebuild("contacts");
		
		$qm = $this->get('wixet.query_manager');
		$qm->contactSearch($profile,"pp");
		*/
		//To avoid ArgvInput error: no argv index found
		/*$_SERVER['argv'] = array();
		 
		 
		 
		$input = new \Symfony\Component\Console\Input\ArgvInput();
		//$input->setArgument('argv', 'value');
		 
		$output = new \Symfony\Component\Console\Output\ConsoleOutput();

		$command = $this->get('RebuildSearchIndexService');
		$command->run($input,$output);*/
		///////////
		 
		//$em = $this->get('doctrine')->getEntityManager();
		/*$command = $this->getApplication()->find('index:rebuild');
		 $input = new ArrayInput();
		$output = null;
		$returnCode = $command->run($input, $output);
		*/
		/*
		 $em = $this->get('doctrine')->getEntityManager();
		$md = $em->getRepository('Wixet\WixetBundle\Entity\Album')->find(53);
		$mi = $em->getRepository('Wixet\WixetBundle\Entity\MediaItem')->find(1);
		*/
		/*$md = new \Wixet\WixetBundle\Entity\Album();
		 $md->setTitle("TST");
		$md->setProfile($this->get('security.context')->getToken()->getUser()->getProfile());
		$md->setPublic(false);
		 
		$em = $this->get('doctrine')->getEntityManager();
		$em->persist($md);
		$em->flush();
		*/
		 
		/*$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		  
		$album = $em->getRepository('Wixet\WixetBundle\Entity\ItemContainer')->find(1);
		 
		 
		$ws = $this->get('wixet.permission_manager');
		$ws->setPermissionProfileItem($profile,$album, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
		*/
		 
		//$owner = $profile;
		/*$ws = $this->get('wixet.permission_manager');
		$fetcher = $this->get('wixet.fetcher');
		 
		$item = $em->getRepository('Wixet\WixetBundle\Entity\MediaItem')->find(1);
		$itemContainer = $em->getRepository('Wixet\WixetBundle\Entity\ItemContainer')->find(1);
		$group = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->find(1);
		 
		$permission = array();
		 
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$itemContainer = $em->getRepository('Wixet\WixetBundle\Entity\ItemContainer')->find(24);
		$itemContainer = $profile->getMainItemContainer();
		$collection = $fetcher->getCollection($itemContainer, $profile);
		$items = $collection->get();
		echo $profile->getId();
		foreach($items as $item){
		echo $item->getId()."<br>";
		}
		*/
		//$ws->setPermissionProfileItem($profile, $item, $permission);
		//$ws->setItemContainer($item, $itemContainer);
		//$ws->removeProfileFromGroup($profile, $group);
		//$ws->setPermission($mi,$this->get('security.context')->getToken()->getUser()->getProfile(),true,true,false,false);
		//$ws->setPermission($md,$this->get('security.context')->getToken()->getUser()->getProfile(),true,true,true,true);
		 
		//$data['id'] = $md->getId();
		 
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	
	/**
	* @Route("/notification", name="_notification_list")
	*/
	public function eventListAction()
	{
		//TODO cache this event list
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$em = $this->get('doctrine')->getEntityManager();
		
		$query = $em->createQuery('SELECT ot.name as type, count(e.id) as total FROM Wixet\WixetBundle\Entity\Event e JOIN e.objectType ot WHERE e.profile = :profile GROUP BY ot.name');
		$query->setParameter('profile', $profile);
		$data = $query->getArrayResult();
		
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	 * @Route("/user", name="_user_get")
	 * @Method({"GET"})
	 */
	public function getUserAction()
	{
		$data = array();
		$viewer = $this->get('security.context')->getToken()->getUser()->getProfile();
		if(isset($_GET['id'])){
			$ws = $this->get('wixet.fetcher');
			//Only can get it if you are allowed
			$profile = $ws->get("Wixet\WixetBundle\Entity\UserProfile",$_GET['id'],$viewer);
		}else
		$profile = $viewer;
		 
		if($profile){
			$data['id'] = $profile->getId();
			$data['firstName'] = $profile->getFirstName();
			$data['lastName'] = $profile->getLastName();
			$data['updatesAlbumId'] = $profile->getUpdatesItemContainer()->getId();
			$data['isOwner'] = true;
			//$data['mainMediaItem'] = $profile->getMainMediaItem()->getId();
		}else{
			$data['id'] = 0;
		}
		 

		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/user", name="_user_put")
	 * @Method({"PUT"})
	 */
	public function putUserAction()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		//A profile only can be updated by the owner
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		 
		$em = $this->get('doctrine')->getEntityManager();
		 
		if($profile->getFirstName() != $data['firstName'] || $profile->getLastName() != $data['lastName']){
			$profile->setFirstName($data['firstName']);
			$profile->setLastName($data['lastName']);
		 
			$em->flush();
			//Rebuild index
			//TODO esto se limitará en un futuro
			$index = $this->get('wixet.index_manager');
			$index->rebuild("extensions");
			$index->rebuild("contacts");
		}
		
		//Main photo changed
		if(isset($data['mainMediaItem'])){
			$fetcher = $this->get('wixet.fetcher');
			$md = $fetcher->get("Wixet\WixetBundle\Entity\MediaItem",$data['mainMediaItem'],$profile);
			//Only if the user has access
			if($md){
				$mainMd = $profile->getMainMediaItem();
				if($mainMd != null && $mainMd->getId() != $md->getId()){
					$mim = $this->get('wixet.media_item_manager');
					$mim->destroyProfileThumbnail($profile, $mainMd);
					$mim->doProfileThumbnail($profile, $md);
					$profile->setMainMediaItem($md);
					$em->flush();
				}else if($mainMd == null){
					$mim = $this->get('wixet.media_item_manager');
					$mim->doProfileThumbnail($profile, $md);
					$profile->setMainMediaItem($md);
					$em->flush();
				}
			}else{
				$data['mediaItemId'] = $md->getId();
			}
		}
		
		 
		 


		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}


	/**
	 * @Route("/profile/extension", name="_profile_extension_post")
	 * @Method({"POST"})
	 */
	public function postProfileExtensionAction()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		$pe = new UserProfileExtension();
		 
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$pe->setProfile($profile);
		$pe->setBody($data['body']);
		$pe->setTitle($data['title']);
		 
		 
		$em = $this->get('doctrine')->getEntityManager();

		$em->persist($pe);

		$em->flush();

		$data['id'] = $pe->getId();

		//Update index
		$index = $this->get('wixet.index_manager');
		$index->rebuild("extensions");

		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/profile/extension", name="_profile_extension_get")
	 * @Method({"GET"})
	 */
	public function getProfileExtensionAction()
	{
		//Profile extensions are public
		$data = array();


		$em = $this->get('doctrine')->getEntityManager();
		 
		$profile = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($_GET['profile']);
		 
		$q = $em->createQuery("SELECT pe FROM Wixet\WixetBundle\Entity\UserProfileExtension pe where pe.profile = :profile")
		->setParameter('profile', $profile);
		$peList = $q->getResult();

		 
		foreach($peList as $pe){
			$data[] = array("id"=>$pe->getId(),
    						"body"=>$pe->getBody(),
    						"title"=>$pe->getTitle());
		}
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/profile/extension", name="_profile_extension_delete")
	 * @Method({"DELETE"})
	 */
	public function deleteProfileExtensionAction()
	{
		//Profile extensions are public, because of that Wixet fetcher is not used
		$data = array();

		$em = $this->get('doctrine')->getEntityManager();

		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$pe = $em->getRepository('Wixet\WixetBundle\Entity\UserProfileExtension')->find($_GET['id']);

		if($profile->getId() == $pe->getProfile()->getId()){
			$em->remove($pe);
			$em->flush();
		}

		//Update index
		$index = $this->get('wixet.index_manager');
		$index->rebuild("extensions");
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/profile/extension", name="_profile_extension_put")
	 * @Method({"PUT"})
	 */
	public function putProfileExtensionAction()
	{
		$data = json_decode(file_get_contents('php://input'),true);

		$em = $this->get('doctrine')->getEntityManager();

		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$pe = $em->getRepository('Wixet\WixetBundle\Entity\UserProfileExtension')->find($data['id']);

		if($profile->getId() == $pe->getProfile()->getId()){
			$pe->setBody($data['body']);
			$pe->setTitle($data['title']);
			$em->flush();
		}

		//Update index
		$index = $this->get('wixet.index_manager');
		$index->rebuild("extensions");
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	 
	/**
	 * @Route("/", name="_index")
	 * @Template()
	 */
	public function indexAction()
	{
		return array();
	}


	/**
	 * @Route("/newness/comment", name="_newness_comment_post")
	 * @Method({"POST"})
	 */
	public function postNewnessCommentAction()
	{
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$data = json_decode(file_get_contents('php://input'),true);
		$em = $this->get('doctrine')->getEntityManager();
		$ws = $this->get('wixet.fetcher');
		 
		$update = $em->getRepository('Wixet\WixetBundle\Entity\ProfileUpdate')->find($data['updateId']);
		//Only can comment between friends
		$friend = $ws->getWritable("Wixet\WixetBundle\Entity\UserProfile",$update->getProfile()->getId(),$profile, true);
		//If the user are not granted to view the profile, $friend is null
		if($friend != null){
			
			$comment = new ProfileUpdateComment();
			$comment->setAuthor($profile);
			$comment->setBody($data['body']);
			$comment->setProfileUpdate($update);
			$em->persist($comment);
			$em->flush();
			$data['id'] = $comment->getId();
			$data['authorId'] = $profile->getId();
			$data['authorName'] = $profile->getFirstName()." ".$profile->getLastName();
			$data['date'] = $comment->getCreated()->format('Y-m-d H:i:s');
		}else $data = array("error"=>"Not allowed");


		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/newness/comment/{id}", name="_newness_comment_delete")
	* @Method({"DELETE"})
	*/
	public function deleteNewnessCommentAction($id)
	{
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$em = $this->get('doctrine')->getEntityManager();
		$comment = $em->getRepository('Wixet\WixetBundle\Entity\ProfileUpdateComment')->find($id);
		if($id == null || $comment->getAuthor()->getId() != $profile->getId()){
			throw new \Exception("Access denied");
		}else{
			$em->remove($comment);
			$em->flush();
		}
		
		
		$data = array();
	
	
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/newness", name="_newness_get")
	 * @Method({"GET"})
	 */
	public function getNewnessAction()
	{
		$data = array();
		 
		$em = $this->get('doctrine')->getEntityManager();
		
		$ws = $this->get('wixet.fetcher');
		$pageSize = 20;
		$offset = ($_GET['page']-1)*$pageSize;

		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();

		$id = isset($_GET['id'])?$_GET['id']:$profile->getId();


		$friend = $ws->get("Wixet\WixetBundle\Entity\UserProfile",$id,$profile);
		//If the user are not granted to view the profile, $friend is null
		if($friend != null){
			$ot = $em->getRepository( 'Wixet\WixetBundle\Entity\ObjectType' )->findOneBy( array( 'name' => 'Wixet\WixetBundle\Entity\ProfileUpdate'));
			if($ot == null){
				$ot = new \Wixet\WixetBundle\Entity\ObjectType();
				$ot->setName('Wixet\WixetBundle\Entity\Update');
				$em->persist($ot);
				$em->flush();
			}
			//Extralazy association
			$updates = $friend->getUpdates();
			$updateList = $updates->slice($offset, $pageSize);

			foreach ($updateList as $update){
				
				//get likes
				$q = $em->createQuery("SELECT SUM(p.ylike) as likes, SUM(p.dlike) as dlikes FROM Wixet\WixetBundle\Entity\Vote p WHERE p.objectType = :ot AND p.object_id = :object_id")
				->setParameter('ot', $ot)
				->setParameter('object_id', $update->getId());
				$likes = $q->getSingleResult();
				///////
				// I like it?
				$q = $em->createQuery("SELECT SUM(p.ylike) as likes, SUM(p.dlike) as dlikes FROM Wixet\WixetBundle\Entity\Vote p WHERE p.objectType = :ot AND p.object_id = :object_id AND p.profile = :profile")
				->setParameter('ot', $ot)
				->setParameter('object_id', $update->getId())
				->setParameter('profile', $profile);
				$ilike = $q->getSingleResult();
				//
				
				$author = $update->getAuthor();
				 
				$element = array("id"=>$update->getId(), "authorId"=> $author->getId(), "authorName"=> $author->getFirstName()." ".$author->getLastName(), "date"=>$update->getCreated()->format('Y-m-d H:i:s'), "body"=>$update->getBody(), "likes"=>$likes['likes'] ,"dlikes"=> $likes['dlikes'], "likeit"=>$ilike['likes'] ,"dlikeit"=> $ilike['dlikes'], "owner"=> $author->getId() == $profile->getId());
				 
				//Comments
				$comments = $update->getComments();
				$commentList = $comments->slice(0, 5);
				//$totalComments = $comments->count();
				$comments = array();
				foreach ($commentList as $comment){
					$commentAuthor = $comment->getAuthor();
		
					$comments[] = array("id"=>$comment->getId(), "body"=>$comment->getBody(), "authorId"=> $commentAuthor->getId(), "authorName" => $commentAuthor->getFirstName()." ".$commentAuthor->getLastName(), "date"=>$comment->getCreated()->format('Y-m-d H:i:s'), "owner"=> $commentAuthor->getId() == $profile->getId());
				}
				$element['comments'] = $comments;
				$data[] = $element;
			}


		}
		 
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/newness", name="_newness_post")
	 * @Method({"POST"})
	 */
	public function createNewnessAction()
	{
		 
		 
		 
		 
		$data = array();
		$ws = $this->get('wixet.fetcher');
		$pm = $this->get('wixet.permission_manager');
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		/*
		 * TODO: Add this permission on account creation
		$ws = $this->get('wixet.permission_manager');
		$ws->setPermission($profile,$this->get('security.context')->getToken()->getUser()->getProfile(),true,true,false,false);
		*/
		 
		$id = isset($_GET['id'])?$_GET['id']:$profile->getId();

		$friend = $ws->get("Wixet\WixetBundle\Entity\UserProfile",$id,$profile, true);
		//If the user are not granted to view the profile, $friend is null
		if($friend != null){
			$data = json_decode(file_get_contents('php://input'),true);
			$update = new ProfileUpdate();
			$update->setAuthor($profile);
			$update->setProfile($friend);
			$update->setBody($data['body']);
			$em = $this->get('doctrine')->getEntityManager();
			$em->persist($update);
			$em->flush();
			 
			$updatesContainer = $profile->getUpdatesItemContainer();
			$pm->setItemContainer($update,$updatesContainer);
			$author = $update->getAuthor();
			$outData = array("id"=>$update->getId(),"authorId"=> $author->getId(), "authorName"=> $author->getFirstName()." ".$author->getLastName(), "date"=>$update->getCreated()->format('Y-m-d H:i:s'), "body"=>$update->getBody(), "owner"=> true);

			/* Get permissions */
			/* Dont add permission if the group updatesItemContainer has this permission */
			$ot = $em->getRepository("Wixet\WixetBundle\Entity\ObjectType")->findOneBy(array("name"=>"Wixet\WixetBundle\Entity\ItemContainer"));
			$queryGroup = $em->createQuery('SELECT p.id FROM Wixet\WixetBundle\Entity\GroupPermission p WHERE p.object_id = ?1 AND p.objectType = ?2');
			$queryProfile = $em->createQuery('SELECT p.id FROM Wixet\WixetBundle\Entity\ProfilePermission p WHERE p.object_id = ?1 AND p.objectType = ?2');
			$queryGroup->setParameter(1, $updatesContainer->getId());
			$queryGroup->setParameter(2, $ot);
			$allowedGroups = $queryGroup->getArrayResult();
			$allowedGroups = $allowedGroups[0];
			$queryProfile->setParameter(1, $updatesContainer->getId());
			$queryProfile->setParameter(2, $ot);
			$allowedProfiles = $queryProfile->getArrayResult();
			
			//Add permission to groups
			foreach($data['groups'] as $groupId){
				//The group is not in the inherited list
				if(!in_array($groupId, $allowedGroups)){
					$group = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->find($groupId);
					/* check Group exists and the profile is the owner */
					if($group != null && $group->getProfile()->getId() == $profile->getId()){
						$permission = array("readGranted"=>true, "readDenied"=> false, "writeGranted"=> true, "writeDenied"=> false);
						$pm->setPermission($group, $update, $permission);
					}
				}
			}
			
			//Deny access to unselected groups
			foreach($allowedGroups as $groupId){
				//The group is not in the inherited list
				if(!in_array($groupId, $data['groups'])){
					$group = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->find($groupId);
					$permission = array("readGranted"=>false, "readDenied"=> true, "writeGranted"=> false, "writeDenied"=> true);
					$pm->setPermission($group, $update, $permission);
				}
			}
			//
			

		}
		 
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $outData));
	}


	/**
	* @Route("/newness/{id}", name="_newness_delete")
	* @Method({"DELETE"})
	*/
	public function deleteNewnessAction($id)
	{
			
			
			
			
		$data = array("error"=>true);
		$pm = $this->get('wixet.permission_manager');
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$em = $this->get('doctrine')->getEntityManager();
		$update = $em->getRepository("Wixet\WixetBundle\Entity\ProfileUpdate")->find($id);
		
		if($update != null && $update->getProfile()->getId() == $profile->getId()){
			//Remove permissions
			$pm->unprotect($update);
			$em->remove($update);
			$em->flush();
			$data = array("error"=>false);
			
		}
		
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	



	/**
	 * @Route("/favourite", name="_favourite_get")
	 * @Method({"GET"})
	 */
	public function getFavouritesAction()
	{

		 
		 
		//$models = array(array("title"=>"Ey que pasa", "url"=>"prueba"));
		$models = array();
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $models));
	}

	/**
	 * @Route("/personalInfo", name="_personalInfo_get")
	 * @Method({"GET"})
	 */
	public function getPersonalInfoAction()
	{
		//TODO añadir más campos
		$data = array();
		$viewer = $this->get('security.context')->getToken()->getUser()->getProfile();
		if(isset($_GET['id'])){
			$ws = $this->get('wixet.fetcher');
			//Only can get it if you are allowed
			$profile = $ws->get("Wixet\WixetBundle\Entity\UserProfile",$_GET['id'],$viewer);
		}else
		$profile = $viewer;
		 
		if($profile){
			$data['id'] = $profile->getId();
			$data['name'] = $profile->getFirstName()." ". $profile->getLastName();
			$data['city'] = "";
			//$data['mainMediaItem'] = $profile->getMainMediaItem()->getId();
		}else{
			$data['id'] = 0;
		}
		 

		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}




	/**
	 * @Route("/group", name="_group_get")
	 * @Method({"GET"})
	 */
	public function getGroupAction()
	{
		$data = array();
		 
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$em = $this->get('doctrine')->getEntityManager();
		$groups = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->findBy(array('profile' => $profile->getId()));
		 
		 
		$models = array();
		foreach($groups as $group){
			$models[] = array("name"=>$group->getName(),"id"=>$group->getId());
		}
		 
		$data = $models;
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/group", name="_group_post")
	 * @Method({"POST"})
	 */
	public function postGroupAction()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		$pe = new ProfileGroup();
		 
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$pe->setProfile($profile);
		$pe->setName($data['name']);
		 
		 
		$em = $this->get('doctrine')->getEntityManager();

		$em->persist($pe);

		$em->flush();

		$data['id'] = $pe->getId();



		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));

	}

	/**
	 * @Route("/group/{id}", name="_group_delete")
	 * @Method({"DELETE"})
	 */
	public function deleteGroupAction($id)
	{
		$data = array();

		$em = $this->get('doctrine')->getEntityManager();

		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$pe = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->find($id);

		if($profile->getId() == $pe->getProfile()->getId()){
			$em->remove($pe);
			$em->flush();
		}


		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/groupProfiles", name="_grouplist_get")
	 */
	public function getGroupProfilesAction()
	{
		$data = array();
		$id = $_GET['id'];
		$em = $this->get('doctrine')->getEntityManager();

		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$pe = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->find($id);

		if($profile->getId() == $pe->getProfile()->getId()){
			foreach($pe->getProfiles() as $pf)
			$data[] = array("name"=>$pf->getFirstName()." ".$pf->getLastName(), "id"=> $pf->getId());
		}


		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}


	/**
	 * @Route("/profile/contactSearch", name="_profile_contact_search")
	 */
	public function contactSearchAction()
	{
		$data = array();

		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		 
		$em = $this->get('doctrine')->getEntityManager();
		 
		$q = $em->createQuery("SELECT p.id, p.first_name, p.last_name FROM Wixet\WixetBundle\Entity\ProfileGroup pg JOIN pg.profiles p WHERE pg.profile = :profile AND (p.first_name LIKE :query OR p.last_name LIKE :query)")
		->setParameter('profile', $profile)
		->setParameter('query', $_GET['q']);
		$list = $q->getResult();
		 
		foreach($list as $contact){
			$data[] = array("id"=>$contact['id'],
							"firstName"=>$contact['first_name'],
							"lastName"=>$contact['last_name']);
		}

		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/security/group/{groupId}/add/{profileId}", name="_security_group_add")
	 */
	public function securityGroupAddAction($groupId, $profileId)
	{
		$em = $this->get('doctrine')->getEntityManager();

		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		 
		$group = $em->getRepository('Wixet\WixetBundle\Entity\ProfileGroup')->find($groupId);

		//$ws = $this->get('wixet.permission_manager');
		//$ws->setPermission($em->getRepository('Wixet\WixetBundle\Entity\MediaItem')->find(1),$group,true,true,true,true);
		 
		if($group && $group->getProfile()->getId() == $profile->getId()){


			$otherProfile = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($profileId);
			// $group->addProfile($otherProfile);
			// $em->flush();
			//TODO handle this with events
			//Update permissions
			$ws = $this->get('wixet.permission_manager');
			foreach($em->getRepository('Wixet\WixetBundle\Entity\GroupPermission')->findBy(array("group"=>$group->getId())) as $permission){
				$ws->setPermission($em->getRepository('Wixet\WixetBundle\Entity\MediaItem')->find(1),$group,$permission->getReadGranted(),$permission->getWriteGranted(),$permission->getReadDenied(),$permission->getWriteDenied());
			}
			$data = array("error"=>false);
		}else
		$data = array("error"=>true, "msg"=>"access denied");
		 
		//$data = array();
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/vote/{vote}/{objectType}/{objectId}", name="_vote_item")
	* @Method({"POST"})
	*/
	public function voteItemAction($vote, $objectType, $objectId)
	{
		$data = array();
		
		$em = $this->get('doctrine')->getEntityManager();
		$ws = $this->get('wixet.fetcher');
		
		$objectType = "Wixet\WixetBundle\Entity\\".$objectType;
		
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		
		$item = $ws->get($objectType,$objectId,$profile);

		if($item != null){
			
			$ot = $em->getRepository( 'Wixet\WixetBundle\Entity\ObjectType' )->findOneBy( array( 'name' => $objectType));
			if($ot == null){
				$ot = new \Wixet\WixetBundle\Entity\ObjectType();
				$ot->setName($objecType);
				$em->persist($ot);
				$em->flush();
			}
			
			$voteObj = new \Wixet\WixetBundle\Entity\Vote();
			$voteObj->setProfile($profile);
			$voteObj->setObjectId($item->getId());
			$voteObj->setObjectType($ot);
			if($vote == 1){
				$voteObj->setLike(true);
				$voteObj->setDontlike(false);
			}else{
				$voteObj->setLike(false);
				$voteObj->setDontlike(true);
			}
			
			$em->persist($voteObj);
			$em->flush();
			//TODO cache votes
			$data = array("error"=>false);
		}
		else
			$data = array("error"=>true, "msg"=>"access denied");
			
		//$data = array();
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/vote/{vote}/{objectType}/{objectId}", name="_unvote_item")
	* @Method({"DELETE"})
	*/
	public function unVoteItemAction($vote, $objectType, $objectId)
	{
		$data = array();
	
		$em = $this->get('doctrine')->getEntityManager();
		$ws = $this->get('wixet.fetcher');
	
		$objectType = "Wixet\WixetBundle\Entity\\".$objectType;
	
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		
		$ot = $em->getRepository( 'Wixet\WixetBundle\Entity\ObjectType' )->findOneBy( array( 'name' => $objectType));
		if($ot == null){
			$ot = new \Wixet\WixetBundle\Entity\ObjectType();
			$ot->setName($objecType);
			$em->persist($ot);
			$em->flush();
		}
		
		$like = false;
		$dlike = false;
		if($vote == 1){
			$like = true;
		}else{
			$dlike = true;
		}
		
		$query = $em->createQuery('DELETE FROM Wixet\WixetBundle\Entity\Vote v WHERE v.profile = :profile AND v.objectType = :objectType AND v.object_id = :object_id AND v.ylike = :like AND v.dlike = :dlike');
		$query->setParameter('profile', $profile);
		$query->setParameter('objectType', $ot);
		$query->setParameter('object_id', $objectId);
		$query->setParameter('like', $like);
		$query->setParameter('dlike', $dlike);
		$data = $query->execute();
		
			
		//$data = array();
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

}
