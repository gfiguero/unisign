<?php

namespace Uni\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Uni\AdminBundle\Entity\Frontpage;
use Uni\AdminBundle\Form\FrontpageType;

/**
 * Frontpage controller.
 *
 */
class DashboardController extends Controller
{

    /**
     * Lists all Frontpage entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $frontpage = $em->getRepository('UniAdminBundle:Frontpage')->createQueryBuilder('f')->select('COUNT(f)')->getQuery()->getSingleScalarResult();
        $service = $em->getRepository('UniAdminBundle:Service')->createQueryBuilder('s')->select('COUNT(s)')->getQuery()->getSingleScalarResult();
        $process = $em->getRepository('UniAdminBundle:Process')->createQueryBuilder('p')->select('COUNT(p)')->getQuery()->getSingleScalarResult();
        $member = $em->getRepository('UniAdminBundle:Member')->createQueryBuilder('m')->select('COUNT(m)')->getQuery()->getSingleScalarResult();
        $memberrole = $em->getRepository('UniAdminBundle:MemberRole')->createQueryBuilder('mr')->select('COUNT(mr)')->getQuery()->getSingleScalarResult();
        $notice = $em->getRepository('UniAdminBundle:Notice')->createQueryBuilder('n')->select('COUNT(n)')->getQuery()->getSingleScalarResult();
        $noticecategory = $em->getRepository('UniAdminBundle:NoticeCategory')->createQueryBuilder('nc')->select('COUNT(nc)')->getQuery()->getSingleScalarResult();
        $gallery = $em->getRepository('UniAdminBundle:NoticePhoto')->createQueryBuilder('np')->select('COUNT(np)')->getQuery()->getSingleScalarResult();
        $publication = $em->getRepository('UniAdminBundle:Publication')->createQueryBuilder('p')->select('COUNT(p)')->getQuery()->getSingleScalarResult();
        $report = $em->getRepository('UniAdminBundle:Report')->createQueryBuilder('r')->select('COUNT(r)')->getQuery()->getSingleScalarResult();
        $user = $em->getRepository('UniUserBundle:User')->createQueryBuilder('u')->select('COUNT(u)')->getQuery()->getSingleScalarResult();
        return $this->render('UniAdminBundle:Dashboard:index.html.twig', array(
            'frontpage' => $frontpage,
            'service' => $service,
            'process' => $process,
            'member' => $member,
            'memberrole' => $memberrole,
            'notice' => $notice,
            'noticecategory' => $noticecategory,
            'gallery' => $gallery,
            'publication' => $publication,
            'report' => $report,
            'user' => $user,
        ));
    }

}