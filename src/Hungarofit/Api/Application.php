<?php

namespace Hungarofit\Api;


use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Phalcon\Text;

class Application extends Micro
{
    const SUFFIX_CONTROLLER = 'Controller';
    const SUFFIX_ACTION = 'Action';

    const ROUTES = [
        [
            'controller' => 'index',
            'prefix' => '',
            'paths' => [
                [
                    'method' => 'get',
                    'action' => 'version',
                    'path' => '/version'
                ],
                [
                    'method' => 'get',
                    'action' => 'rss',
                    'path' => '/rss'
                ],
                [
                    'method' => 'get',
                    'action' => 'foo',
                    'path' => '/foo'
                ],
                [
                    'method' => 'get',
                    'action' => 'index',
                    'path' => '/'
                ],
            ],
        ],

        [
            'controller' => 'master',
            'prefix' => '/master',
            'paths' => [
                [
                    'method' => 'get',
                    'action' => 'index',
                    'path' => '/'
                ],
            ],
        ],

        [
            'controller' => 'evaluate',
            'prefix' => '/evaluate',
            'paths' => [
                [
                    'method' => 'post',
                    'action' => 'index',
                    'path' => '/'
                ],
            ],
        ],

        [
            'controller' => 'exercise',
            'prefix' => '/exercise',
            'paths' => [
                [
                    'method' => 'get',
                    'action' => 'index',
                    'path' => ''
                ],
                [
                    'method' => 'post',
                    'action' => 'evaluate',
                    'path' => '/evaluate/{points}'
                ],
            ],
        ],
    ];

    protected function _routes()
    {
        foreach(self::ROUTES as $group) {
            $handler = __NAMESPACE__ . '\\Controller\\' . Text::camelize($group['controller']).self::SUFFIX_CONTROLLER;
            $collection = new Micro\Collection;
            $collection->setPrefix($group['prefix']);
            $collection->setHandler($handler);
            $collection->setLazy(true);
            foreach($group['paths'] as $path) {
                $action = lcfirst(Text::camelize($path['action'])).self::SUFFIX_ACTION;
                $collection->{$path['method']?:'get'}($path['path'], $action);
            }
            $this->mount($collection);
        }
    }

    public function __construct()
    {
        $di = FactoryDefault::getDefault();
        parent::__construct($di);

        $this->_routes();

        $this->notFound(function () {
            $this->response->setStatusCode(404, "Not Found")->sendHeaders();
            echo '404 - Not Found :(';
        });

        $this->before(function() {
            $this->response->setHeader('Access-Control-Allow-Origin', 'https://app.hungarofit.hu');
            /*
            $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
            $this->response->setHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
            */
            $this->response->setContentType('application/json', 'utf-8');
        });

        $this->after(function() {
            $this->router->getMatchedRoute()->getName();
            $this->response->sendHeaders();
            echo json_encode([
                'status' => 'OK',
                'response' => $this->getReturnedValue(),
            ], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        });
    }

}