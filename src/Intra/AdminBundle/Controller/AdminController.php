<?php

namespace Intra\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
  public function interfaceAction()
  {
   $repository = $this->getDoctrine()
   ->getManager()
   ->getRepository('IntraTicketBundle:Ticket');
   $tickets = $repository->getWaitingTickets();

   $fos_service = $this->get('fos_user.user_manager');
   $users = $fos_service->findUsers();

   $repository = $this->getDoctrine()
   ->getManager()
   ->getRepository('IntraForumBundle:Categorie');
   $categories = $repository->getCategories();

   $repository = $this->getDoctrine()
   ->getManager()
   ->getRepository('IntraModuleBundle:Module');
   $modules = $repository->findAll();

   if (isset($_GET['page']))
   {
    return $this->render('IntraAdminBundle:Admin:interface.html.twig', array(
     'tickets' => $tickets,
     'users' => $users,
     'categories' => $categories,
     'modules' => $modules,
     'page' => $_GET['page']
     ));
  }
  return $this->render('IntraAdminBundle:Admin:interface.html.twig', array(
    'tickets' => $tickets,
    'users' => $users,
    'categories' => $categories,
    'modules' => $modules
    ));
}

public function ticketsAction()
{
 $repository = $this->getDoctrine()
 ->getManager()
 ->getRepository('IntraTicketBundle:Ticket');
 $tickets = $repository->getTicketsASC();
 return $this->render('IntraAdminBundle:Ticket:view.html.twig', array('tickets' => $tickets));
}
}
