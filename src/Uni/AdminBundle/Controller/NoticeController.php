<?php

namespace Uni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

use Uni\AdminBundle\Entity\Notice;
use Uni\AdminBundle\Form\NoticeType;

/**
 * Notice controller.
 *
 */
class NoticeController extends Controller
{

    /**
     * Lists all Notice entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $entities = $em->getRepository('UniAdminBundle:Notice')->findBy(array(), array($sort => $direction));
        else $entities = $em->getRepository('UniAdminBundle:Notice')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $request->query->getInt('page', 1), 10);

        return $this->render('UniAdminBundle:Notice:index.html.twig', array(
            'pagination' => $pagination,
            'direction'  => $direction,
            'sort'       => $sort,
        ));
    }
    /**
     * Creates a new Notice entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Notice();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $photos = $entity->getPhotos();
            foreach ($photos as $photo) {
                $photo->upload();
                $photo->setNotice($entity);
                $em->persist($photo);
            }
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'Notice has been created.' );    
            return $this->redirect($this->generateUrl('notice'));
        }

        return $this->render('UniAdminBundle:Notice:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Notice entity.
     *
     * @param Notice $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Notice $entity)
    {
        $form = $this->createForm(new NoticeType(), $entity, array(
            'action' => $this->generateUrl('notice_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create', 'attr' => array('icon' => 'save')));

        return $form;
    }

    /**
     * Displays a form to create a new Notice entity.
     *
     */
    public function newAction()
    {
        $entity = new Notice();
        $form   = $this->createCreateForm($entity);

        return $this->render('UniAdminBundle:Notice:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Notice entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Notice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Notice cannot be found.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UniAdminBundle:Notice:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Notice entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Notice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Notice cannot be found.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('UniAdminBundle:Notice:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Notice entity.
    *
    * @param Notice $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Notice $entity)
    {
        $form = $this->createForm(new NoticeType(), $entity, array(
            'action' => $this->generateUrl('notice_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('actions', 'form_actions', [
            'buttons' => [
                'submit' => ['type' => 'submit', 'options' => ['label' => 'save', 'attr' => array('icon' => 'save', 'class' => 'btn-primary')]],
            ]
        ]);

        return $form;
    }
    /**
     * Edits an existing Notice entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Notice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Notice cannot be found.');
        }

        $currentPhotos = new ArrayCollection();
        foreach ($entity->getPhotos() as $photo) {
            $currentPhotos->add($photo);
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            foreach ($currentPhotos as $photo) {
                if (false === $entity->getPhotos()->contains($photo)) {
                    $em->remove($photo);
                }
            }
            $photos = $entity->getPhotos();
            foreach ($photos as $photo) {
                $photo->upload();
                $photo->setNotice($entity);
                $em->persist($photo);
            }
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'Notice has been updated.' );
            return $this->redirect($this->generateUrl('notice'));
        }

        return $this->render('UniAdminBundle:Notice:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Notice entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $deleteForm = $this->createDeleteForm($id);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UniAdminBundle:Notice')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('The Notice cannot be found.');
            }

            $em->remove($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'Notice has been deleted.' );
        }

        return $this->redirect($this->generateUrl('notice'));
    }

    /**
     * Creates a form to delete a Notice entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notice_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('actions', 'form_actions', [
                'buttons' => [
                    'cancel' => ['type' => 'button', 'options' => ['label' => 'cancel', 'attr' => array('icon' => 'remove', 'class' => 'btn-default', 'data-dismiss' => 'modal')]],
                    'delete' => ['type' => 'submit', 'options' => ['label' => 'confirm', 'attr' => array('icon' => 'trash-o', 'class' => 'btn-danger')]],
                ]
            ])
            ->getForm()
        ;
    }

}
