<?php

namespace ContactBoxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AddressFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('city')
                ->add('street')
                ->add('house_number')
                ->add('apartment_number')
                ->add('address_type', EntityType::class, array(
                    'class' => 'ContactBoxBundle:InfoType'
                ));
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' =>  'ContactBoxBundle\Entity\Address'
        ));
    }


}