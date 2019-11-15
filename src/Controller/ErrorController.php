<?php
declare (strict_types=1);

namespace Controller;

class ErrorController extends \Phalcon\Mvc\Controller {

    public function notFoundAction() {
        $this->response->setStatusCode(404);
    }

    public function errorAction() {
        $this->response->setStatusCode(500);
    }

    public function permissionErrorAction() {
        $this->response->setStatusCode(401);
    }
}