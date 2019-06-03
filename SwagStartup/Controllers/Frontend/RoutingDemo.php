<?php

class Shopware_Controllers_Frontend_RoutingDemo extends Enlight_Controller_Action
{
    public function preDispatch()
    {
        if (!$this->get('session')->get('sUserId')) {
            $this->redirect([
                'controller' => 'account',
                'action' => 'login',
                'sTarget' => 'RoutingDemo', //登录成功后访问的Controller
                'sTargetAction' => 'index', //登录成功后访问的Action
            ]);
        }
    }

    public function indexAction() {
        $this->view->assign('nextAction', 'foo');
    }

    public function fooAction() {
        $this->view->assign('nextAction', 'baa');
    }

    public function baaAction() {
        $service = $this->get('swag_startup.services.product_name_service');
        $productNames = $service->getProductNames();
//        print_r($productNames);die('ok');
        $this->view->assign('productNames', $productNames);
        $this->view->assign('nextAction', 'index');
    }

    public function postDispatch()
    {
        $currentAction = $this->request->getActionName();
        $this->view->assign('currentAction', $currentAction);
    }
}
