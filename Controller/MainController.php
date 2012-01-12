<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Wixet\WixetBundle\Entity\ProfileUpdate;
use Wixet\WixetBundle\Entity\ProfileUpdateComment;

use Symfony\Component\BrowserKit\Response;

use Wixet\WixetBundle\Entity\MediaItem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class MainController extends Controller
{
    /**
    * @Route("/test", name="_test")
    */
    public function testAction()
    {
    	$data = array();
    	
    	$em = $this->get('doctrine')->getEntityManager();
    	$md = $em->getRepository('Wixet\WixetBundle\Entity\Album')->find(53);
		$mi = $em->getRepository('Wixet\WixetBundle\Entity\MediaItem')->find(1);
		
    	/*$md = new \Wixet\WixetBundle\Entity\Album();
    	$md->setTitle("TST");
    	$md->setProfile($this->get('security.context')->getToken()->getUser()->getProfile());
    	$md->setPublic(false);
    	
    	$em = $this->get('doctrine')->getEntityManager();
    	$em->persist($md);
    	$em->flush();
    	*/
    	$ws = $this->get('wixet.permission_manager');
    	//$ws->setPermission($mi,$this->get('security.context')->getToken()->getUser()->getProfile(),true,true,false,false);
    	$ws->setPermission($md,$this->get('security.context')->getToken()->getUser()->getProfile(),true,true,true,true);
    	
    	$data['id'] = $md->getId();
    	
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    
    /**
    * @Route("/user", name="_user")
    */
    public function userAction()
    {
    	$data = array();
    	 
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	$data['id'] = $profile->getId();
    	$data['firstName'] = $profile->getFirstName();
    	$data['lastName'] = $profile->getLastName();
    	$data['isOwner'] = true;
    	
    	 
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
    	


    	$models = array();
    		$models[] = array("name"=>"Amigos","id"=>1);
    		$models[] = array("name"=>"Feos","id"=>2);
    		$models[] = array("name"=>"Otros","id"=>3);
    		
    	
    	$data = $models;
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    


}
