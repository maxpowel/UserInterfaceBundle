<?php

namespace Wixet\UserInterfaceBundle\Controller;



use Symfony\Component\BrowserKit\Response;

use Wixet\WixetBundle\Entity\MediaItem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
* @Route("/privateMessage", name="_private_message")
*/

class PrivateMessageController extends Controller
{   
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
    	$msg = new \Wixet\WixetBundle\Entity\PrivateMessage();
    	$em = $this->get('doctrine')->getEntityManager();
    	
    	$receiver = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($data['profile_id']);
    	$msg->setProfile($receiver);
    	$msg->setAuthor($this->get('security.context')->getToken()->getUser()->getProfile());
    	$msg->setPrivateMessageCollection($receiver->getMainPrivateMessageCollection());
    	$msg->setBody($data['body']);
    	$msg->setSubject($data['subject']);
    	
    	if(isset($data['conversation_id'])){
    		//TODO check that the user is already in the conversation
    		$msg->setConversationId($data['conversation_id']);
    		$msg->setIsRoot(false);
    	}else{
    		$msg->setConversationId(uniqid());
    		$msg->setIsRoot(true);
    	}
    	
    	$em->persist($msg);
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
    
    
    


}
