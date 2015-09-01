<?php

namespace Intra\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('IntraMainBundle:Accueil:index.html.twig');
    }

    public function menuAction()
    {
    	return $this->render('IntraMainBundle:Accueil:menu.html.twig');
    }
}

?>