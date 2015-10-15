<?php

/** Prototype **/

{% block uni_adminbundle_frontpagephoto_widget %}
    {% spaceless %}
        {% set path = form.children['photo_path'] %}
        {% set file = form.children['photo_file'] %}
        {% if path.vars.attr.preview is defined and path.vars.attr.preview == true and path.vars.value != '' %}
            {% set image = 'uploads/frontpage_photos/' ~ path.vars.value %}
            <img src="{{ asset(image) | imagine_filter('frontpage_edit') }}" alt="..." class="img-responsive img-thumbnail">
            {{ form_widget(path) }}
            {{ form_errors(path) }}
        {% else %}
            {{ form_widget(file) }}
            {{ form_errors(file) }}
        {% endif %}
    {% endspaceless %}
{% endblock uni_adminbundle_frontpagephoto_widget %}

/** Form OneToMany **/

            ->add('frontpage_photos', 'bootstrap_collection', array(
                'label'                 =>  'frontpage_photos',
                'type'                  =>  new FrontpagePhotoType(),
                'allow_add'             =>  true,
                'allow_delete'          =>  true,
                'add_button_text'       =>  'frontpage_photo_add',
                'delete_button_text'    =>  'frontpage_photo_delete',
                'sub_widget_col'        =>  10,
                'button_col'            =>  2
            ))


/** Form ManyToOne **/

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo_path', 'hidden', array(
                'required'  =>  false,
                'attr'      =>  array('preview' => true),
            ))
            ->add('photo_file', 'file', array(
                'required'  =>  false,
                'label' =>  'photo_file',
            ))
        ;
    }

/** Entity ManyToOne **/
    public function upload()
    {
        if (null === $this->getPhotoFile()) {
            return;
        }

        $this->getPhotoFile()->move(
            $this->getUploadRootDir(),
            $this->getPhotoFile()->getClientOriginalName()
        );

        $this->photo_path = $this->getPhotoFile()->getClientOriginalName();

        $this->photo_file = null;
    }

    public function getAbsolutePath()
    {
        return null === $this->photo_path
            ? null
            : $this->getUploadRootDir().'/'.$this->photo_path;
    }

    public function getWebPath()
    {
        return null === $this->photo_path
            ? null
            : $this->getUploadDir().'/'.$this->photo_path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return $this->get('kernel')->getRootDir().'/../web'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '/uploads/noticias';
    }


/** Controller **/
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Frontpage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Frontpage cannot be found.');
        }

        $currentPhotos = new ArrayCollection();
        foreach ($entity->getFrontpagePhotos() as $photo) {
            $currentPhotos->add($photo);
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            foreach ($currentPhotos as $photo) {
                if (false === $entity->getFrontpagePhotos()->contains($photo)) {
                    $em->remove($photo);
                }
            }
            $photos = $entity->getFrontpagePhotos();
            foreach ($photos as $photo) {
                $photo->upload();
                $photo->setPhotoFrontpage($entity);
                $em->persist($photo);
            }
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'Frontpage has been updated.' );
            return $this->redirect($this->generateUrl('frontpage'));
        }

        return $this->render('UniAdminBundle:Frontpage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
