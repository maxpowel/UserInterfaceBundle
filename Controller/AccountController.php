<?php

namespace Wixet\UserInterfaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/account")
 */
class AccountController extends Controller
{
    
    /**
     * @Route("/new", name="_account_new")
     */
    public function newAccountAction()
    {
    	$data = json_decode(file_get_contents('php://input'),true);
    	if($data){
    		$username   = $data['email'];
    		$email      = $data['email'];
    		$password   = $data['password'];
    		$active   = true;
    		$superadmin = false;
    		 
    		$manipulator = $this->get('fos_user.util.user_manipulator');
    		
    		$error = 0;
    		try{
    			$manipulator->create($username, $password, $email, $active, $superadmin);
    		}catch(\Exception $e){
    			$error= 1;
    		}
    		
    		
    		if($error == 0){
	    		//Create main group
	    		$group = new \Wixet\WixetBundle\Entity\ProfileGroup();
	    		$group->setName("Amigos");
	    		//
	    		$album = new \Wixet\WixetBundle\Entity\ItemContainer();
	    		$album->setName("Fotos");
	    		
	    		$root = new \Wixet\WixetBundle\Entity\ItemContainer();
	    		$root->setName("Root");
	    		
	    		$updates = new \Wixet\WixetBundle\Entity\ItemContainer();
	    		$updates->setName("Actualizaciones");
	    		//
	    		$messageCollection = new \Wixet\WixetBundle\Entity\PrivateMessageCollection();
	    		$messageCollection->setName("Recibidos"); 
	    		
	    		//Create main profile
	    		$em = $this->get('doctrine')->getEntityManager();
	    		$user = $em->getRepository('Wixet\WixetBundle\Entity\User')->findOneByEmail($email);
	    		$profile = new \Wixet\WixetBundle\Entity\UserProfile();
	    		$profile->setUser($user);
	    		
	    		
	    		$profile->setFirstName($data['name']);
	    		$profile->setLastName("");
	    		$profile->setPublic(false);
	    		
	    		$group->setProfile($profile);
	    		$profile->setMainItemContainer($album);
	    		$profile->setRootItemContainer($root);
	    		$profile->setUpdatesItemContainer($updates);
	    		$profile->setMainGroup($group);
	    		$profile->setMainPrivateMessageCollection($messageCollection);
	    		
	    		$album->setProfile($profile);
	    		$album->setPublic(false);
	    		$messageCollection->setProfile($profile);
	    		
	    		$root->setProfile($profile);
	    		$updates->setProfile($profile);
	    		

	    		$em->persist($root);
	    		$em->persist($updates);
	    		$em->persist($profile);
	    		$em->persist($album);
	    		$em->persist($group);
	    		$em->persist($messageCollection);
	    		
	    		$em->flush();
	    		
	    		//Add permissions
	    		$ws = $this->get('wixet.permission_manager');
	    		$ws->setItemContainer($album,$root);
	    		$ws->setItemContainer($profile,$root);
	    		$ws->setItemContainer($updates,$root);
	    		
	    		$ws->setPermission($profile,$root, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
	    		$ws->setPermission($profile,$album, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
	    		$ws->setPermission($profile,$profile, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
	    		$ws->setPermission($profile,$updates, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
	    		
	    		$ws->setPermission($group,$profile, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
	    		$ws->setPermission($group,$album, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
	    		$ws->setPermission($group,$updates, array("readGranted"=>true, "readDenied"=>false, "writeGranted"=> true, "writeDenied"=> false));
	    		
	    		
	    		
	    		$data = array("error"=>false, "id"=>$profile->getId(), "name"=>$profile->getFirstName());
	    		
	    		//Update index
	    		$index = $this->get('wixet.index_manager');
	    		$index->rebuild("extensions");
	    		
    		}else
    			$data = array("error"=>true, "code"=>$error);
    		
    	}else{
    		$data = array("error"=>true, "msg"=>"No data provided");
    	}
    	
    	
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }


}
