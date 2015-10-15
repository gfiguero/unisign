<?php

namespace Uni\UserBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Uni\UserBundle\Entity\User;
use Uni\UserBundle\Form\UserProfileType;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) { throw new AccessDeniedException('This user does not have access to this section.'); }
        return $this->container->get('templating')->renderResponse('UniUserBundle:Profile:show.html.'.$this->container->getParameter('fos_user.template.engine'), array('user' => $user));
    }

    /**
     * Edit the user
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) { throw new AccessDeniedException('This user does not have access to this section.'); }
        $form = $this->createEditForm($user);
        return $this->render('UniUserBundle:Profile:edit.html.twig', array( 'user' => $user, 'form' => $form->createView()));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserProfileType(), $entity, array( 'action' => $this->generateUrl('user_profile_update'), 'method' => 'POST' ));
        $form->add('actions','form_actions',['buttons'=>['submit'=>['type'=>'submit','options'=>['label'=>'save','attr'=>array('icon'=>'save','class'=>'btn-primary')]]]]);
        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) { throw new AccessDeniedException('This user does not have access to this section.'); }
        $form = $this->createEditForm($user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'Profile has been updated.' );
            return $this->redirect($this->generateUrl('user_profile_show'));
        }
        return $this->render('UniUserBundle:User:edit.html.twig',array('user'=>$user,'form'=>$form->createView()));
    }

}
