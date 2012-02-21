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
     * @Route("/register", name="_account_register")
     */
    public function startAction()
    {
    	$data = array("error"=>false);
    	return $this->render('UserInterfaceBundle:Main:data.json.twig', array('data' => $data));
    }


}
