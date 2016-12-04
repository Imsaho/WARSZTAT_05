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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ContactBoxBundle\Form\PersonGroupFormType;

class PersonGroupController extends Controller {

    /**
     * @Route ("/group/showAll", name="show_all_groups")
     * @Template()
     */
    public function showAllGroupsAction() {
        $repository = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup");
        $groups = $repository->findAll();
        return array(
            'groups' => $groups
        );
    }

    /**
     * @Route ("/group/add", name="add_group")
     * @Template()
     */
    public function addGroupAction(Request $request) {

        $group = new PersonGroup();

        $form = $this->createForm(PersonGroupFormType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
            return $this->redirectToRoute('show_all_groups');
        }
        return array(
            'group_form' => $form->createView()
        );
    }
    
    /**
     * @Route ("/group/{id}/edit", name="edit_group")
     * @Template()
     */
    public function editGroupAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository("ContactBoxBundle:PersonGroup")->find($id);
        
        $form = $this->createForm(PersonGroupFormType::class, $group);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $em->flush();
            return $this->redirectToRoute('show_all_groups');
        }
        return array(
            'group_form' => $form->createView(),
            'id' => $id
        );
    }
    
    /**
     * @Route ("/group/{id}/remove", name="remove_group")
     */
    public function removeGroupAction($id) {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository("ContactBoxBundle:PersonGroup")->find($id);
        if ($group) {
            $em->remove($group);
            $em->flush();
            return $this->redirectToRoute('show_all_groups');
        }
        return $this->redirectToRoute('show_all_groups');
    }

}