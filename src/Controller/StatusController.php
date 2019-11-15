<?php
declare (strict_types=1);

namespace Controller;

class StatusController extends \Phalcon\Mvc\Controller {

    /**
     * /status
     */
    public function indexAction() {
        $config = $this->getDI()->get('config');
        $projectName = isset($config['basic']['project_name']) ? $config['basic']['project_name'] : 'Undefined';
        $this->response->setContentType('application/json');
        $this->response->setContent(\json_encode(
                [
                    'status' => 'ok',
                    'projectName' => $projectName
                ]
            )
        );
    }
}