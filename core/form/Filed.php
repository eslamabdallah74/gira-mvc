<?php

namespace gira\core\form;

use gira\models\Model;

class Filed
{
    public Model $model;
    public string $attribute;
    public string $label;
    public string $type;
    public string $placeholder;


    public function __construct(Model $model, string $attribute, string $label, string $type, string $placeholder)
    {
        $this->model        = $model;
        $this->attribute    = $attribute;
        $this->label        = $label;
        $this->type         = $type;
        $this->placeholder  = $placeholder;
    }

    public function __toString()
    {
        return sprintf(
            '<div class="form-group">
                <label for="exampleInputEmail1">%s</label>
                <input type="%s" name="%s" value="%s" class="form-control %s" placeholder="%s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>',
            $this->label,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->placeholder,
            $this->model->getFirstError($this->attribute)
        );
    }
}
