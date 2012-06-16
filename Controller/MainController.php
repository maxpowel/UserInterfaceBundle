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
		
		$index = $this->get('wixet.index_manager');
		$index->rebuild("contacts");
		
		$qm = $this->get('wixet.query_manager');
		$qm->contactSearch($profile,"pp");
		
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
			$data['isOwner'] = true;
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
		 
		$profile->setFirstName($data['firstName']);
		$profile->setLastName($data['lastName']);
		 
		$em->flush();
		 
		 


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
		$friend = $ws->get("Wixet\WixetBundle\Entity\UserProfile",$update->getProfile()->getId(),$profile);
		//If the user are not granted to view the profile, $friend is null
		if($friend != null){
			$comment = new ProfileUpdateComment();
			$comment->setAuthor($profile);
			$comment->setBody($data['body']);
			$comment->setProfileUpdate($update);
			$em->persist($comment);
			$em->flush();
			$data['id'] = $comment->getId();
			$data['authorName'] = $profile->getFirstName()." ".$profile->getLastName();
			$data['date'] = $comment->getCreated()->format('Y-m-d H:i:s');
		}else $data = array("error"=>"Not allowed");


		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}

	/**
	 * @Route("/newness", name="_newness_get")
	 * @Method({"GET"})
	 */
	public function getNewnessAction()
	{
		$data = array();
		 
		$ws = $this->get('wixet.fetcher');
		$pageSize = 20;
		$offset = ($_GET['page']-1)*$pageSize;

		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();

		$id = isset($_GET['id'])?$_GET['id']:$profile->getId();


		$friend = $ws->get("Wixet\WixetBundle\Entity\UserProfile",$id,$profile);
		//If the user are not granted to view the profile, $friend is null
		if($friend != null){
			//Extralazy association
			$updates = $friend->getUpdates();
			$updateList = $updates->slice($offset, $pageSize);

			foreach ($updateList as $update){
				$author = $update->getAuthor();
				 
				$element = array("id"=>$update->getId(), "authorName"=> $author->getFirstName()." ".$author->getLastName(), "date"=>$update->getCreated()->format('Y-m-d H:i:s'), "body"=>$update->getBody());
				 
				//Comments
				$comments = $update->getComments();
				$commentList = $comments->slice(0, 5);
				//$totalComments = $comments->count();
				$comments = array();
				foreach ($commentList as $comment){
					$author = $comment->getAuthor();
					$comments[] = array("id"=>$comment->getId(), "body"=>$comment->getBody(), "authorName" => $author->getFirstName()." ".$author->getLastName(), "date"=>$comment->getCreated()->format('Y-m-d H:i:s'));
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
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		/*
		 * TODO: Add this permission on account creation
		$ws = $this->get('wixet.permission_manager');
		$ws->setPermission($profile,$this->get('security.context')->getToken()->getUser()->getProfile(),true,true,false,false);
		*/
		 
		$id = isset($_GET['id'])?$_GET['id']:$profile->getId();
		 
		$friend = $ws->get("Wixet\WixetBundle\Entity\UserProfile",$id,$profile);
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
			 
			$author = $update->getAuthor();
			$data = array("id"=>$update->getId(), "authorName"=> $author->getFirstName()." ".$author->getLastName(), "date"=>$update->getCreated()->format('Y-m-d H:i:s'), "body"=>$update->getBody());

		}
		 
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}





	/**
	 * @Route("/favourite", name="_favourite_get")
	 * @Method({"GET"})
	 */
	public function getFavouritesAction()
	{

		 
		 
		$models = array(array("title"=>"Ey que pasa", "url"=>"prueba"));
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $models));
	}

	/**
	 * @Route("/personalInfo", name="_personalInfo_get")
	 * @Method({"GET"})
	 */
	public function getPersonalInfoAction()
	{

		 
		 
		$models = array("name"=>"Alvaro", "city"=>"Palencia");
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $models));
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

}
