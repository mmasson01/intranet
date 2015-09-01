<?php

namespace Intra\AnnuaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FR3D\LdapBundle\Model\LdapManager;

class AnnuaireController extends Controller
{
    public function indexAction()
    {
    	$ldap = $this->get('intra.ldap.ldap_manager');
    	$users = $ldap->findUsersBy(array());
        return $this->render('IntraAnnuaireBundle:Annuaire:annuaire.html.twig', array('users' => $users) );
    }

    public function searchAction($letter)
    {
    	$ldap = $this->get('intra.ldap.ldap_manager');
    	$users = $ldap->findUsersByWithLetter($letter);
        return $this->render('IntraAnnuaireBundle:Annuaire:annuaire.html.twig', array('users' => $users) );
    }
}

?>