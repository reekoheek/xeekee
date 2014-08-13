<?php

namespace App\Middleware;

class XeekeeMiddleware extends \Slim\Middleware
{
    public function call()
    {

        $options = array_merge(array(
            'baseDir' => 'data',
        ), $this->options ?: array());

        $app = \App::getInstance();

        if (!is_null($app->request->get('editor'))) {
            exit;
        }

        if ($app->request->isGet() && is_null($app->controller)) {
            $pathInfo = $app->request->getPathInfo();
            $md = 'data/root'.$pathInfo.'/index.md';
            $filepath = getcwd().'/../'.$md;
            if (is_readable($filepath)) {
                $contentData = explode("\n\n", file_get_contents($filepath), 2);

                $app->get($pathInfo ?: '/', function () use ($app, $contentData) {
                    $app->response->template('read');
                    $app->response->set(array('content'=> $contentData[1]));
                });
            } else {
                $app->redirect($pathInfo.'?editor');
            }

        }

        // var_dump($app->router->getMatchedRoutes('GET', $app->request->getPathInfo()));
        // var_dump($app->request->getPathInfo());

        // $app->get('/woah', function () {
        //     var_dump('x');
        //     exit;
        // });
        $this->next->call();
        // }

    }
}
