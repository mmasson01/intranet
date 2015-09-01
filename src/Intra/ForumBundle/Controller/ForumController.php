<?php

namespace Intra\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Intra\ForumBundle\Entity\Categorie;
use Intra\ForumBundle\Entity\Thread;
use Intra\ForumBundle\Entity\Commentaire;

class ForumController extends Controller
{
    public function indexAction()
    {
      $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraForumBundle:Categorie');
      $categories = $repository->getCategories();
      
      return $this->render('IntraForumBundle:Forum:index.html.twig', array('categories' => $categories));
    }

    public function ajouterCategorieAction()
    {
    	$request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $categorie = new Categorie();
          $categorie->setName($_POST['_name']);
          if ($_POST['_sur_categorie_id'] != 0)
          {
            $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraForumBundle:Categorie');
            $sur_categorie = $repository->findBy(array('id' => $_POST['_sur_categorie_id']));
            $categorie->setSurCategorie($sur_categorie[0]);
          }
          $em = $this->getDoctrine()->getManager();
          $em->persist($categorie);
          $em->flush();         
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'categorie')) );
    }

    public function voirAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraForumBundle:Categorie');
          $categorie = $repository->findBy(array('id' => $_GET['id']));

          if ($categorie)
          {
            if ($categorie[0]->getSousCategories()[0])
            {
              $sous_categories = $categorie[0]->getSousCategories();
              $repository = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('IntraForumBundle:Thread');
              $threads = $repository->getThreadsBy($_GET['id']);

              return $this->render('IntraForumBundle:Forum:voir.html.twig', array(
                'categorie' => $categorie[0],
                'sous_categories' => $sous_categories,
                'threads' => $threads
                ));
            }
            else
            {
              $repository = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('IntraForumBundle:Thread');
              $threads = $repository->getThreadsBy($_GET['id']);

              return $this->render('IntraForumBundle:Forum:voir.html.twig', array(
                'categorie' => $categorie[0],
                'threads' => $threads
                ));
            }
          }
        }
        return $this->redirect( $this->generateUrl('intra_forum') );
    }

    public function formulaireThreadAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraForumBundle:Categorie');
          $categorie = $repository->findBy(array('id' => $_GET['id']));

          if ($categorie)
            return $this->render('IntraForumBundle:Formulaire:thread.html.twig', array(
            'categorie' => $categorie[0]
            ));
        }
        return $this->redirect( $this->generateUrl('intra_forum') );
    }

    public function ajouterThreadAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraForumBundle:Categorie');
          $categorie = $repository->findBy(array('id' => $_POST['_id_categorie']));

          if ($categorie)
          {
            $thread = new Thread();
            $thread->setCategorie($categorie[0]);
            $thread->setSujet($_POST['_sujet']);
            $thread->setAuteur($this->get('security.context')->getToken()->getUser());

            $commentaire = new Commentaire();
            $commentaire->setContenu($_POST['_content']);
            $commentaire->setThread($thread);
            $commentaire->setAuteur($this->get('security.context')->getToken()->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($thread);
            $em->persist($commentaire);
            $em->flush();
            return $this->redirect( $this->generateUrl('intra_forum_voir_categorie', array('id' => $_POST['_id_categorie'])) );
          }
        }
        return $this->redirect( $this->generateUrl('intra_forum') );
    }

    public function voirThreadAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
          $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraForumBundle:Thread');
          $thread = $repository->findBy(array('id' => $_GET['id']));

          if ($thread)
          {
            $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('IntraForumBundle:Commentaire');
            $commentaires = $repository->getCommentairesBy($_GET['id']);

            $categorie = $thread[0]->getCategorie();

            return $this->render('IntraForumBundle:Thread:voir.html.twig', array(
              'thread' => $thread[0],
              'commentaires' => $commentaires,
              'categorie' => $categorie
              ));
          }
        }
        return $this->redirect( $this->generateUrl('intra_forum') );
    }

    public function ajouterCommentaireAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraForumBundle:Thread');
          $thread = $repository->findBy(array('id' => $_POST['_id_thread']));

          if ($thread)
          {
            $commentaire = new Commentaire();
            $commentaire->setContenu($_POST['_content']);
            $commentaire->setThread($thread[0]);
            $commentaire->setAuteur($this->get('security.context')->getToken()->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirect( $this->generateUrl('intra_forum_voir_thread', array('id' => $_POST['_id_thread']) ));
          }
        }
        return $this->redirect( $this->generateUrl('intra_forum') );
    }

    public function ajouterCommentaireCommentaireAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraForumBundle:Commentaire');
          $sur_commentaire = $repository->findBy(array('id' => $_POST['_id_commentaire']));

          if ($sur_commentaire)
          {
            $commentaire = new Commentaire();
            $commentaire->setContenu($_POST['_content']);
            $commentaire->setSurCommentaire($sur_commentaire[0]);
            $commentaire->setAuteur($this->get('security.context')->getToken()->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirect( $this->generateUrl('intra_forum_voir_thread', array('id' => $_POST['_id_thread']) ));
          }
        }
        return $this->redirect( $this->generateUrl('intra_forum') );
    }

    public function removeCategorieAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraForumBundle:Categorie');
            $categorie = $repository->find($_POST['_id']);

            if ($categorie)
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($categorie);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'categorie')) );
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'categorie')) );
    }

    public function removeThreadAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraForumBundle:Thread');
            $thread = $repository->find($_POST['_id']);

            if ($thread)
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($thread);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_forum_voir_categorie', array('id' => $_POST['_id_categorie'])) );
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface') );
    }

    public function removeCommentaireAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraForumBundle:Commentaire');
            $commentaire = $repository->find($_POST['_id']);

            if ($commentaire)
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($commentaire);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_forum_voir_thread', array('id' => $_POST['_id_thread'])) );
        }
        return $this->redirect( $this->generateUrl('intra_forum') );
    }

    public function modifyCategorieAction()
    {
      $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraForumBundle:Categorie');
            $categorie = $repository->find($_POST['_modification_id']);

            if ($categorie)
            {
                $categorie->setName($_POST['_modification_name']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'categorie')) );
        }
        return $this->redirect( $this->generateUrl('intra_admin_interface', array('page' => 'categorie')) );
    }
}
