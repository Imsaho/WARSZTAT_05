<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ContactBoxBundle\Entity\Address;
use Symfony\Component\HttpFoundation\Request;
use ContactBoxBundle\Form\AddressFormType;

class AddressController extends Controller {

    /**
     * @Route("/{id}/address/add", name="add_address")
     * @Template()
     */
    public function addAddressAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository("ContactBoxBundle:Person")->find($id);

        $address = new Address();
        $addressForm = $this->createForm(AddressFormType::class, $address);
        $addressForm->handleRequest($request);

        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $address = $addressForm->getData();
            $address->setPerson($person);
            $em->persist($address);
            $em->flush();

            $url = $this->generateUrl("show_by_id", array(
                'id' => $id));
            $response = $this->redirect($url);
            return $response;
        }

        return array(
            'id' => $id,
            'address_form' => $addressForm->createView()
        );
    }

    /**
     * @Route("/{id}/address/{address_id}/edit", name="edit_address")
     * @Template()
     */
    public function editAddressAction(Request $request, $id, $address_id) {
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository("ContactBoxBundle:Address")->find($address_id);

        $addressForm = $this->createForm(AddressFormType::class, $address);
        $addressForm->handleRequest($request);

        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $address = $addressForm->getData();
            $em->flush();

            $url = $this->generateUrl("show_by_id", array(
                'id' => $id));
            $response = $this->redirect($url);
            return $response;
        }

        return array(
            'id' => $id,
            'address_id' => $address_id,
            'address_form' => $addressForm->createView()
        );
    }

    /**
     * @Route("/{id}/address/{address_id}/remove", name="remove_address")
     */
    public function removeAddressAction($id, $address_id) {
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository("ContactBoxBundle:Address")->find($address_id);
        if ($address) {
            $em->remove($address);
            $em->flush();
            return $this->redirectToRoute('show_by_id', array(
                        'id' => $id
            ));
        }
        return $this->redirectToRoute('show_by_id', array(
                    'id' => $id
        ));
    }

}