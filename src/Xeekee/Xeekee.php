<?php

namespace Xeekee;

class Xeekee implements \ArrayAccess
{
    protected $middleware;
    protected $pathInfo;

    protected $file;
    protected $dir;

    protected $attributes = array();
    protected $workspace = '';

    public function __construct($middleware, $pathInfo)
    {
        $this->middleware = $middleware;

        $this->fetch($pathInfo);
    }

    public function offsetExists ($offset)
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet ($offset)
    {
        if (!$this->offsetExists($offset)) {
            return null;
        }
        return $this->attributes[$offset];
    }

    public function offsetSet ($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    public function offsetUnset ($offset)
    {
        unset($this->attributes[$offset]);
    }

    public function fetch($pathInfo)
    {
        $this->pathInfo = $pathInfo;
        $this->file = $this->middleware->getBaseDir().$pathInfo.'/index.md';
        $this->dir = dirname($this->file);

        $this->attributes = array();

        if (is_readable($this->file)) {
            $content = file_get_contents($this->file);
            $content = explode("\n\n", $content);
            $headLines = explode("\n", $content[0]);
            foreach ($headLines as $line) {
                $arr = explode(':', $line);
                $this->attributes[trim($arr[0])] = trim($arr[1]);
            }

            $this->attributes['body'] = $content[1];
        }

        return $this->attributes;
    }

    public function exists()
    {
        return !empty($this->attributes);
    }

    public function format()
    {
        return '';
    }

    public function save($data)
    {

        $data = @$data ?: array();
        $data['timestamp'] = date('Y-m-d H:i:s');

        if (is_readable($this->file)) {
            $data['revision'] = $this->attributes['revision'] + 1;
        } else {
            $data['revision'] = 1;
        }

        @mkdir($this->dir, 0755, true);

        $content = '';
        $body = '';
        foreach ($data as $key => $value) {
            if ($key === 'body') {
                $body = $value;
                continue;
            }
            $content .= $key.': '.$value."\n";
        }

        $content .= "\n";
        $content .= trim($body)."\n";

        $history = $this->dir.'/index.'.$data['revision'].'.md';

        file_put_contents($history, $content);
        file_put_contents($this->file, $content);

    }

    public function getWorkspace()
    {
        if ($this->workspace === '') {
            $this->workspace = \Norm::factory('Workspace')->findOne(array('path' => $this->pathInfo));
        }

        return $this->workspace;
    }

    public function isWorkspace()
    {
        return ($this->getWorkspace() !== null);
    }
}
