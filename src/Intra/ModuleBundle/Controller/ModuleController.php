<?php

namespace Intra\ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Intra\ModuleBundle\Entity\Module;
use Intra\ModuleBundle\Entity\Activite;
use Intra\ForumBundle\Entity\Categorie;
use Intra\ModuleBundle\Entity\Bareme;
use Intra\ModuleBundle\Form\BaremeType;

class ModuleController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraModuleBundle:Module');
        $modules = $repository->findAll();

        return $this->render('IntraModuleBundle:Module:index.html.twig', array('modules' => $modules));
    }

    public function voirModuleAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Module');
          $module = $repository->find(array('id' => $_GET['id']));

          if ($module)
          {
            if (isset($_GET['error']))
              return $this->render('IntraModuleBundle:Module:voir.html.twig', array(
                'module' => $module,
                'error' => "Le délait d'inscription est dépassé"
                ));
            return $this->render('IntraModuleBundle:Module:voir.html.twig', array('module' => $module));
          }
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function formulaireModificationModuleAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Module');
          $module = $repository->find(array('id' => $_POST['_id']));

          if ($module)
             return $this->render('IntraModuleBundle:Formulaire:modification_module.html.twig', array('module' => $module));
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function modifierModuleAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Module');
          $module = $repository->find(array('id' => $_POST['_id_module']));

          if ($module)
          {
            $categorie = $module->getCategorie();
            $categorie->setName($_POST['_name']);

            $module->setName($_POST['_name']);
            $module->setDescription($_POST['_description']);
            $module->setDateDebutInscription(new \Datetime($_POST['_date_debut_inscription']));
            $module->setDateFinInscription(new \Datetime($_POST['_date_fin_inscription']));
            $module->setDateDebutModule(new \Datetime($_POST['_date_debut_module']));
            $module->setDateFinModule(new \Datetime($_POST['_date_fin_module']));
            $module->setValeure($_POST['_valeure']);
            $module->setNbPlaces($_POST['_restriction']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();
          }
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
    }

    public function inscriptionModuleAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Module');
          $module = $repository->find(array('id' => $_GET['id']));

          if ($module)
          {
            if ($module->getDateFinInscription() < new \Datetime())
            {
              return $this->redirect( $this->generateUrl('intra_module_voir_module', array(
                'id' => $module->getId(),
                'error' => "0"
                )) );
            }
            else
            {
              $module->addInscrit($this->get('security.context')->getToken()->getUser());
              $em = $this->getDoctrine()->getManager();
              $em->persist($module);
              $em->flush();
              return $this->redirect( $this->generateUrl('intra_module_voir_module', array('id' => $module->getId())) );
            }
          }      
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function desinscriptionModuleAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Module');
          $module = $repository->find(array('id' => $_GET['id']));

          if ($module)
          {
            $module->removeInscrit($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();
            return $this->redirect( $this->generateUrl('intra_module_voir_module', array('id' => $module->getId())) );
          }      
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function inscritModuleAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Module');
          $module = $repository->find(array('id' => $_GET['id']));

          if ($module)
            return $this->render('IntraModuleBundle:Module:inscrit_module.html.twig', array('module' => $module));  
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function formulaireModuleAction()
    {
    	if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
    	{
    		return $this->render('IntraModuleBundle:Formulaire:module.html.twig');
    	}
    	return $this->render('IntraModuleBundle:Formulaire:index.html.twig');
    }

    public function ajouterModuleAction()
    {
    	$request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $module = new Module();
          $categorie = new Categorie();

          $categorie->setName($_POST['_name']);
          $categorie->setModule($module);

          $module->setName($_POST['_name']);
          $module->setCategorie($categorie);
          $module->setDescription($_POST['_description']);
          $module->setDateDebutInscription(new \Datetime($_POST['_date_debut_inscription']));
          $module->setDateFinInscription(new \Datetime($_POST['_date_fin_inscription']));
          $module->setDateDebutModule(new \Datetime($_POST['_date_debut_module']));
          $module->setDateFinModule(new \Datetime($_POST['_date_fin_module']));
          $module->setValeure($_POST['_valeure']);
          $module->setNbPlaces($_POST['_restriction']);

          $em = $this->getDoctrine()->getManager();
          $em->persist($module);
          $em->flush();
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
    }

    public function removeModuleAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraModuleBundle:Module');
            $module = $repository->find($_POST['_id']);

            if ($module)
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($module);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
    }

    public function formulaireActiviteAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $request = $this->get('request');
            if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
                $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraModuleBundle:Module');
                $module = $repository->find($_GET['id']);

                if ($module)
                    return $this->render('IntraModuleBundle:Formulaire:activite.html.twig', array('module' => $module));
            }
        }
        return $this->render('IntraModuleBundle:Module:index.html.twig');
    }

    public function voirActiviteAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Activite');
          $activite = $repository->find(array('id' => $_GET['id']));

          $module = $activite->getModule();


          if ($activite)
          {
            if ($activite->getDateFinActivite() < new \Datetime())
            {
              $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraCorrectionBundle:Correction');
              $corrections_user = $repository->getCorrectionUser($this->get('security.context')->getToken()->getUser()->getId(), $activite->getId());
              $corrections_to_user = $repository->getCorrectionToUser($this->get('security.context')->getToken()->getUser()->getId(), $activite->getId());

              return $this->render('IntraModuleBundle:Activite:voir.html.twig', array(
              'module' => $module,
              'activite' => $activite,
              'corrections_user' => $corrections_user,
              'corrections_to_user' => $corrections_to_user
              ));

            }

            if (isset($_GET['error']))
              return $this->render('IntraModuleBundle:Activite:voir.html.twig', array(
                'activite' => $activite,
                'module' => $module,
                'error' => "Le délait d'inscription est dépassé"
                ));
            return $this->render('IntraModuleBundle:Activite:voir.html.twig', array(
              'module' => $module,
              'activite' => $activite
              ));
          }
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function ajouterActiviteAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraModuleBundle:Module');
          $module = $repository->find($_POST['_id_module']);

          $activite = new Activite();
          $categorie = new Categorie();

          $categorie->setName($_POST['_name']);
          $categorie->setSurCategorie($module->getCategorie());
          $categorie->setModule($module);

          $activite->setModule($module);
          $activite->setCategorie($categorie);
          $activite->setName($_POST['_name']);
          $activite->setDescription($_POST['_description']);
          $activite->setDateDebutInscription(new \Datetime($_POST['_date_debut_inscription']));
          $activite->setDateFinInscription(new \Datetime($_POST['_date_fin_inscription']));
          $activite->setDateDebutActivite(new \Datetime($_POST['_date_debut_activite']));
          $activite->setDateFinActivite(new \Datetime($_POST['_date_fin_activite']));
          $activite->setTailleGroupe($_POST['_taille_groupe']);
          $activite->setNbPeers($_POST['_nb_peers']);
          $activite->setType($_POST['_type']);
          $activite->setNbPlaces($_POST['_restriction']);

          $em = $this->getDoctrine()->getManager();
          $em->persist($activite);
          $em->flush();         
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
    }

    public function formulaireModificationActiviteAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Activite');
          $activite = $repository->find(array('id' => $_POST['_id']));

          if ($activite)
             return $this->render('IntraModuleBundle:Formulaire:modification_activite.html.twig', array('activite' => $activite));
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function modifierActiviteAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Activite');
          $activite = $repository->find(array('id' => $_POST['_id_activite']));

          if ($activite)
          {
            $categorie = $activite->getCategorie();
            $categorie->setName($_POST['_name']);

            $activite->setName($_POST['_name']);
            $activite->setDescription($_POST['_description']);
            $activite->setDateDebutInscription(new \Datetime($_POST['_date_debut_inscription']));
            $activite->setDateFinInscription(new \Datetime($_POST['_date_fin_inscription']));
            $activite->setDateDebutActivite(new \Datetime($_POST['_date_debut_activite']));
            $activite->setDateFinActivite(new \Datetime($_POST['_date_fin_activite']));
            $activite->setTailleGroupe($_POST['_taille_groupe']);
            $activite->setNbPeers($_POST['_nb_peers']);
            $activite->setType($_POST['_type']);
            $activite->setNbPlaces($_POST['_restriction']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();
          }
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
    }

    public function inscriptionActiviteAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Activite');
          $activite = $repository->find(array('id' => $_GET['id']));

          if ($activite)
          {
            if ($activite->getDateFinInscription() < new \Datetime())
            {
              return $this->redirect( $this->generateUrl('intra_module_voir_activite', array(
                'id' => $activite->getId(),
                'error' => "0"
                )) );
            }
            else
            {
              $activite->addInscrit($this->get('security.context')->getToken()->getUser());
              $em = $this->getDoctrine()->getManager();
              $em->persist($activite);
              $em->flush();
              return $this->redirect($this->generateUrl('intra_module_voir_activite', array('id' => $activite->getId())) ); 
            }
          }      
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function desinscriptionActiviteAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Activite');
          $activite = $repository->find(array('id' => $_GET['id']));

          if ($activite)
          {
            $activite->removeInscrit($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();
            return $this->redirect( $this->generateUrl('intra_module_voir_activite', array('id' => $activite->getId())) );
          }      
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function inscritActiviteAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Activite');
          $activite = $repository->find(array('id' => $_GET['id']));

          if ($activite)
            return $this->render('IntraModuleBundle:Activite:inscrit.html.twig', array('activite' => $activite));  
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function removeActiviteAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraModuleBundle:Activite');
            $activite = $repository->find($_POST['_id']);

            if ($activite)
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($activite);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
    }

     public function ajouterBaremeAction(Request $request, Activite $activite)
    {
        $bareme = new Bareme();
        $bareme->setActivite($activite);
        $form = $this->createForm(new BaremeType(), $bareme);
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($bareme);
          $em->flush();
          
          $this->get('session')->getFlashBag()->add('info', 'Bareme bien enregistré !');

          return $this->redirect( $this->generateUrl('intra_module_show_bareme', array(
            'baremeid' => $bareme->getId(),
            'activiteid' => $activite->getId(),
            )));
        }

        return $this->render('IntraModuleBundle:bareme:ajouterbareme.html.twig', array(
        'form' => $form->createView(),
        'activite' => $activite,
        'bareme' => $bareme));
    }

    public function modifierBaremeAction(Request $request, $activiteid, $baremeid)
    {
        $activite = $this->getDoctrine()
                  ->getRepository('IntraModuleBundle:Activite')
                  ->findOneBy(array('id' => $activiteid));
        $bareme = $this->getDoctrine()
                  ->getRepository('IntraModuleBundle:Bareme')
                  ->findOneBy(array('id' => $baremeid));
        $form = $this->createForm(new BaremeType(), $bareme);
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($bareme);
          $em->flush();
          
          $this->get('session')->getFlashBag()->add('info', 'Bareme bien modifié !');

          return $this->redirect( $this->generateUrl('intra_module_show_bareme', array(
            'baremeid' => $bareme->getId(),
            'activiteid' => $activite->getId(),
            )));
        }

        return $this->render('IntraModuleBundle:bareme:modifierbareme.html.twig', array(
        'form' => $form->createView(),
        'activite' => $activite,
        'bareme' => $bareme));
    }

    public function showBaremeAction($activiteid, $baremeid)
    {
        $bareme = $this->getDoctrine()
                  ->getRepository('IntraModuleBundle:Bareme')
                  ->findOneBy(array('id' => $baremeid));

        return $this->render('IntraModuleBundle:Bareme:showBareme.html.twig', array(
          'bareme' => $bareme,
          ));
    }

    public function removeBaremeAction($activiteid, $baremeid)
    {
        $activite = $this->getDoctrine()
                  ->getRepository('IntraModuleBundle:Activite')
                  ->findOneBy(array('id' => $activiteid));
        $bareme = $this->getDoctrine()
                  ->getRepository('IntraModuleBundle:Bareme')
                  ->findOneBy(array('id' => $baremeid));

        if ($activite && $bareme)
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bareme);
            $em->flush();
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
    }
}
