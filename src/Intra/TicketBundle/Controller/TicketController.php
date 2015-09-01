<?php

namespace Intra\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Intra\TicketBundle\Entity\Ticket;
use Intra\TicketBundle\Entity\Reply;

class TicketController extends Controller
{
    public function viewAction()
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntraTicketBundle:Ticket');
        $tickets = $repository->getTickets($this->get('security.context')->getToken()->getUser()->getId());
        return $this->render('IntraTicketBundle:Ticket:view.html.twig', array('tickets' => $tickets)
        );
    }

    public function createAction()
    {
        return $this->render('IntraTicketBundle:Ticket:create.html.twig');
    }

    public function ajouterAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
          $ticket = new Ticket();
          $ticket->setTitre($_POST['_titre']);
          $ticket->setContenu($_POST['_content']);
          $ticket->setPriorite($_POST['_priorite']);
          $ticket->setEtat("En attente");
          $ticket->setAuteur($this->get('security.context')->getToken()->getUser());
          $em = $this->getDoctrine()->getManager();
          $em->persist($ticket);
          $em->flush();
          return $this->redirect( $this->generateUrl('intra_ticket_view') );
        }
    }

    public function readAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'GET' && isset($_GET['id'])) {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraTicketBundle:Ticket');
            $ticket = $repository->find($_GET['id']);

            if ($ticket
                && ($ticket->getAuteur() == $this->get('security.context')->getToken()->getUser()
                    || $this->get('security.context')->isGranted('ROLE_ADMIN')))
            {
                $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraTicketBundle:Reply');
                $replys = $repository->getReplys($ticket->getId());

                $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraUserBundle:User');
                $admins = $repository->getAdmins();

                return $this->render('IntraTicketBundle:Ticket:read.html.twig', array(
                    'ticket' => $ticket,
                    'replys' => $replys,
                    'admins' => $admins
                    ));
            }
        }
        return $this->redirect( $this->generateUrl('intra_ticket_view') );
    }

    public function replyAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            if (isset($_POST['_content']) && $_POST['_content'])
            {
                $reply = new Reply();
                $reply->setContenu($_POST['_content']);
                $reply->setAuteur($this->get('security.context')->getToken()->getUser());
                $reply->setTicketId($_POST['_id']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($reply);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_ticket_read', array('id' => $_POST['_id'])) );
        }
        return $this->redirect( $this->generateUrl('intra_ticket_view') );
    }

    public function changeStateAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraTicketBundle:Ticket');
            $ticket = $repository->find($_POST['_id']);
            if ($ticket && isset($_POST['_etat']))
            {
                $ticket->setEtat($_POST['_etat']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_ticket_read', array('id' => $_POST['_id'])) );
        }
        return $this->redirect( $this->generateUrl('intra_ticket_view') );
    }

    public function changeAdminAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraTicketBundle:Ticket');
            $ticket = $repository->find($_POST['_id']);

            if ($ticket && isset($_POST['_admin_id']))
            {
                $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraUserBundle:User');
                $admin = $repository->findBy(array('id' => $_POST['_admin_id']));

                if ($admin)
                    $ticket->setAdmin($admin[0]);
                else
                    $ticket->setAdmin(null);
                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_admin_interface') );
        }
        return $this->redirect( $this->generateUrl('intra_ticket_view') );
    }

    public function removeAction()
    {
        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntraTicketBundle:Ticket');
            $ticket = $repository->find($_POST['_id']);
            if ($ticket)
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($ticket);
                $em->flush();
            }
            return $this->redirect( $this->generateUrl('intra_admin_tickets') );
        }
        return $this->redirect( $this->generateUrl('intra_admin_view') );
    }
}

?>