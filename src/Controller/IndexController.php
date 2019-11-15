<?php
declare (strict_types=1);

namespace Controller;

class IndexController extends \Phalcon\Mvc\Controller {

    use \Controller\ControllerDataTrait;

    /**
     * Pseudo constructor
     */
    public function initialize() {
        $this->setGlobalViewData([
            'conroller' => $this->router->getControllerName(),
            'action' => $this->router->getActionName(),
        ]);
    }

    /**
     * List all articles
     */
    public function indexAction() {
        $testId = $this->request->get('test');
        $html = $this->view->render('test-'.$testId);
        $this->response->setContent($html);
    }
}