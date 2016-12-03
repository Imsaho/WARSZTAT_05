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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use ContactBoxBundle\Form\PersonFormType;
use ContactBoxBundle\Form\AddressFormType;
use ContactBoxBundle\Form\EmailFormType;
use ContactBoxBundle\Form\PhoneFormType;

class ContactController extends Controller {

    public function createGroupForm($group, $id, $options) {
        $form = $this->createFormBuilder($group)
                ->setAction($this->generateUrl("add_group", array(
                            'id' => $id)))
                ->setMethod("POST")
                ->add('group_name', ChoiceType::class, array(
                    'choices' => $options,
                    'choices_as_values' => true,
                    'choice_label' => 'getGroupName',
                    'choice_value' => 'getGroupName'))
                ->add('save', SubmitType::class)
                ->getForm();
        return $form;
    }

    public function createSearchForm() {
        $form = $this->createFormBuilder()
                ->setMethod("POST")
                ->add('last_name', TextType::class, array(
                    'label' => 'first or last name is like...'
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Wyszukaj',
                    'attr' => array(
                        'class' => 'btn btn-outline btn-success btn-lg')))
                ->getForm();
        return $form;
    }

    /**
     * @Route("/new", name="new")
     * @Template()
     */
    public function formNewContactAction(Request $request) {
        $person = new Person();
        $form = $this->createForm(PersonFormType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            $id = $person->getId();
            $url = $this->generateUrl("show_by_id", array(
                'id' => $id));
            $response = $this->redirect($url);
            return $response;
        }

        return array(
            'person_form' => $form->createView());
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @Template()
     */
    public function formEditContactAction($id) {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");

        $person = $repository->find($id);
        $address = new Address();
        $email = new Email();
        $phone = new Phone();

        $personForm = $this->createForm(PersonFormType::class, $person);
        $addressForm = $this->createForm(AddressFormType::class, $address);
        $emailForm = $this->createForm(EmailFormType::class, $email);
        $phoneForm = $this->createForm(PhoneFormType::class, $phone);

        return array(
            'person_form' => $personForm->createView(),
            'address_form' => $addressForm->createView(),
            'email_form' => $emailForm->createView(),
            'phone_form' => $phoneForm->createView(),
            'id' => $id);
    }

    /**
     * @Route("/{id}/edit")
     * @Method({"POST"})
     * @Template("ContactBoxBundle:Contact:message.html.twig")
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
                return array(
                    'message' => "Edycja zakończona!");
            }
        }
    }

    /**
     * @Route("/{id}/remove", name="remove")
     * @Template("ContactBoxBundle:Contact:message.html.twig")
     */
    public function removeContactAction($id) {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository("ContactBoxBundle:Person")->find($id);
        if ($person) {
            $em->remove($person);
            $em->flush();
            return array(
                'message' => "Kontakt został usunięty!");
        } else {
            return array(
                'message' => "Brak kontaktu o tym numerze ID.");
        }
    }

    /**
     * @Route("/{id}", name="show_by_id")
     * @Template()
     */
    public function showContactAction($id) {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository("ContactBoxBundle:Person")->find($id);

        return array(
            'contact' => $person
        );
    }

    /**
     * @Route("/", name="show_all")
     * @Method({"GET"})
     * @Template()
     */
    public function showAllContactsAction() {

        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $contacts = $repository->findBy([], ['lastName' => 'ASC']);
        $searchForm = $this->createSearchForm();
        return array(
            'contacts' => $contacts,
            'search_form' => $searchForm->createView());
    }

    /**
     * @Route ("/", name="show_by_name")
     * @Template()
     * @Method({"POST"})
     */
    public function showContactsByNameAction(Request $request, $string) {

        $string = $request->request->get('form')['last_name'];

        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository("ContactBoxBundle:Person")->findByFirstOrLastName($string);
        return ['contacts' => $contacts];
    }

    /**
     * @Route("/{id}/addAddress", name="add_address")
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
     * @Route ("/{id}/addEmail", name="add_email")
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

    /**
     * @Route ("/{id}/addPhone", name="add_phone")
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

    /**
     * @Route ("/{id}/addGroup", name="add_group")
     * @Method({"POST"})
     */
    public function addGroupAction(Request $request, $id) {
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $allGroups = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup")->findAll();

        $groupName = $request->request->get('form')['group_name'];
        $group = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup")->findByGroupName($groupName);

        $group = new PersonGroup();

        $form = $this->createGroupForm($group, $id, $allGroups);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $group = $form->getData();

            $person->addGroup($group);
            $group->addPerson($person);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return new Response("Użytkownika dodano do grupy");
        }
    }

}