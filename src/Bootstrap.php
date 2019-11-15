<?php
declare (strict_types=1);

class Bootstrap {
    /**
     * Initialize all basic services
     *
     * @param \Phalcon\DiInterface $di
     */
    static public function initializeServices(\Phalcon\DiInterface $di): void {
        static::initializeRouter($di);
        static::initializeConfig($di);
        static::initializeLogger($di);
        static::initializeUrl($di);
        static::initializeRouter($di);
        static::initializeRequest($di);
        static::initializeResponse($di);
        static::initializeDispatcher($di);
        static::initializeVolt($di);
        static::initializeTwig($di);
        static::initializeView($di);
    }

    /**
     * Initialize router
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeRouter(\Phalcon\DiInterface $di) {
        $di->setShared('router',
            function () use ($di) {
                $router = new \Phalcon\Mvc\Router(false);
                $router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
                $router->setDefaultNamespace('Controller');
                $router->notFound([
                    'namespace' => 'Controller',
                    'controller' => 'error',
                    'action' => 'notFound',
                ]);

                $pathToRoutes = SRC_PATH . DIRECTORY_SEPARATOR . 'Route' . DIRECTORY_SEPARATOR . '*.php';
                foreach (\glob($pathToRoutes) as $filename) {
                    \is_readable($filename) and require_once $filename;
                }

                return $router;
            });
    }

    /**
     * Initialize config
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeConfig(\Phalcon\DiInterface $di) {
            $di->setShared(
                'config',
                function () {
                    $pathToConfigFile = CONFIG_PATH . DIRECTORY_SEPARATOR . $_SERVER['APPLICATION_ENVIRONMENT'] . DIRECTORY_SEPARATOR . 'config.ini';
                    if (!\file_exists($pathToConfigFile)) {
                        throw new \RuntimeException('Config file not exists');
                    }

                    $config = \Phalcon\Config\Factory::load(
                        [
                            'filePath' => $pathToConfigFile,
                            'adapter' => 'ini',
                        ]
                    );

                    return $config;
                }
            );
    }

    /**
     * Initialize logger
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeLogger(\Phalcon\DiInterface $di) {
        /** @var \Phalcon\Config $config */
        $config = $di->get('config');
        $projectName =  isset($config['basic']['project_name']) ? $config['basic']['project_name'] : 'undefined project name';

        $di->setShared(
            'logger',
            function () use ($projectName) {
                $log = new \Phalcon\Logger\Adapter\Syslog(\sprintf('[PHP][%s]', $projectName));
                $log->setFormatter(new \Log\Formatter());

                return $log;
            }
        );
    }

    /**
     * Initialize url component
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeUrl(\Phalcon\DiInterface $di) {
        $di->setShared(
            'url',
            function () {
                $url = new \Phalcon\Mvc\Url();
                $url->setBaseUri('/');

                return $url;
            }
        );
    }

    /**
     * Initialize request
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeRequest(\Phalcon\DiInterface $di) {
        $di->setShared(
            'request',
            function () {
                $request = new \Phalcon\Http\Request();

                return $request;
            }
        );
    }

    /**
     * Initialize response
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeResponse(\Phalcon\DiInterface $di) {
        $di->setShared(
            'response',
            function () {
                $response = new \Phalcon\Http\Response();

                return $response;
            }
        );
    }

    /**
     * Initialize dispatcher
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeDispatcher(\Phalcon\DiInterface $di) {
        $di->setShared(
            'dispatcher',
            function () {
                $dispatcher = new \Phalcon\Mvc\Dispatcher();

                return $dispatcher;
            }
        );
    }

    /**
     * Initialize volt
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeVolt(\Phalcon\DiInterface $di) {
        $di->setShared(
            'volt',
            function ($view, $di) {
                $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                $volt->setOptions(
                    [
                        'compiledPath' => BASE_PATH . '/cache/',
                        'compiledExtension' => '.cached',
                        'compiledSeparator' => '_',
                        'prefix' => 'view'
                    ]
                );

                return $volt;
            }
        );
    }

    /**
     * Initialize twig
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeTwig(\Phalcon\DiInterface $di) {
        $di->setShared(
            'twig',
            function ($view, $di) {
                $twig = new \Phalcon\Mvc\View\Engine\Twig($view, $di,
                    [
                        'cache' => BASE_PATH . '/cache/',
                    ]
                );

                return $twig;
            }
        );
    }

    /**
     * Initialize view
     *
     * @param \Phalcon\DiInterface $di
     */
    static protected function initializeView(\Phalcon\DiInterface $di) {
        /** @var \Phalcon\Config $config */
        $config = $di->get('config');
        $di->setShared(
            'view',
            function () use ($config) {
                $view = new \Phalcon\Mvc\View\Simple();
                $view->setViewsDir(BASE_PATH . '/templates/');
                $view->registerEngines(
                    [
                        '.volt' => 'volt',
                        //'.twig' => 'twig',
                    ]
                );

                // Inject all parameters from config
                if (isset($config['view_parameters'])) {
                    $view->global = $config['view_parameters']->toArray();
                }

                return $view;
            }
        );
    }
}