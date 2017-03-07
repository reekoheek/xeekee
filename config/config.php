<?php

/**
 * Bono App Configuration
 *
 * @category  PHP_Framework
 * @package   Bono
 * @author    Ganesha <reekoheek@gmail.com>
 * @copyright 2013 PT Sagara Xinix Solusitama
 * @license   https://raw.github.com/xinix-technology/bono/master/LICENSE MIT
 * @version   0.10.0
 * @link      http://xinix.co.id/products/bono
 */

use Norm\Schema\String;
use Norm\Schema\Password;
use Norm\Schema\Text;
use Norm\Schema\NormArray;

return array(
    'bono.salt' => 'please change this',
    'bono.providers' => array(
        'Norm\\Provider\\NormProvider' => array(
            'datasources' => array(
                'mongo' => array(
                    'driver' => 'Norm\\Connection\\MongoConnection',
                    'database' => 'xeekee',
                ),
            ),
            'collections' => array(
                'mapping' => array(
                    'User' => array(
                        'schema' => array(
                            'username' => String::create('username')->filter('trim|required|unique:User,username'),
                            'password' => Password::create('password')->filter('trim|confirmed|salt'),
                            'email' => String::create('email')->filter('trim|required|unique:User,email'),
                            'first_name' => String::create('first_name')->filter('trim|required'),
                            'last_name' => String::create('last_name')->filter('trim|required'),
                        ),
                    ),
                    'Workspace' => array(
                        'schema' => array(
                            'path' => String::create('path')->filter('trim|required'),
                            'title' => String::create('title')->filter('trim|required'),
                            'description' => Text::create('description')->filter('trim'),
                            '$members' => NormArray::create('$members'),
                        ),
                    ),
                ),
            ),
        ),
        'Xinix\\Migrate\\Provider\\MigrateProvider' => array(
            // 'token' => 'changetokenherebeforeenable',
        ),
        'Xeekee\\Provider\\XeekeeProvider',
    ),
    'bono.middlewares' => array(
        'Xeekee\\Middleware\\XeekeeMiddleware' => array(
            'root' => 'home/anu'
        ),
        'Bono\\Middleware\\StaticPageMiddleware' => null,
        'Xeekee\\Middleware\\ShowcaseMiddleware' => array(),
        'Bono\\Middleware\\ControllerMiddleware' => array(
            'default' => 'Norm\\Controller\\NormController',
            'mapping' => array(
                '/admin/user' => null,
                '/admin/workspace' => null,
            ),
        ),
        // uncomment below to enable auth
        'ROH\\BonoAuth\\Middleware\\AuthMiddleware' => array(
            // 'driver' => 'ROH\\BonoAuth\\Driver\\NormAuth',
            'driver' => 'ROH\\BonoAuth\\Driver\\OAuth',
            'debug' => true,
            'baseUrl' => 'http://192.168.1.99/internal/account/www/index.php',
            'authUrl' => '/oauth/auth',
            'tokenUrl' => '/oauth/token',
            'revokeUrl' => '/oauth/revoke',
            'clientId' => '5413c7cdb75868b3278b4567.client.account.xinix.co.id',
            'clientSecret' => 'b96a2b17d92cd6debff65c21d94858a5',
            'redirectUri' => 'http://192.168.1.99/internal/xeekee/www/index.php/login',
            'scope' => 'user',
        ),
        'Bono\\Middleware\\NotificationMiddleware' => null,
        'Bono\\Middleware\\SessionMiddleware' => null,
        'Bono\\Middleware\\ContentNegotiatorMiddleware' => array(
            'extensions' => array(
                'json' => 'application/json',
            ),
            'views' => array(
                'application/json' => 'Bono\\View\\JsonView',
            ),
        ),
    ),

    'bono.theme' => array(
        'class' => 'ROH\\Theme\\BootstrapTheme',
        'overwrite' => true,
        'options' => array(
            'title' => 'XeeKee',
            'menu' => array(
                // array( 'label' => 'Home', 'url' => '/home' ),
                // array( 'label' => 'Container', 'url' => '/container' ),
                // array( 'label' => 'Network', 'url' => '/network' ),
                // array( 'label' => 'Template', 'url' => '/template' ),
                // array( 'label' => 'User', 'url' => '/user' ),
            ),
        ),
    ),
);
