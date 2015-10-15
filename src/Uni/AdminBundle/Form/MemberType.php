<?php

namespace Uni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array(
                'label' =>  'member_firstname',
            ))
            ->add('lastname', null, array(
                'label' =>  'member_lastname',
                'required' => false,
            ))
            ->add('email', null, array(
                'label' =>  'member_email',
                'required' => false,
            ))
            ->add('phonenumber', null, array(
                'label' =>  'member_phonenumber',
                'required' => false,
            ))
            ->add('birthdate', 'birthday', array(
                'label' =>  'member_birthdate',
                'required' => false,
            ))
            ->add('admissiondate', 'birthday', array(
                'label' =>  'member_admissiondate',
                'required' => false,
            ))
            ->add('active', null, array(
                'label' =>  'member_active',
                'required' => false,
                'attr'  => array('labeled' => true, 'class' => 'switch'),
            ))
            ->add('path', 'hidden', array(
                'label' =>  'member_path',
                'required' => false,
                'attr' => array('preview' => true),
            ))
            ->add('file', 'file', array(
                'label' =>  'member_file',
                'required' => false,
                'attr' => array('class' => 'photo'),
            ))
            ->add('role', null, array(
                'label' =>  'member_role',
                'required' => false,
                'choice_label' => 'name',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uni\AdminBundle\Entity\Member'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_adminbundle_member';
    }
}
