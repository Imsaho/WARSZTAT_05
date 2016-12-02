<?php

namespace ContactBoxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('city')
                ->add('street')
                ->add('house_number')
                ->add('apartment_number')
                ->add('address_type');
    }
    
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' =>  'ContactBoxBundle\Entity\Address'
        ));
    }


}