<?php

namespace Uni\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
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
            ->add('roles', 'choice', array(
                'label' => 'user_access',
                'choices' => array(
                    'ROLE_FRONTPAGE' => 'frontpage_index',
                    'ROLE_SERVICE' => 'service_index',
                    'ROLE_PROCESS' => 'process_index',
                    'ROLE_MEMBER' => 'member_index',
                    'ROLE_NOTICE' => 'notice_index',
                    'ROLE_PUBLICATION' => 'publication_index',
                    'ROLE_REPORT' => 'report_index',
                    'ROLE_ACCESS' => 'user_index',
                ),
                'expanded' => true,
                'multiple' => true,
            ))
//            ->add('enabled', null, array(
//                'label' =>  'user_enabled',
//                'required' => false,
//                'attr' => array( 'labeled' => true, 'class' => 'switch'),
//            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uni\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
//    public function getParent()
//    {
//        return 'fos_user_registration';
//    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_userbundle_user_registration';
    }
}
