<?php

namespace Uni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProcessType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'process_title',
            ))
            ->add('name', null, array(
                'label' => 'process_name',
                'required' => false,
            ))
            ->add('abstract', null, array(
                'label' => 'process_abstract',
                'required' => false,
                'attr'  =>  array( 'class' =>  'tinymce', 'data-theme' => 'advanced' ),
            ))
            ->add('content', null, array(
                'label' => 'process_content',
                'required' => false,
                'attr'  =>  array( 'class' =>  'tinymce', 'data-theme' => 'advanced' ),
            ))
            ->add('rank', null, array(
                'label' => 'process_rank',
                'required' => false,
            ))
            ->add('active', null, array(
                'label' => 'process_active',
                'required' => false,
                'attr'  => array('labeled' => true, 'class' => 'switch'),
            ))
            ->add('path', 'hidden', array(
                'label' => 'process_path',
                'required' => false,
                'attr' => array('preview' => true),
            ))
            ->add('file', 'file', array(
                'label' => 'process_file',
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
            'data_class' => 'Uni\AdminBundle\Entity\Process'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_adminbundle_process';
    }
}
