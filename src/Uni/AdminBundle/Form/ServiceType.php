<?php

namespace Uni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' =>  'service_title',
            ))
            ->add('abstract', null, array(
                'label' =>  'service_abstract',
                'required' => false,
                'attr'  =>  array( 'class' =>  'tinymce', 'data-theme' => 'advanced' ),
            ))
            ->add('content', null, array(
                'label' =>  'service_content',
                'required' => false,
                'attr'  =>  array( 'class' =>  'tinymce', 'data-theme' => 'advanced' ),
            ))
            ->add('rank', null, array(
                'label' =>  'service_rank',
            ))
            ->add('published', null, array(
                'label' =>  'service_published',
                'required' => false,
                'attr'  => array( 'labeled' => true, 'class' => 'switch'),
            ))
            ->add('path', 'hidden', array(
                'label' =>  'service_path',
                'required' => false,
                'attr' => array('preview' => true),
            ))
            ->add('file', 'file', array(
                'label' =>  'service_file',
                'required' => false,
                'attr' => array('class' => 'photo'),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uni\AdminBundle\Entity\Service'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_adminbundle_service';
    }
}
