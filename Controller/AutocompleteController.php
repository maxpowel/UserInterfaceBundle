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
	
		/*$pmc = $this->get('security.context')->getToken()->getUser()->getProfile()->getAlbums();*/
		/*$ws = $this->get('wixet.fetcher');
			$lista = $ws->getCollection(null,$this->get('security.context')->getToken()->getUser()->getProfile(),"Wixet\WixetBundle\Entity\Album");
			
		$pmc = $lista->get(0,100);//Get all
		$data = array();
		foreach ($pmc as $collection){
		$data[] = array("id"=>$collection->getId(), "name"=> $collection->getTitle());
		}*/
		//$data[]=array("id"=>0, "name"=>"MAIN");
		$data = array(array("id"=>1,"value"=>"Pisol"), array("id"=>2,"value"=>"Villa"));
			
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/contactsGroups", name="_autocomplete_contacts_groups")
	*/
	public function getContactGroupAction()
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
		$data = array(array("id"=>1,"value"=>"Pisol", "data"=>"profile"), array("id"=>2,"value"=>"Amiguetes", "data"=>"group"));
			
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	
    


}
