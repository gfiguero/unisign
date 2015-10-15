<?php

namespace Uni\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function sideAdminMenu(FactoryInterface $factory, array $options)
    {

        $roles = $this->container->get('security.token_storage')->getToken()->getUser()->getRoles();

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
        $menu->setChildrenAttribute('id', 'side-menu');

        if(in_array('ROLE_FRONTPAGE', $roles) or in_array('ROLE_ADMIN', $roles)) {
            $menu->addChild('frontpage_index', array('route' => 'frontpage'))->setAttribute('icon', 'clone fa-fw');
        }
        if(in_array('ROLE_SERVICE', $roles) or in_array('ROLE_ADMIN', $roles)) {
            $menu->addChild('service_index', array('route' => 'service'))->setAttribute('icon', 'cogs fa-fw');
        }
        if(in_array('ROLE_PROCESS', $roles) or in_array('ROLE_ADMIN', $roles)) {
            $menu->addChild('process_index', array('route' => 'process'))->setAttribute('icon', 'paper-plane fa-fw');
        }
        if(in_array('ROLE_MEMBER', $roles) or in_array('ROLE_ADMIN', $roles)) {
            $menu->addChild('member_control')->setAttribute('icon', 'sitemap fa-fw');
            $menu['member_control']->setChildrenAttribute('class', 'nav nav-second-level collapse');
            $menu['member_control']->addChild('member_index', array('route' => 'member'));
            $menu['member_control']->addChild('memberrole_index', array('route' => 'memberrole'));
        }
        if(in_array('ROLE_NOTICE', $roles) or in_array('ROLE_ADMIN', $roles)) {
            $menu->addChild('notice_control')->setAttribute('icon', 'newspaper-o fa-fw');
            $menu['notice_control']->setChildrenAttribute('class', 'nav nav-second-level collapse');
            $menu['notice_control']->addChild('notice_index', array('route' => 'notice'));
            $menu['notice_control']->addChild('noticecategory_index', array('route' => 'noticecategory'));
        }
        if(in_array('ROLE_PUBLICATION', $roles) or in_array('ROLE_ADMIN', $roles)) {
            $menu->addChild('publication_index', array('route' => 'publication'))->setAttribute('icon', 'bullhorn fa-fw');
        }
        if(in_array('ROLE_REPORT', $roles) or in_array('ROLE_ADMIN', $roles)) {
            $menu->addChild('report_index', array('route' => 'report'))->setAttribute('icon', 'flag fa-fw');
        }
//        $menu->addChild('product_control')->setAttribute('icon', 'cube fa-fw');
//        $menu['product_control']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['product_control']->addChild('product_index', array('route' => 'product'));
//        $menu['product_control']->addChild('productcategory_index', array('route' => 'productcategory'));

        return $menu;

    }

    public function topAdminMenu(FactoryInterface $factory, array $options)
    {

        $roles = $this->container->get('security.token_storage')->getToken()->getUser()->getRoles();

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-top-links navbar-right');
        $menu->setChildrenAttribute('id', 'top-menu');

        $menu->addChild('home', array('route' => 'uni_page'))->setAttribute('icon', 'home fa-fw');
        $menu->addChild('user_profile', array('route' => 'user_profile_show'))->setAttribute('icon', 'user fa-fw');

        if(in_array('ROLE_ACCESS', $roles) or in_array('ROLE_ADMIN', $roles)) {
            $menu->addChild('user_index', array('route' => 'user'))->setAttribute('icon', 'group fa-fw');
        }

        $menu->addChild('logout', array('route' => 'user_security_logout'))->setAttribute('icon', 'sign-out fa-fw');

        return $menu;

    }
}