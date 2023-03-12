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
}
