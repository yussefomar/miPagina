<?php

namespace Proyecto\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    
    public function loginAction(){
         $authenticationUtils=$this->get('security.authentication_utils');
        $error=$authenticationUtils->getLastAuthenticationError();
        $lastUsername=$authenticationUtils->getLastUsername();
        
        return $this->render('ProyectoUserBundle:Security:login.html.twig',array('lastUsername'=>$lastUsername,'error'=>$error));
    }
    
    public function loginCheckAction(){
        
    }
}
