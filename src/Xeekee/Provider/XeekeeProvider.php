<?php

namespace Xeekee\Provider;

class XeekeeProvider extends \Bono\Provider\Provider
{
    public function initialize()
    {
        $app = $this->app;

        $app->filter('auth.authorize', function ($options) use ($app) {
            if (is_bool($options)) {
                return $options;
            }

            $uri = (is_array($options)) ? $options['uri'] : $options;

            if ($uri === '') {
                return true;
            }

            $segments = explode('/', $uri);
            if ($segments[1] !== 'admin') {
                if (!is_null($app->request->get('edit')) && empty($_SESSION['user'])) {
                    return false;
                }
                return true;
            }

            return $options;
        });
    }
}
