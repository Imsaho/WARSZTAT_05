<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ContactBoxBundle\Entity\Phone;
use Symfony\Component\HttpFoundation\Request;
use ContactBoxBundle\Form\PhoneFormType;

class PhoneController extends Controller {

    /**
     * @Route ("/{id}/phone/add", name="add_phone")
     * @Template()
     */
    public function addPhoneAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository("ContactBoxBundle:Person")->find($id);

        $phone = new Phone();
        $phoneForm = $this->createForm(PhoneFormType::class, $phone);
        $phoneForm->handleRequest($request);

        if ($phoneForm->isSubmitted() && $phoneForm->isValid()) {
            $phone = $phoneForm->getData();
            $phone->setPerson($person);
            $em->persist($phone);
            $em->flush();

            $url = $this->generateUrl("show_by_id", array(
                'id' => $id));
            $response = $this->redirect($url);
            return $response;
        }

        return array(
            'id' => $id,
            'phone_form' => $phoneForm->createView()
        );
    }

}