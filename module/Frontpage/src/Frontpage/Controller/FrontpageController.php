<?php

namespace Frontpage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\ViewModel;

class FrontpageController extends AbstractActionController
{
    public function homeAction()
    {
        $homePageData = $this->getFrontpageService()->getHomepageData();
        $session = new SessionContainer('theme');

        $view = new ViewModel($homePageData);
        if (!isset($session->theme) || $session->theme == 'new') {
            $view->setTemplate('frontpage/fancy-home');
        }
        return $view;
    }

    /**
     * Get the frontpage service.
     *
     * @return \Frontpage\Service\Frontpage
     */
    protected function getFrontpageService()
    {
        return $this->getServiceLocator()->get('frontpage_service_frontpage');
    }
}
