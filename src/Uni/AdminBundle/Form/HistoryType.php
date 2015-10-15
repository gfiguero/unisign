<?php

namespace Uni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', null, array(
                'label' =>  'history_time',
            ))
            ->add('title', null, array(
                'label' =>  'history_title',
            ))
            ->add('abstract', null, array(
                'label' =>  'history_abstract',
            ))
            ->add('content', null, array(
                'label' =>  'history_content',
            ))
            ->add('rank', null, array(
                'label' =>  'history_rank',
            ))
            ->add('published', null, array(
                'label' =>  'history_published',
                'required' => false,
                'attr'  => array(
                    'labeled' => true,
                ),
            ))
            ->add('path', 'hidden', array(
                'label' =>  'history_path',
                'attr' => array('preview' => true),
                'required' => false,
            ))
            ->add('file', 'file', array(
                'label' =>  'history_file',
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uni\AdminBundle\Entity\History'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_adminbundle_history';
    }
}
