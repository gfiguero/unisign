<?php

namespace Uni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrontpageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' =>  'frontpage_title',
            ))
            ->add('subtitle', null, array(
                'label' =>  'frontpage_subtitle',
                'required' => false,
            ))
            ->add('email', null, array(
                'label' =>  'frontpage_email',
                'required' => false,
            ))
            ->add('phonenumber', null, array(
                'label' =>  'frontpage_phonenumber',
                'required' => false,
            ))
            ->add('address', null, array(
                'label' =>  'frontpage_address',
                'required' => false,
            ))
            ->add('mission', null, array(
                'label' =>  'frontpage_mission',
                'required' => false,
                'attr'  =>  array( 'class' =>  'tinymce', 'data-theme' => 'advanced' ),
            ))
            ->add('vision', null, array(
                'label' =>  'frontpage_vision',
                'required' => false,
                'attr'  =>  array( 'class' =>  'tinymce', 'data-theme' => 'advanced' ),
            ))
            ->add('active', null, array(
                'label' =>  'frontpage_active',
                'required' => false,
                'attr'  => array( 'labeled' => true, 'class' => 'switch'),
            ))
            ->add('photos', 'bootstrap_collection', array(
                'label'                 =>  'frontpage_photos',
                'type'                  =>  new FrontpagePhotoType(),
                'allow_add'             =>  true,
                'allow_delete'          =>  true,
                'add_button_text'       =>  'frontpage_photo_add',
                'delete_button_text'    =>  'frontpage_photo_delete',
                'sub_widget_col'        =>  10,
                'button_col'            =>  2
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uni\AdminBundle\Entity\Frontpage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_adminbundle_frontpage';
    }
}
