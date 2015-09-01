<?php

namespace Intra\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FR3D\LdapBundle\Model\LdapManager;

class UserController extends Controller
{
    public function userAction($login)
    {
    	$ldap = $this->get('intra.ldap.ldap_manager');
    	$user = $ldap->findUserByUsername($login);
    	if (!$user)
    		return $this->render('IntraUserBundle:User:error.html.twig', array(
      	'login'  => $login,
      	));

    	$cn = $user->getName();
    	$mail = $user->getMail();

       	return $this->render('IntraUserBundle:User:user.html.twig', array(
      	'login'  => $login, 'cn' => $cn, 'mail' => $mail,
      	));
    }

    public function searchAction()
    {
    	$q = $_GET['_q'];
    	$ldap = $this->get('intra.ldap.ldap_manager');
    	$user = $ldap->findUserBy(array('cn' => $q));
    	if ($user)
    		$q = $user->getLogin();
      else
        $user = $ldap->findUserBy(array('uid' => $q));
      if ($user)
        $q = $user->getLogin();
      else
      {
        $users = $ldap->findUsersBy(array('cn' => $q));
        $users2 = $ldap->findUsersBy(array('uid' => $q));
        if ($users || $users2)
          return $this->render('IntraAnnuaireBundle:Annuaire:annuaire.html.twig', array('users' => $users, 'users2' => $users2) );
      }
    	return $this->userAction($q);
    }

    public function updateAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          $fos_service = $this->get('fos_user.user_manager');
          $user = $fos_service->findUserBy(array('id' => $_POST['_id']));
          if ($user)
          {
              if ($user->isEnabled())
                $user->setEnabled(false);
              else
                $user->setEnabled(true);
              $fos_service->updateUser($user, true);
          }
          return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'utilisateur')) );
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'utilisateur')) );
    }
}

?>