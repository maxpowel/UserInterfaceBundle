<?php

namespace Wixet\UserInterfaceBundle\Controller;



use Symfony\Component\BrowserKit\Response;
use Doctrine\ORM\Query\ResultSetMapping;
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
    		$data[] = array("id"=>$collection->getId(), "name"=> $collection->getName());
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
    	$md->setName($data['name']);
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
    		$pmc->setName($name);
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
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	//Check if folder is empty
    	$query = $em->createQuery('SELECT count(p.id) as total FROM Wixet\WixetBundle\Entity\PrivateMessage p WHERE p.private_message_collection = :pmc');
    	$query->setParameter("pmc", $pmc);
    	$res = $query->getSingleResult();
    	
    	if($res['total'] > 0){
    		throw new \Exception("Folder is not empty");
    	}else{
	    	if($profile->getId() == $pmc->getProfile()->getId()){
	    		//Is the main album?
	    		if($profile->getMainPrivateMessageCollection()->getId() == $pmc->getId()){
	    			throw new \Exception("Main message collection cannot be removed");
	    		}else{
		    		$em->remove($pmc);
		    		$em->flush();
	    		}
	    	}
    	}

    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => array()));
    }
    
    /**
    * @Route("/message", name="_message_get")
    * @Method({"GET"})
    */
    public function getMessageAction()
    {
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	/* Remove events */
    	$query = $em->createQuery('DELETE FROM Wixet\WixetBundle\Entity\Event e WHERE e.profile = :profile AND e.objectType = :objectType')
    	->setParameter('profile', $profile)
    	->setParameter('objectType', $em->getRepository("Wixet\WixetBundle\Entity\ObjectType")->findOneBy(array("name"=>"Wixet\WixetBundle\Entity\PrivateMessage")));
    	$query->execute();
    	/***************/
    	$pageSize = 10;
    	$offset = isset($_GET['page'])? ($_GET['page']-1)*$pageSize: 0;
    	$data = array();
    	
    	$pmc = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\PrivateMessageCollection')->find($_GET['folder']);
    	
    	
    	//Ensure that the user is the owner
		if($profile->getId() == $pmc->getProfile()->getId()){
			
			//Using native sql
			//Total conversations
			$rsm = new ResultSetMapping();
			$rsm->addScalarResult('total','total');
			$query = $em->createNativeQuery('SELECT count(*) as total FROM ( SELECT id FROM private_message WHERE private_message_collection_id = ? GROUP BY conversation_id) groups', $rsm);
			$query->setParameter(1, $pmc->getId());
			$data['total'] = $query->getSingleScalarResult();
			$data['psize'] = $pageSize;
			////
			//Requested data
			$rsm = new ResultSetMapping();
			$rsm->addEntityResult('Wixet\WixetBundle\Entity\PrivateMessage', 'pm');
			$rsm->addFieldResult('pm', 'id', 'id');
			$rsm->addFieldResult('pm', 'conversation_id', 'conversation_id');
			$rsm->addFieldResult('pm', 'subject', 'subject');
			$rsm->addFieldResult('pm', 'created', 'created');
			$rsm->addFieldResult('pm', 'is_read', 'is_read');
			
			
			$rsm->addJoinedEntityResult("Wixet\WixetBundle\Entity\UserProfile", "up", "pm", "author");
			$rsm->addFieldResult('up', 'author_id', 'id');
			$rsm->addFieldResult('up', 'first_name', 'first_name');
			$rsm->addFieldResult('up', 'last_name', 'last_name');
			
			
			$query = $em->createNativeQuery('SELECT pm.id,pm.conversation_id,pm.subject, pm.created, pm.is_read, up.first_name, up.last_name, up.id as author_id FROM '
										   .'(select id,conversation_id,max(created) as created from private_message group by conversation_id) grouped '
										   .'JOIN private_message pm using (conversation_id,created) '
										   .'JOIN user_profile up ON (pm.profile_id = up.id) '
										   .'WHERE pm.private_message_collection_id = ? '
										   .'LIMIT ? OFFSET ?', $rsm);
			
			$query->setParameter(1, $pmc->getId());
			$query->setParameter(2, $pageSize);
			$query->setParameter(3, $offset);
			
			
			$models = array();
			foreach ($query->getResult() as $message){
				$author = $message->getAuthor();
				$models[] = array("id"=>$message->getConversationId(),
								  "subject"=>$message->getSubject(),
								  "date"=> $message->getCreated()->format('Y-m-d H:i:s'),
								  "isRead" => $message->getIsRead(),
								  "author"=> array("firstName"=>$author->getFirstName(), "lastName"=>$author->getLastName())
				);
			}

			$data['models'] = $models;
		
		}
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
    	$author = $this->get('security.context')->getToken()->getUser()->getProfile();
    	
    	if(isset($data['receiver_id'])){
    		$type = "profile";
    		if(isset($data['receiver_type']))
    			$type = $data['receiver_type'];
    		
    		if($type == "profile"){
    			$receiver = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($data['receiver_id']);
    		}else{
    			
    		}
    		$msg->setConversationId(uniqid());
    	}else{
    		//When replying a message, the profile_id is not required. The profile_id is obtained by using the info in other messages
    		$query = $em->createQuery('SELECT m FROM Wixet\WixetBundle\Entity\PrivateMessage m JOIN m.profile p JOIN m.author a WHERE m.conversation_id = :id')
    		->setParameter('id', $data['conversation_id']);
    		$query->setMaxResults(1);
    		//The conversation must exists
    		$auxMsg = $query->getSingleResult();
    		
    		//Get who is the receiver and ensure that the author can send messages to this conversation
    		$auxProfile = $auxMsg->getProfile();
    		if($auxProfile->getId() == $author->getId()){
    			$receiver = $auxMsg->getAuthor();
    			$msg->setConversationId($data['conversation_id']);
    		}elseif($author->getId() == $auxMsg->getAuthor()->getId()){ 
    			$receiver = $auxProfile;
    			$msg->setConversationId($data['conversation_id']);
    		}
    		
    	}
    	
    	$msg->setProfile($receiver);
    	$msg->setAuthor($author);
    	$msg->setPrivateMessageCollection($receiver->getMainPrivateMessageCollection());
    	$msg->setBody($data['body']);
    	if(isset($data['subject']))
    		$msg->setSubject($data['subject']);
    	else
    		$msg->setSubject(substr($data['body'],0,20));
    	
    	$msg->setIsRead(false);
    	$em->persist($msg);
    	$em->flush();
    	
    	$data = array("body" => $msg->getBody(),
    	    		  "author" => array("id"=>$author->getId(),"firstName"=>$author->getFirstName(), "lastName"=>$author->getLastName()),
    	    		  "date"=> $msg->getCreated()->format('Y-m-d H:i:s'),
    	    		  "conversation_id"=> $msg->getConversationId()
    	);

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
    * @Route("/conversation", name="_conversation_get")
    * @Method({"GET"})
    */
    public function getConversationAction()
    {
    	$data = array();
    	$em = $this->get('doctrine')->getEntityManager();
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
    	$query = $em->createQuery('SELECT pm.body, pm.created, a.id, a.first_name, a.last_name FROM Wixet\WixetBundle\Entity\PrivateMessage pm '
    							 .'JOIN pm.author a '
    							 .'WHERE pm.conversation_id = :id AND (pm.author = :author OR pm.profile = :profile) ORDER BY pm.created DESC')
    			 ->setParameter('id', $_GET['id'])
    			 //Ensure that the user can view this conversation
    			 ->setParameter('author', $profile)
    			 ->setParameter('profile', $profile);
    	
    	
    	foreach($query->getResult() as $message){
    		$data[] = array("body" => $message['body'],
    						"author" => array("id"=>$message['id'],"firstName"=>$message['first_name'], "lastName"=>$message['last_name']),
    						"date"=> $message['created']
    		);
    	}
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }


}
