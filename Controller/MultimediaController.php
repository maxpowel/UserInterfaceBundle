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
* @Route("/multimedia", name="_multimedia")
*/

class MultimediaController extends Controller
{
	/**
	* @Route("/album", name="_album_get")
	* @Method({"GET"})
	*/
	public function getAlbumAction()
	{
	
		/*$pmc = $this->get('security.context')->getToken()->getUser()->getProfile()->getAlbums();*/
		$ws = $this->get('wixet.fetcher');
		$lista = $ws->getCollection(null,$this->get('security.context')->getToken()->getUser()->getProfile(),"Wixet\WixetBundle\Entity\Album");
		 
		$pmc = $lista->get(0,100);//Get all
		$data = array();
		foreach ($pmc as $collection){
			$data[] = array("id"=>$collection->getId(), "name"=> $collection->getTitle());
		}
		//$data[]=array("id"=>0, "name"=>"MAIN");
		 
		 
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
		 
		 
	
		$data['psize'] = $pageSize;
		 
	
		 
		 
		$models = array();
		 
		$fetcher = $this->get('wixet.fetcher');
		$album = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\Album')->find($_GET['folder']);
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$collection = $fetcher->getCollection($album,$profile);
		 
		$data['total'] =$collection->getSize();
		foreach($collection->getRaw($offset,$pageSize) as $item){
			$models[] = array("id"=>$item['id']);
		}
	
	
		 
		$data['models'] = $models;
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
    


}
