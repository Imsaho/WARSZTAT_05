<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ContactBoxBundle\Entity\Person;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use ContactBoxBundle\Form\PersonFormType;

class ContactController extends Controller {

    public function createSearchForm() {
        $form = $this->createFormBuilder()
                ->setMethod("POST")
                ->add('last_name', TextType::class, array(
                    'label' => 'wpisz szukane imię lub nazwisko: '
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
    public function newContactAction(Request $request) {
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
    public function editContactAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");

        $person = $repository->find($id);

        $personForm = $this->createForm(PersonFormType::class, $person);
        $personForm->handleRequest($request);

        if ($personForm->isSubmitted() && $personForm->isValid()) {
            if (!$person) {
                return new Response("Brak kontaktu o podanym ID");
            } else {
                $person = $personForm->getData();
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $url = $this->generateUrl("show_by_id", array(
                    'id' => $id));
                $response = $this->redirect($url);
                return $response;
            }
        }
        return array(
            'person_form' => $personForm->createView(),
            'id' => $id);
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
            return $this->redirectToRoute('show_all');
        }
        return $this->redirectToRoute('show_all');
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
    public function showContactsBySearch(Request $request, $string) {
        $searchForm = $this->createSearchForm();

        $string = $request->request->get('form')['last_name'];

        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository("ContactBoxBundle:Person")->findByFirstOrLastName($string);
        return array(
            'contacts' => $contacts,
            'search_form' => $searchForm->createView()
        );
    }

}