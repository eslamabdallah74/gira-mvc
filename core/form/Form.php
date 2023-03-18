<?php

namespace gira\core\form;

use gira\models\Model;

class Form
{
    public static function begin($method, $action)
    {
        echo sprintf('<form method="%s" action="%s">', $method, $action);
        return new Form();
    }

    public static function end(string $buttonName)
    {
        echo sprintf(
            '
            <button type="submit" class="btn btn-primary my-4">%s</button>
            <form />
        ',
            $buttonName
        );
    }

    public function filed(Model $model, string $attribute, string $label, string $filedType,string $placeholder)
    {
        return new Filed($model, $attribute, $label, $filedType,$placeholder);
    }
}
