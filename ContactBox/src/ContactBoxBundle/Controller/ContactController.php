<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ContactBoxBundle\Entity\Person;
use ContactBoxBundle\Entity\PersonGroup;
use ContactBoxBundle\Entity\Address;
use ContactBoxBundle\Entity\Email;
use ContactBoxBundle\Entity\Phone;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller {

    public function createContactForm($person) {
        $form = $this->createFormBuilder($person)
                ->setMethod("POST")
                ->add('first_name')
                ->add('last_name')
                ->add('description')
                ->add('save', SubmitType::class)
                ->getForm();
        return $form;
    }

    public function createAddressForm($address, $id) {
        $form = $this->createFormBuilder($address)
                ->setAction($this->generateUrl("add_address", array('id' => $id)))
                ->setMethod("POST")
                ->add('city')
                ->add('street')
                ->add('house_number')
                ->add('apartment_number')
                ->add('address_type')
                ->add('save', SubmitType::class)
                ->getForm();
        return $form;
    }
    
    public function createEmailForm($email, $id) {
        $form = $this->createFormBuilder($email)
                ->setAction($this->generateUrl("add_email", array("id" => $id)))
                ->setMethod("POST")
                ->add('email')
                ->add('email_type')
                ->add('save', SubmitType::class)
                ->getForm();
        return $form;
    }
    
    public function createPhoneForm($phone, $id) {
        $form = $this->createFormBuilder($phone)
                ->setAction($this->generateUrl("add_phone", array('id' => $id)))
                ->setMethod("POST")
                ->add('phone_number')
                ->add('phone_type')
                ->add('save', SubmitType::class)
                ->getForm();
        return $form;
    }

    /**
     * @Route("/new", name="new_get")
     * @Method("get")
     * @Template()
     */
    public function formNewContactAction() {
        $person = new Person();
        $contactForm = $this->createContactForm($person);
        return array(
            'contact_form' => $contactForm->createView());
    }

    /**
     * @Route("/new", name="new_post")
     * @Method({"POST"})
     */
    public function newContactAction(Request $request) {
        $person = new Person();
        $form = $this->createContactForm($person);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            return new Response("Dodano kontakt");
        }
    }

    /**
     * @Route("/{id}/edit", name="edit_get")
     * @Method({"GET"})
     * @Template()
     */
    public function formEditContactAction($id) {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $person = $repository->find($id);
        $address = new Address();
        $email = new Email();
        $phone = new Phone();
        
        $personForm = $this->createContactForm($person);
        $addressForm = $this->createAddressForm($address, $id);
        $emailForm = $this->createEmailForm($email, $id);
        $phoneForm = $this->createPhoneForm($phone, $id);
        
        return array(
            'person_form' => $personForm->createView(),
            'address_form' => $addressForm->createView(),
            'email_form' => $emailForm->createView(),
            'phone_form' => $phoneForm->createView() );
    }

    /**
     * @Route("/{id}/edit")
     * @Method({"POST"})
     */
    public function editContactAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $person = $repository->find($id);

        $form = $this->createContactForm($person);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$person) {
                return new Response("Brak kontaktu o podanym ID");
            } else {
                $person = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return new Response("Edycja zakończona");
            }
        }
    }

    /**
     * @Route("/{id}/remove", name="remove")
     */
    public function removeContactAction($id) {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository("ContactBoxBundle:Person")->find($id);
        if ($person) {
            $em->remove($person);
            $em->flush();
            return new Response("Kontakt został usunięty!");
        } else {
            return new Response("Brak kontaktu o tym numerze ID.");
        }
    }

    /**
     * @Route("/{id}", name="show_by_id")
     * @Template()
     */
    public function showContactAction($id) {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository("ContactBoxBundle:Person")->find($id);
        return array(
            'contact' => $contact);
    }

    /**
     * @Route("/", name="show_all")
     * @Template()
     */
    public function showAllContactsAction() {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $contacts = $repository->findAll();
        return array(
            'contacts' => $contacts);
    }

    /**
     * @Route("/{id}/addAddress", name="add_address")
     * @Method({"POST"})
     */
    public function addAddressAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $person = $repository->find($id);
        $address = new Address();
        
        $form = $this->createAddressForm($address, $id);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $address = $form->getData();
            $address->setPerson($person);
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
            return new Response("Dodano adres");
        }
    }
    
    /**
     * @Route ("/{id}/addEmail", name="add_email")
     * @Method({"POST"})
     */
    public function addEmailAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $person = $repository->find($id);
        $email = new Email();
        
        $form = $this->createEmailForm($email, $id);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $email = $form->getData();
            $email->setPerson($person);
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
            return new Response("Dodano adres e-mail");
        }
    }
    
    /**
     * @Route ("/{id}/addPhone", name="add_phone")
     * @Method({"POST"})
     */
    public function addPhoneAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $person = $repository->find($id);
        $phone = new Phone();
        
        $form = $this->createPhoneForm($phone, $id);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $phone = $form->getData();
            $phone->setPerson($person);
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();
            return new Response("Dodano numer telefonu");
        }
    }

}