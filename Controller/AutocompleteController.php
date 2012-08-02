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
* @Route("/autocomplete", name="_autocomplete")
*/

class AutocompleteController extends Controller
{
	/**
	* @Route("/city", name="_autocomplete_city")
	*/
	public function getCityAction()
	{
	
		/*$pmc = $this->get('security.context')->getToken()->getUser()->getProfile()->getAlbums();*/
		/*$ws = $this->get('wixet.fetcher');
		$lista = $ws->getCollection(null,$this->get('security.context')->getToken()->getUser()->getProfile(),"Wixet\WixetBundle\Entity\Album");
		 
		$pmc = $lista->get(0,100);//Get all
		$data = array();
		foreach ($pmc as $collection){
			$data[] = array("id"=>$collection->getId(), "name"=> $collection->getTitle());
		}*/
		//$data[]=array("id"=>0, "name"=>"MAIN");
		 $data = array(array("id"=>1,"name"=>"Pisol"), array("id"=>2,"name"=>"Villa"));
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/contacts", name="_autocomplete_contacts")
	*/
	public function getContactAction()
	{
		
		$data = array();
		$qm = $this->get('wixet.query_manager');
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		foreach($qm->contactSearch($profile, $_GET['q']) as $contact){
			$data[] = array("id"=>$contact->getId(),"value"=>$contact->getFirstName()." ".$contact->getLastName());
		}
			
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/contactsGroups", name="_autocomplete_contacts_groups")
	*/
	public function getContactGroupAction()
	{
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$data = array();
		$em = $this->get('doctrine')->getEntityManager();

		
		$qm = $this->get('wixet.query_manager');
		
		foreach($qm->contactSearch($profile, $_GET['q']."*") as $contact){
			$data[] = array("id"=>$contact->getId(),"value"=>$contact->getFirstName()." ".$contact->getLastName(), "data"=>"profile");
		}
		
		/*
		//Profile search (simple without sphinx index)
		
		$query = $em->createQuery("SELECT g.id, g.first_name, g.last_name FROM Wixet\WixetBundle\Entity\ProfileGroup p JOIN p.profiles g WHERE p = ?1 AND (g.first_name LIKE ?2 OR g.last_name LIKE ?3)");
		$query->setParameter(1, $profile->getMainGroup());
		$query->setParameter(2, $_GET['q']."%");
		$query->setParameter(3, $_GET['q']."%");
		
		foreach($query->getArrayResult() as $result){
			$data[] = array("id"=>$result['id'],"value"=>$result['first_name']." ".$result['last_name'], "data"=>"profile");
		}*/
		//Group search (simple without sphinx index)
		
		$query = $em->createQuery("SELECT g.id, g.name FROM Wixet\WixetBundle\Entity\ProfileGroup g WHERE g.profile = ?1 AND g.name LIKE ?2 ");
		$query->setParameter(1, $profile);
		$query->setParameter(2, $_GET['q']."%");
		
		foreach($query->getArrayResult() as $result){
			$data[] = array("id"=>$result['id'],"value"=>$result['name'], "data"=>"group");
		}
			
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
			
	}
	
	
	/**
	* @Route("/groups", name="_autocomplete_groups")
	*/
    public function getGroups(){
    	$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$data = array();
		$em = $this->get('doctrine')->getEntityManager();
		
    	$query = $em->createQuery("SELECT g.id, g.name FROM Wixet\WixetBundle\Entity\ProfileGroup g WHERE g.profile = ?1 AND g.name LIKE ?2 ");
    	$query->setParameter(1, $profile);
    	$query->setParameter(2, $_GET['q']."%");
    	 
    	foreach($query->getArrayResult() as $result){
    		$data[] = array("id"=>$result['id'],"value"=>$result['name'], "data"=>"group");
    	}
    		
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }


}
