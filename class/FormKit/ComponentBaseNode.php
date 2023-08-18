<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentBaseNode extends Component
{

    protected $props = [];
    protected $translator;


    public function setClass(string $class)
    {
        $this->setProp('class', $class);
        return $this;
    }


    public function setProp(string $key, $value)
    {
        if (is_bool($value)) {
            if ($value === true) {
                $this->setAttribute($key, "");
            } else {
                $this->removeAttribute($key);
            }
        } elseif (is_array($value)) {
            $this->setAttribute(":$key", json_encode($value, JSON_UNESCAPED_UNICODE));
        }else{
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    public function addComponent(string $name)
    {
        $schema = $this->ownerDocument;
        $schema->registerClass($name, Component::class);
    }
}
