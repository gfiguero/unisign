<?php

namespace Uni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

use Uni\AdminBundle\Entity\Frontpage;
use Uni\AdminBundle\Form\FrontpageType;

/**
 * Frontpage controller.
 *
 */
class FrontpageController extends Controller
{

    /**
     * Lists all Frontpage entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $entities = $em->getRepository('UniAdminBundle:Frontpage')->findBy(array(), array($sort => $direction));
        else $entities = $em->getRepository('UniAdminBundle:Frontpage')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $request->query->getInt('page', 1), 10);

        return $this->render('UniAdminBundle:Frontpage:index.html.twig', array(
            'pagination' => $pagination,
            'direction'  => $direction,
            'sort'       => $sort,
        ));
    }
    /**
     * Creates a new Frontpage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Frontpage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $photos = $entity->getPhotos();
            foreach ($photos as $photo) {
                $photo->upload();
                $photo->setFrontpage($entity);
                $em->persist($photo);
            }
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'Frontpage has been created.' );    
            return $this->redirect($this->generateUrl('frontpage'));
        }

        return $this->render('UniAdminBundle:Frontpage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Frontpage entity.
     *
     * @param Frontpage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Frontpage $entity)
    {
        $form = $this->createForm(new FrontpageType(), $entity, array(
            'action' => $this->generateUrl('frontpage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create', 'attr' => array('icon' => 'save')));

        return $form;
    }

    /**
     * Displays a form to create a new Frontpage entity.
     *
     */
    public function newAction()
    {
        $entity = new Frontpage();
        $form   = $this->createCreateForm($entity);

        return $this->render('UniAdminBundle:Frontpage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Frontpage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Frontpage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Frontpage cannot be found.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UniAdminBundle:Frontpage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Frontpage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Frontpage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Frontpage cannot be found.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('UniAdminBundle:Frontpage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Frontpage entity.
    *
    * @param Frontpage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Frontpage $entity)
    {
        $form = $this->createForm(new FrontpageType(), $entity, array(
            'action' => $this->generateUrl('frontpage_update', array('id' => $entity->getId())),
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
     * Edits an existing Frontpage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UniAdminBundle:Frontpage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('The Frontpage cannot be found.');
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
                $photo->setFrontpage($entity);
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
    /**
     * Deletes a Frontpage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $deleteForm = $this->createDeleteForm($id);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UniAdminBundle:Frontpage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('The Frontpage cannot be found.');
            }

            $em->remove($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'Frontpage has been deleted.' );
        }

        return $this->redirect($this->generateUrl('frontpage'));
    }

    /**
     * Creates a form to delete a Frontpage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frontpage_delete', array('id' => $id)))
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
