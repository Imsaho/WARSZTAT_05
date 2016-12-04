<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ContactBoxBundle\Entity\Email;
use Symfony\Component\HttpFoundation\Request;
use ContactBoxBundle\Form\EmailFormType;

class EmailController extends Controller {

    /**
     * @Route ("/{id}/email/add", name="add_email")
     * @Template()
     */
    public function addEmailAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository("ContactBoxBundle:Person")->find($id);

        $email = new Email();
        $emailForm = $this->createForm(EmailFormType::class, $email);
        $emailForm->handleRequest($request);

        if ($emailForm->isSubmitted() && $emailForm->isValid()) {
            $email = $emailForm->getData();
            $email->setPerson($person);
            $em->persist($email);
            $em->flush();

            $url = $this->generateUrl("show_by_id", array(
                'id' => $id));
            $response = $this->redirect($url);
            return $response;
        }

        return array(
            'id' => $id,
            'email_form' => $emailForm->createView()
        );
    }

}