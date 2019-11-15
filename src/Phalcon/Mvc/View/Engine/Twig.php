<?php
declare (strict_types=1);

namespace Phalcon\Mvc\View\Engine;

class Twig extends \Phalcon\Mvc\View\Engine implements \Phalcon\Mvc\View\EngineInterface {

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param mixed|\Phalcon\Mvc\ViewBaseInterface $view
     * @param mixed|\Phalcon\DiInterface $dependencyInjector
     * @param array $options
     */
    public function __construct($view, $dependencyInjector, array $options = []) {
        parent::__construct($view, $dependencyInjector);
        $loader = new \Twig_Loader_Filesystem($this->getView()->getViewsDir());
        $this->twig = new \Twig_Environment($loader, $options);
    }

    /**
     * @param string $path
     * @param mixed $params
     * @param bool $mustClean
     */
    public function render($path, $params, $mustClean = false) {
        if (!$params) {
            $params = [];
        }
        $content = $this->twig->render(str_replace($this->getView()->getViewsDir(), '', $path), $params);
        if ($mustClean) {
            $this->getView()->setContent($content);
            return ;
        }
        echo $content;
    }
}