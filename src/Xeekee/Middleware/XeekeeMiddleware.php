<?php

namespace Xeekee\Middleware;

use \Xeekee\Xeekee;

class XeekeeMiddleware extends \Slim\Middleware
{
    protected $app;
    protected $request;
    protected $response;

    public function call()
    {
        $options = array_merge(array(
            'baseDir' => 'data',
        ), $this->options ?: array());

        $this->app = $app = \App::getInstance();
        $this->request = $app->request;
        $this->response = $app->response;

        $app->get('/admin/workspace/:id/members', function ($id) use ($app) {
            $entry = \Norm::factory('Workspace')->findOne($id);
            $app->response->data('entry', $entry);
            $app->response->template('admin/workspace/members');
        });

        $app->post('/admin/workspace/:id/members', function ($id) use ($app) {
            try {
                $entry = \Norm::factory('Workspace')->findOne($id);

                $post = $app->request->post();
                if (empty($post['members'])) {
                    $members = array();
                } else {
                    foreach ($post['members'] as $member) {
                        if (!empty($member)) {
                            $members[] = $member;
                        }
                    }
                }

                $entry['members'] = $members;

                $entry->save();

                h('notification.info', 'Member updated.');

            } catch (\Exception $e) {
                h('notification.error', $e);
            }

            $app->response->data('entry', $entry);
            $app->response->template('admin/workspace/members');
        });

        $pathInfo = $app->request->getPathInfo();

        if (!is_null($app->controller) ||
            $pathInfo === '/logout' ||
            $pathInfo === '/login' ||
            $pathInfo === '/unauthorized') {
            $this->next->call();
            return;
        }

        $app->container->singleton('xeekeeTopPage', function ($c) use ($app) {
            return !(count($app->request->getSegments()) > 2);
        });

        $app->get($pathInfo ?: '/', array($this, 'show'));
        $app->post($pathInfo ?: '/', array($this, 'edit'));

        $this->next->call();

    }

    public function show()
    {
        $pathInfo = $this->app->request->getPathInfo();

        $xeekee = $this->get($pathInfo);

        if (!is_null($this->app->request->get('edit'))) {
            $this->response->data('entry', $xeekee);
            $this->response->template('xeekee/edit');
        } elseif ($xeekee->exists()) {
            $this->response->data('entry', $xeekee);
            $this->response->template('xeekee/read');
        } else {
            $this->app->redirect($pathInfo.'?edit');
        }
    }

    public function edit()
    {
        $post = $this->request->post();

        $post['author'] = $_SESSION['user']['username'];
        $post['sesuatu'] = 'dsadasd';

        $this->get($this->request->getPathInfo())->save($post);

        $this->app->redirect(\URL::current());
    }

    public function get($pathInfo)
    {
        return new Xeekee($this, $pathInfo);
    }

    public function getBaseDir()
    {
        return getcwd().'/../data';
    }
}
