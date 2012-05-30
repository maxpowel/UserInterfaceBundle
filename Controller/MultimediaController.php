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
		
		$itemContainer = $owner->getMainItemContainer();
		
		
		$collection = $fetcher->getCollection($itemContainer, $profile, "Wixet\WixetBundle\Entity\ItemContainer");
		$items = $collection->get();
		
		foreach ($items as $collection){
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
		$mainItemContainer = $profile->getMainItemContainer();
		
		//Add permissions
		$ws = $this->get('wixet.permission_manager');
		$ws->setItemContainer($md,$mainItemContainer);
		$ws->setPermissionProfileItem($profile,$md, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
		
		 
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
		$album = $this->getDoctrine()->getRepository('Wixet\WixetBundle\Entity\ItemContainer')->find($_GET['folder']);
		$profile = $this->get('security.context')->getToken()->getUser()->getProfile();
		$collection = $fetcher->getCollection($album,$profile,"Wixet\WixetBundle\Entity\MediaItem");
		 
		$data['total'] =$collection->getSize();
		foreach($collection->getRaw($offset,$pageSize) as $item){
			$models[] = array("id"=>$item['id']);
		}
	
	
		 
		$data['models'] = $models;
		return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
	}
    


}
