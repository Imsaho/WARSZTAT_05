<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContactController extends Controller
{
    /**
     * @Route("/new")
     */
    public function newContactAction()
    {
        return $this->render('ContactBoxBundle:Contact:new_contact.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/edit")
     */
    public function editContactAction()
    {
        return $this->render('ContactBoxBundle:Contact:edit_contact.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/remove")
     */
    public function removeContactAction()
    {
        return $this->render('ContactBoxBundle:Contact:remove_contact.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/show")
     */
    public function showContactAction()
    {
        return $this->render('ContactBoxBundle:Contact:show_contact.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/sowAll")
     */
    public function showAllContactsAction()
    {
        return $this->render('ContactBoxBundle:Contact:show_all_contacts.html.twig', array(
            // ...
        ));
    }

}
