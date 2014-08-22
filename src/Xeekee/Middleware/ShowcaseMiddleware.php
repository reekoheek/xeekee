<?php

namespace Xeekee\Middleware;

class ShowcaseMiddleware extends \Slim\Middleware
{
    public function call()
    {
        $app = $this->app;

        $app->get('/', function () use ($app) {
            $q = $app->request->get('q');

            if (empty($q)) {
                $entries = \Norm::factory('Workspace')->find();
            } else {
                $entries = \Norm::factory('Workspace')->find(array(
                    '!or' => array(
                        array( 'title!like' => $q ),
                        array( 'path!like' => $q ),
                        array( 'description!like' => $q ),
                    )
                ));
            }

            $entries->sort(array('title' => 1))->limit(25);

            $app->response->set('entries', $entries);
            $app->response->set('q', $q);
            $app->response->template('xeekee/showcase');
        });

        $this->next->call();
    }
}
