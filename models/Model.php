<?php

namespace gira\models;

use gira\core\Validation;

abstract class Model extends Validation
{
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
  
}
