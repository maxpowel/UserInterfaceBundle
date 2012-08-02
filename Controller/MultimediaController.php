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
	
		$data = array();
		
		$em = $this->get('doctrine')->getEntityManager();
		$fetcher = $this->get('wixet.fetcher');
		
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$owner = $profile;
		if(isset($_GET['profile'])){
			$owner = $em->getRepository('Wixet\WixetBundle\Entity\UserProfile')->find($_GET['profile']);
		}
		
		$itemContainer = $owner->getRootItemContainer();
		
		
		$collection = $fetcher->getCollection($itemContainer, $profile, "Wixet\WixetBundle\Entity\ItemContainer");
		$items = $collection->get();
		
		//No load updates container
		$updatesContainer = $owner->getUpdatesItemContainer();
		
		foreach ($items as $collection){
			if($collection->getId() != $updatesContainer->getId())
				$data[] = array("id"=>$collection->getId(), "name"=> $collection->getName());
		}
		 
		 
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	 * @Route("/album", name="_album_post")
	 * @Method({"POST"})
	 */
	public function createAlbumAction()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		$md = new \Wixet\WixetBundle\Entity\ItemContainer();
		$md->setName($data['name']);
		$md->setProfile($this->get('security.context')->getToken()->getUser()->getProfile());
		$md->setPublic(false);
		 
		$em = $this->get('doctrine')->getEntityManager();
		$em->persist($md);
		$em->flush();
		 
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$rootItemContainer = $profile->getRootItemContainer();
		
		//Add permissions
		$ws = $this->get('wixet.permission_manager');
		$ws->setItemContainer($md,$rootItemContainer);
		$ws->setPermissionProfileItem($profile,$md, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
		
		 
		$data['id'] = $md->getId();
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/album", name="_put_post")
	* @Method({"PUT"})
	*/
	public function updateAlbumAction()
	{
		$em = $this->get('doctrine')->getEntityManager();
		$data = json_decode(file_get_contents('php://input'),true);
		$ic = $em->getRepository('Wixet\WixetBundle\Entity\ItemContainer')->find($_GET['id']);
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		
		if($ic->getProfile()->getId() == $profile->getId()){
			$ic->setName($data['name']);
			$em->flush();
		}
		
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
	
	/**
	* @Route("/album", name="_delete_post")
	* @Method({"DELETE"})
	*/
	public function deleteAlbumAction()
	{
		$em = $this->get('doctrine')->getEntityManager();
		$data = json_decode(file_get_contents('php://input'),true);
		$ic = $em->getRepository('Wixet\WixetBundle\Entity\ItemContainer')->find($_GET['id']);
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
	
		//Check if the album is empty
		$query = $em->createQuery('SELECT count(p.id) as total FROM Wixet\WixetBundle\Entity\ItemContainerHasItems p WHERE p.itemContainer = :itemContainer');
		$query->setParameter("itemContainer", $ic);
		$res = $query->getSingleResult();
		
		if($res['total'] > 0){
			throw new \Exception("Itemcontainer is not empty");
		}else{
		
			if($ic->getProfile()->getId() == $profile->getId()){
				//Unprotect item
				$ws = $this->get('wixet.permission_manager');
				$ws->unprotect($ic);
				$em->remove($ic);
				$em->flush();
			}
		}
	
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
		$album = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\ItemContainer')->find($_GET['folder']);
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$collection = $fetcher->getCollection($album,$profile,"Wixet\WixetBundle\Entity\MediaItem");
		//$collection = $fetcher->getCollection($album,$profile);
		$data['total'] =$collection->getSize();
		foreach($collection->getRaw($offset,$pageSize) as $item){
			$models[] = array("id"=>$item['id']);
		}
	
	
		 
		$data['models'] = $models;
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
    


}
