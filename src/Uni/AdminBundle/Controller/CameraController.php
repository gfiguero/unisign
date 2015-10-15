<?php

namespace Uni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Uni\AdminBundle\Entity\Camera;
use Uni\AdminBundle\Form\CameraType;

/**
 * Camera controller.
 *
 */
class CameraController extends Controller
{

    /**
     * Lists all Camera entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $entities = $em->getRepository('UniAdminBundle:Camera')->findBy(array(), array($sort => $direction));
        else $entities = $em->getRepository('UniAdminBundle:Camera')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $request->query->getInt('page', 1), 10);

        return $this->render('UniAdminBundle:Camera:index.html.twig', array(
            'pagination' => $pagination,
            'direction'  => $direction,
            'sort'       => $sort,
        ));
    }
    /**
     * Creates a new Camera entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Camera();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'Camera has been created.' );    
            return $this->redirect($this->generateUrl('camera'));
        }

        return $this->render('UniAdminBundle:Camera:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Camera entity.
     *
     * @param Camera $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Camera $entity)
    {
        $form = $this->createForm(new CameraType(), $entity, array(
            'action' => $this->generateUrl('camera_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create', 'attr' => array('icon' => 'save')));

        return $form;
    }

    /**
     * Displays a form to create a new Camera entity.
     *
     */
    public function newAction()
    {
        $entity = new Camera();
        $form   = $this->createCreateForm($entity);

        return $this->render('UniAdminBundle:Camera:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Camera entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Camera')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Camera cannot be found.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UniAdminBundle:Camera:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Camera entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Camera')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Camera cannot be found.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('UniAdminBundle:Camera:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Camera entity.
    *
    * @param Camera $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Camera $entity)
    {
        $form = $this->createForm(new CameraType(), $entity, array(
            'action' => $this->generateUrl('camera_update', array('id' => $entity->getId())),
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
     * Edits an existing Camera entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Camera')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Camera cannot be found.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'Camera has been updated.' );
            return $this->redirect($this->generateUrl('camera'));
        }

        return $this->render('UniAdminBundle:Camera:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Camera entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $deleteForm = $this->createDeleteForm($id);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UniAdminBundle:Camera')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('The Camera cannot be found.');
            }

            $em->remove($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'Camera has been deleted.' );
        }

        return $this->redirect($this->generateUrl('camera'));
    }

    /**
     * Creates a form to delete a Camera entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('camera_delete', array('id' => $id)))
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
