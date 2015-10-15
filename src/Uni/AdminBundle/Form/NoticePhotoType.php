<?php

namespace Uni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoticePhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', 'hidden', array(
                'label' =>  'noticephoto_path',
                'required' => false,
                'attr' => array('preview' => true),
            ))
            ->add('file', 'file', array(
                'label' =>  'noticephoto_file',
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
            'data_class' => 'Uni\AdminBundle\Entity\NoticePhoto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_adminbundle_noticephoto';
    }
}
