<?php

namespace Wixet\UserInterfaceBundle\Controller;
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
     * @Route("/", name="_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
    * @Route("/newness", name="_newness_get")
    * @Method({"GET"})
    */
    public function getNewnessAction()
    {
    	$data = array();
    	$data[] = array("id"=>"1", "authorName"=> "hola", "date"=>"34", "body"=>"ddd"); 
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }

    /**
    * @Route("/newness", name="_newness_post")
    * @Method({"POST"})
    */
    public function createNewnessAction()
    {
    	$data = array("error"=>"false");
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    
    
    
    /**
    * @Route("/messageFolder", name="_messageFolder_get")
    * @Method({"GET"})
    */
    public function getMessageFolderAction()
    {
    	$pmc = $this->get('security.context')->getToken()->getUser()->getProfile()->getPrivateMessagesCollections();
    	$data = array();
    	foreach ($pmc as $collection){
    		$data[] = array("id"=>$collection->getId(), "name"=> $collection->getTitle());
    	}
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    
    /**
     * @Route("/messageFolder", name="_messageFolder_post")
     * @Method({"POST"})
     */
    public function createMessageFolderAction()
    {
    	$data = json_decode(file_get_contents('php://input'),true);
    	$md = new \Wixet\WixetBundle\Entity\PrivateMessageCollection();
    	$md->setTitle($data['name']);
    	$md->setProfile($this->get('security.context')->getToken()->getUser()->getProfile());
    	
    	$em = $this->get('doctrine')->getEntityManager();
    	$em->persist($md);
    	$em->flush();
    	$data['id'] = $md->getId();

    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    
	/**
     * @Route("/messageFolder", name="_messageFolder_put")
     * @Method({"PUT"})
     */
    public function putMessageFolderAction()
    {
    	$data = json_decode(file_get_contents('php://input'),true);
    	$name = trim($data['name']);
    	$pmc = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\PrivateMessageCollection')->find($_GET['id']);
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	
    	if($profile->getId() == $pmc->getProfile()->getId() && strlen($name) > 0){
    		$pmc->setTitle($name);
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->flush();
    	}

    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => array()));
    }
    
	/**
     * @Route("/messageFolder", name="_messageFolder_delete")
     * @Method({"DELETE"})
     */
    public function deleteMessageFolderAction()
    {
    	$pmc = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\PrivateMessageCollection')->find($_GET['id']);
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	
    	if($profile->getId() == $pmc->getProfile()->getId() && strlen($name) > 0){
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->remove($pmc);
    		$em->flush();
    	}

    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => array()));
    }
    
    /**
    * @Route("/message", name="_message_get")
    * @Method({"GET"})
    */
    public function getMessageAction()
    {
    	$pageSize = 10;
    	$offset = isset($_GET['page'])? ($_GET['page']-1)*$pageSize: 0;
    	$data = array();
    	
    	$pmc = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\PrivateMessageCollection')->find($_GET['folder']);
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	//Ensure that the user is the owner
		$query = $em->createQuery(
    		'SELECT p FROM Wixet\WixetBundle\Entity\PrivateMessageCollection p WHERE p.id = :folder AND p.profile = :profile')
		->setParameter('folder', $_GET['folder'])
		->setParameter('profile', $profile);

		$pmc = $query->getSingleResult();
		
    	//if($offset == 0){
    		//Is the first page, then return total pages
			$query = $em->createQuery(
	    		'SELECT count(m.subject) FROM Wixet\WixetBundle\Entity\PrivateMessage m WHERE m.isRoot = true AND m.private_message_collection = :collection')
			->setParameter('collection', $pmc);
			$data['total'] = $query->getSingleScalarResult();		
			$data['psize'] = $pageSize;
    	//}
    	
		//Now get root messages
		$query = $em->createQuery(
    		'SELECT m.subject, m.conversation_id FROM Wixet\WixetBundle\Entity\PrivateMessage m WHERE m.isRoot = true AND m.private_message_collection = :collection')
		->setParameter('collection', $pmc)
		->setMaxResults($pageSize)
		->setFirstResult($offset);

    	
    	
    	$models = array();
    	foreach ($query->getResult() as $message){
    		$models[] = array("id"=>$message['conversation_id'], "subject"=> $message['subject']);
    	}
    	
    	$data['models'] = $models;
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    
    /**
     * @Route("/message", name="_message_post")
     * @Method({"POST"})
     */
    public function createMessageAction()
    {
    	$data = json_decode(file_get_contents('php://input'),true);
    	$md = new \Wixet\WixetBundle\Entity\PrivateMessageCollection();
    	$md->setTitle($data['name']);
    	$md->setProfile($this->get('security.context')->getToken()->getUser()->getProfile());
    	
    	$em = $this->get('doctrine')->getEntityManager();
    	$em->persist($md);
    	$em->flush();

    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    
    /**
    * @Route("/message", name="_message_delete")
    * @Method({"DELETE"})
    */
    public function deleteMessageAction()
    {
    	$em = $this->get('doctrine')->getEntityManager();
    	$query = $em->createQuery(
	    		'DELETE FROM Wixet\WixetBundle\Entity\PrivateMessage m WHERE m.conversation_id = :id and m.profile = :profile')
			->setParameter('id', $_GET['id'])
			->setParameter('profile', $this->get('security.context')->getToken()->getUser()->getProfile());
		$query->execute();
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => array()));
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
    * @Route("/album", name="_album_get")
    * @Method({"GET"})
    */
    public function getAlbumAction()
    {

    	/*$pmc = $this->get('security.context')->getToken()->getUser()->getProfile()->getAlbums();*/
    	$ws = $this->get('wixet.fetcher');
    	$lista = $ws->getCollection(null,$this->get('security.context')->getToken()->getUser()->getProfile(),"Wixet\WixetBundle\Entity\Album");
    	
    	$pmc = $lista->get(0,100);
    	$data = array();
    	foreach ($pmc as $collection){
    		$data[] = array("id"=>$collection->getId(), "name"=> $collection->getTitle());
    	}
    	$data[]=array("id"=>0);
    	
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    
	/**
     * @Route("/album", name="_album_post")
     * @Method({"POST"})
     */
    public function createAlbumAction()
    {
    	$data = json_decode(file_get_contents('php://input'),true);
    	$md = new \Wixet\WixetBundle\Entity\Album();
    	$md->setTitle($data['name']);
    	$md->setProfile($this->get('security.context')->getToken()->getUser()->getProfile());
    	$md->setPublic(false);
    	
    	$em = $this->get('doctrine')->getEntityManager();
    	$em->persist($md);
    	$em->flush();
    	
    	$ws = $this->get('wixet.permission_manager');
    	$ws->setPermission($md,$this->get('security.context')->getToken()->getUser()->getProfile(),true,true,false,false);
    	
    	$data['id'] = $md->getId();
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
    
    
	/**
    * @Route("/photo", name="_photo_get")
    * @Method({"GET"})
    */
    public function getPhotoAction()
    {
    	$pageSize = 10;
    	$offset = isset($_GET['page'])? ($_GET['page']-1)*$pageSize: 0;
    	$data = array();
    	
    	
		$data['total'] = 100;		
		$data['psize'] = $pageSize;
    	

    	
    	
    	$models = array();
    		$models[] = array("id"=>1);
    		$models[] = array("id"=>2);
    		$models[] = array("id"=>3);
    		$models[] = array("id"=>1);
    		$models[] = array("id"=>2);
    		$models[] = array("id"=>3);
    		$models[] = array("id"=>1);
    		$models[] = array("id"=>2);
    		$models[] = array("id"=>3);
    		$models[] = array("id"=>1);
    		$models[] = array("id"=>2);
    		$models[] = array("id"=>3);
    		$models[] = array("id"=>1);
    		$models[] = array("id"=>2);
    		$models[] = array("id"=>3);
    		$models[] = array("id"=>1);
    		$models[] = array("id"=>2);
    		$models[] = array("id"=>3);
    		
    	
    	$data['models'] = $models;
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
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
    
    
	/**
    * @Route("/upload", name="_upload_post")
    * @Method({"POST"})
    */
    public function postUploadAction()
    {
    	$data = array();
    	

    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }
}
