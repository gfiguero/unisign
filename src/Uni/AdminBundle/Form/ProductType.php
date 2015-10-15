<?php

namespace Uni\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' =>  'product_name',
            ))
            ->add('content', null, array(
                'label' =>  'product_content',
                'required' => false,
                'attr'  =>  array( 'class' =>  'tinymce', 'data-theme' => 'advanced' ),
            ))
            ->add('active', null, array(
                'label' =>  'product_active',
                'required' => false,
                'attr'  => array( 'labeled' => true, 'class' => 'switch'),
            ))
            ->add('category', null, array(
                'label' =>  'product_category',
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('photos', 'bootstrap_collection', array(
                'label'                 =>  'product_photos',
                'type'                  =>  new ProductPhotoType(),
                'allow_add'             =>  true,
                'allow_delete'          =>  true,
                'add_button_text'       =>  'product_photo_add',
                'delete_button_text'    =>  'product_photo_delete',
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
            'data_class' => 'Uni\AdminBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uni_adminbundle_product';
    }
}
