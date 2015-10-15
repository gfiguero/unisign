<?php

namespace Uni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Uni\AdminBundle\Entity\MemberRole;
use Uni\AdminBundle\Form\MemberRoleType;

/**
 * MemberRole controller.
 *
 */
class MemberRoleController extends Controller
{

    /**
     * Lists all MemberRole entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $entities = $em->getRepository('UniAdminBundle:MemberRole')->findBy(array(), array($sort => $direction));
        else $entities = $em->getRepository('UniAdminBundle:MemberRole')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $request->query->getInt('page', 1), 10);

        return $this->render('UniAdminBundle:MemberRole:index.html.twig', array(
            'pagination' => $pagination,
            'direction'  => $direction,
            'sort'       => $sort,
        ));
    }
    /**
     * Creates a new MemberRole entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MemberRole();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'MemberRole has been created.' );    
            return $this->redirect($this->generateUrl('memberrole'));
        }

        return $this->render('UniAdminBundle:MemberRole:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MemberRole entity.
     *
     * @param MemberRole $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MemberRole $entity)
    {
        $form = $this->createForm(new MemberRoleType(), $entity, array(
            'action' => $this->generateUrl('memberrole_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create', 'attr' => array('icon' => 'save')));

        return $form;
    }

    /**
     * Displays a form to create a new MemberRole entity.
     *
     */
    public function newAction()
    {
        $entity = new MemberRole();
        $form   = $this->createCreateForm($entity);

        return $this->render('UniAdminBundle:MemberRole:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MemberRole entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:MemberRole')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The MemberRole cannot be found.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UniAdminBundle:MemberRole:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MemberRole entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:MemberRole')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The MemberRole cannot be found.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('UniAdminBundle:MemberRole:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MemberRole entity.
    *
    * @param MemberRole $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MemberRole $entity)
    {
        $form = $this->createForm(new MemberRoleType(), $entity, array(
            'action' => $this->generateUrl('memberrole_update', array('id' => $entity->getId())),
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
     * Edits an existing MemberRole entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:MemberRole')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The MemberRole cannot be found.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'MemberRole has been updated.' );
            return $this->redirect($this->generateUrl('memberrole'));
        }

        return $this->render('UniAdminBundle:MemberRole:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a MemberRole entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $deleteForm = $this->createDeleteForm($id);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UniAdminBundle:MemberRole')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('The MemberRole cannot be found.');
            }

            $em->remove($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'MemberRole has been deleted.' );
        }

        return $this->redirect($this->generateUrl('memberrole'));
    }

    /**
     * Creates a form to delete a MemberRole entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('memberrole_delete', array('id' => $id)))
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
