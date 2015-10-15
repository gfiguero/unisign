<?php

namespace Uni\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Uni\AdminBundle\Entity\NoticeCategory;
use Uni\AdminBundle\Form\NoticeCategoryType;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        $services = $em->getRepository('UniAdminBundle:Service')->findBy(array('published' => true), array('rank' => 'ASC'));
        return $this->render('UniPageBundle:Page:index.html.twig', array(
            'frontpage' => $frontpage,
            'services' => $services,
        ));
    }

    public function memberAction()
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        $members = $em->getRepository('UniAdminBundle:Member')
            ->createQueryBuilder('m')
            ->leftJoin('m.role', 'mr')
            ->where('m.active = true')
            ->orderBy('mr.rank', 'ASC')
            ->getQuery()
            ->getResult();
        return $this->render('UniPageBundle:Page:member.html.twig', array(
            'frontpage' => $frontpage,
            'members' => $members,
        ));
    }

    public function historyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        $histories = $em->getRepository('UniAdminBundle:History')->findBy(array('published' => true), array('rank' => 'ASC'));
        return $this->render('UniPageBundle:Page:history.html.twig', array(
            'frontpage' => $frontpage,
            'histories' => $histories,
        ));
    }

    public function processAction()
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        $process = $em->getRepository('UniAdminBundle:Process')->findBy(array('active' => true), array('rank' => 'ASC'));
        return $this->render('UniPageBundle:Page:process.html.twig', array(
            'frontpage' => $frontpage,
            'process' => $process,
        ));
    }

    public function noticeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $noticecategory = $request->query->getInt('noticecategory');
        $reference = null;
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        if($noticecategory) {
            $notices = $em->getRepository('UniAdminBundle:Notice')
                ->createQueryBuilder('n')
                ->leftJoin('n.category', 'nc')
                ->where('n.published = TRUE')
                ->andWhere('nc.id = :noticecategory')
                ->orderBy('n.createdAt', 'DESC')
                ->setParameter('noticecategory', $noticecategory)
                ->getQuery()
                ->getResult();
            $reference = $em->getReference("UniAdminBundle:NoticeCategory", $noticecategory);
        } else {
            $notices = $em->getRepository('UniAdminBundle:Notice')->findBy(array('published' => true), array('createdAt' => 'DESC'));
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($notices, $request->query->getInt('page', 1), 12);
        $data = array();
        $categoryForm = $this->get('form.factory')->createNamedBuilder('', 'form', $data, array('csrf_protection' => false ))
            ->setMethod('GET')
            ->add('noticecategory', 'entity', array(
                'label' => 'noticecategory',
                'class' => 'UniAdminBundle:NoticeCategory',
                'choice_label' => 'name',
                'placeholder' => 'noticecategory',
                'required' => false,
                'data' => $reference,
            ))
            ->add('noticecategory_submit', 'button', array(
                'label' => 'noticecategory_submit',
                'attr' => array(
                    'icon' => 'search',
                    'class' => 'btn-default',
                )
            ))
            ->getForm();
        return $this->render('UniPageBundle:Page:notice.html.twig', array(
            'frontpage' => $frontpage,
            'notices' => $pagination,
            'categoryForm' => $categoryForm->createView(),
        ));
    }

    public function noticeshowAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        $notices = $em->getRepository('UniAdminBundle:Notice')->findBy(array('published' => true), array('createdAt' => 'DESC'), 10);
        $notice = $em->getRepository('UniAdminBundle:Notice')->find($id);
        return $this->render('UniPageBundle:Page:noticeshow.html.twig', array(
            'frontpage' => $frontpage,
            'notices' => $notices,
            'notice' => $notice,
        ));
    }

    public function reportAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        $reports = $em->getRepository('UniAdminBundle:Report')->findBy(array('published' => true), array('createdAt' => 'DESC'));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($reports, $request->query->getInt('page', 1), 12);
        return $this->render('UniPageBundle:Page:report.html.twig', array(
            'frontpage' => $frontpage,
            'reports' => $pagination,
        ));
    }

    public function reportshowAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        $reports = $em->getRepository('UniAdminBundle:Report')->findBy(array('published' => true), array('createdAt' => 'DESC'), 10);
        $report = $em->getRepository('UniAdminBundle:Report')->find($id);
        return $this->render('UniPageBundle:Page:reportshow.html.twig', array(
            'frontpage' => $frontpage,
            'reports' => $reports,
            'report' => $report,
        ));
    }

    public function roleAction()
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        return $this->render('UniPageBundle:Page:role.html.twig', array(
            'frontpage' => $frontpage
        ));
    }

    public function publicationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        $publications = $em->getRepository('UniAdminBundle:Publication')->findBy(array('active' => true), array('rank' => 'ASC'));
        return $this->render('UniPageBundle:Page:publication.html.twig', array(
            'frontpage' => $frontpage,
            'publications' => $publications,
        ));
    }

    public function cameraAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cameras = $em->getRepository('UniAdminBundle:Camera')->findBy(array('active' => true), array('name' => 'ASC'));
        return $this->render('UniPageBundle:Page:camera.html.twig', array(
            'cameras' => $cameras,
        ));
    }

    public function galleryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $noticecategory = $request->query->getInt('noticecategory');
        $reference = null;
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->findOneBy(array('active' => true), array('createdAt' => 'DESC'));
        if($noticecategory) {
            $photos = $em->getRepository('UniAdminBundle:NoticePhoto')
                ->createQueryBuilder('p')
                ->leftJoin('p.notice', 'pn')
                ->leftJoin('pn.category', 'pnc')
                ->where('pn.published = TRUE')
                ->andWhere('pnc.id = :noticecategory')
                ->orderBy('pn.createdAt', 'DESC')
                ->setParameter('noticecategory', $noticecategory)
                ->getQuery()
                ->getResult();
            $reference = $em->getReference("UniAdminBundle:NoticeCategory", $noticecategory);
        } else {
            $photos = $em->getRepository('UniAdminBundle:NoticePhoto')
                ->createQueryBuilder('p')
                ->leftJoin('p.notice', 'pn')
                ->leftJoin('pn.category', 'pnc')
                ->where('pn.published = TRUE')
                ->orderBy('pn.createdAt', 'DESC')
                ->getQuery()
                ->getResult();
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($photos, $request->query->getInt('page', 1), 24 );
        $data = array();
        $categoryForm = $this->get('form.factory')->createNamedBuilder('', 'form', $data, array('csrf_protection' => false ))
            ->setMethod('GET')
            ->add('noticecategory', 'entity', array(
                'label' => 'gallerycategory',
                'class' => 'UniAdminBundle:NoticeCategory',
                'choice_label' => 'name',
                'placeholder' => 'gallery_all',
                'required' => false,
                'data' => $reference,
            ))
            ->add('noticecategory_submit', 'button', array(
                'label' => 'noticecategory_submit',
                'attr' => array(
                    'icon' => 'search',
                    'class' => 'btn-default',
                )
            ))
            ->getForm();
        return $this->render('UniPageBundle:Page:gallery.html.twig', array(
            'frontpage' => $frontpage,
            'photos' => $pagination,
            'categoryForm' => $categoryForm->createView(),
        ));
    }

}
