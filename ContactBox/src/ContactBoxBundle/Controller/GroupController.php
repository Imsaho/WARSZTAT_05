<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBoxBundle\Entity\PersonGroup;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GroupController extends Controller {

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

    /**
     * @Route ("/{id}/group/add", name="add_group")
     * @Method({"POST"})
     */
    public function addGroupAction(Request $request, $id) {
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);

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