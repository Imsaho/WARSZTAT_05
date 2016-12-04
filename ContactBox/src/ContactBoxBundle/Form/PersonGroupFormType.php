<?php

//    public function createGroupForm($group, $id, $options) {
//        $form = $this->createFormBuilder($group)
//                ->setAction($this->generateUrl("add_group", array(
//                            'id' => $id)))
//                ->setMethod("POST")
//                ->add('group_name', ChoiceType::class, array(
//                    'choices' => $options,
//                    'choices_as_values' => true,
//                    'choice_label' => 'getGroupName',
//                    'choice_value' => 'getGroupName'))
//                ->add('save', SubmitType::class)
//                ->getForm();
//        return $form;
//    }

namespace ContactBoxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonGroupFormType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('group_name');
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' =>  'ContactBoxBundle\Entity\PersonGroup'
        ));
    }

    
}

