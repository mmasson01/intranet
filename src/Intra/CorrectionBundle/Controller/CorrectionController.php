<?php

namespace Intra\CorrectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Intra\CorrectionBundle\Entity\Correction;
use Intra\ModuleBundle\Entity\Activite;
use Intra\UserBundle\Entity\User;

class CorrectionController extends Controller
{
    public function generationPeersAction()
    {
       $request = $this->get('request');
       if ($request->getMethod() == 'POST') {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraModuleBundle:Activite');
          $activite = $repository->find(array('id' => $_POST['_id_activite']));

          if ($activite)
          {
          	$inscrits = $activite->getInscrit();
          	$nbpeers = $activite->getNbPeers();

          	$repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraUserBundle:User');
           	$users = $repository->findAll();

           	$repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraCorrectionBundle:Correction');

           	$em = $this->getDoctrine()->getManager();

            for($i = 0; $i < $nbpeers; $i++)
            {
            	foreach ($inscrits as $corrige)
            	{
          			$correcteur = $users[rand(0, (count($users) - 1))];
          			while ($correcteur === $corrige)
          				$correcteur = $users[rand(0, (count($users) - 1))];
          			if ($repository->getCorrection($correcteur->getId(), $corrige->getId(), $activite->getId())
                  || $repository->getCorrection($corrige->getId(), $correcteur->getId(), $activite->getId()))
          			{
                  print_r("Error Correction Already Exist\n");
                }
                else
                {
	          			$correction = new Correction();

	          			$correction->setCorrige($corrige);
	          			$correction->setActivite($activite);
	          			$correction->setCorrecteur($correcteur);
	          			$correction->setNote(0);
	          			$correction->setEnregistree(false);
	          			$em->persist($correction);
                  $em->flush();
          			}
          		}
          	}
          }
       }
       return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'modules')) );
    }

    public function faireCorrectionAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraCorrectionBundle:Correction');

          $correction = $repository->find(array('id' => $_GET['id']));

          if ($correction && $correction->getCorrecteur() == $this->get('security.context')->getToken()->getUser() && !$correction->getEnregistree())
          {
            $bareme = $correction->getActivite()->getBareme();

            return $this->render('IntraCorrectionBundle:Correction:voir.html.twig', array(
            'correction' => $correction,
            'bareme' => $bareme
            ));
          }
        }
        return $this->redirect( $this->generateUrl('intra_module') );
    }

    public function enregistrerAction()
    {
       $request = $this->get('request');
       if ($request->getMethod() == 'POST') {
          $repository = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('IntraCorrectionBundle:Correction');

          $correction = $repository->find(array('id' => $_POST['_id_correction']));

          if ($correction)
          {
            $correction->setNote($_POST['_note']);
            $correction->setEnregistree(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($correction);
            $em->flush();

            $activite = $correction->getActivite();

            return $this->redirect( $this->generateUrl('intra_module_voir_activite', array('id' => $activite->getId())) );
          }
      }
      return $this->redirect( $this->generateUrl('intra_module') );

    }
}
