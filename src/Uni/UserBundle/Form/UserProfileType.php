<?php

namespace Uni\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array(
                'label' =>  'user_firstname',
            ))
            ->add('lastname', null, array(
                'label' =>  'user_lastname',
            ))
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_userbundle_user_profile';
    }
}
