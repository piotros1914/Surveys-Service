<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()mplate()
     * 
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/panel", name="panel")
     * @Template()
     */
    public function panelAction()
    {
    	return array();
    }
    
}
