<?php

namespace gira\core;

class Request
{

    /**
     * removeParams
     *
     * @param  mixed $path
     * 
     */
    protected function removeParams($path)
    {
        $haveParams     = strpos($path, '?');
        if ($haveParams) {
            return substr($path, 0, $haveParams);
        }
    }

    /**
     * getPath
     * @return string 
     * Example '/users'
     */
    public function getPath()
    {
        $originalPath       = $_SERVER['REQUEST_URI'] ?? '/';
        $haveParams         = $this->removeParams($originalPath);
        return $haveParams  ? $haveParams : $originalPath;
    }

    /**
     * getMethod
     * @return string
     * Example 'post'
     */
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * getBody
     * @return mixed
     */
    public function getBody()
    {
        $body = [];
        if ($this->getMethod() === 'get') {
            $body = $this->filterInput($_GET, INPUT_GET, $body);
        }
        if ($this->getMethod() === 'post') {
            $body = $this->filterInput($_POST, INPUT_POST, $body);
        }
        return $body;
    }
    
    /**
     * filterInput
     * @param  mixed $superGlobalMethod
     * @param  mixed $type
     * @param  mixed $body
     * @return mixed
     */
    protected function filterInput($superGlobalMethod, $type, $body)
    {
        foreach ($superGlobalMethod as $key => $value) {
            $body[$key] = filter_input($type, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $body;
    }
}
