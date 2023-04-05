<?php

namespace gira\core;

class Response extends Session
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }


    public function redirect(string $location)
    {
        header('Location: ' . $location);
    }

    public function redirectWithMessage(string $location, string $FlashKey, string $FlashMessage)
    {
        $this->setFlash($FlashKey, $FlashMessage);
        header('Location: ' . $location);
    }
}
