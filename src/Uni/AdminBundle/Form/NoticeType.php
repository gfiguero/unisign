<?php

namespace Uni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoticeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' =>  'notice_title',
            ))
            ->add('content', null, array(
                'label' =>  'notice_content',
                'required' => false,
                'attr'  =>  array( 'class' =>  'tinymce', 'data-theme' => 'advanced' ),
            ))
            ->add('published', null, array(
                'label' =>  'notice_published',
                'required' => false,
                'attr'  => array( 'labeled' => true, 'class' => 'switch'),
            ))
            ->add('category', null, array(
                'label' =>  'notice_category',
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('photos', 'bootstrap_collection', array(
                'label'                 =>  'notice_photos',
                'type'                  =>  new NoticePhotoType(),
                'allow_add'             =>  true,
                'allow_delete'          =>  true,
                'add_button_text'       =>  'notice_photo_add',
                'delete_button_text'    =>  'notice_photo_delete',
                'sub_widget_col'        =>  6,
                'button_col'            =>  6
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uni\AdminBundle\Entity\Notice'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_adminbundle_notice';
    }
}
