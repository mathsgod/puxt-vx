<?php

namespace FormKit;

use FormKit\Quasar\QuasarTrait;

class ElementNode extends \FormKit\SchemaDOMNode
{
    use QuasarTrait;
    use FormKitTrait;

    public function attr(string $name, $value)
    {
        $this->setAttribute($name, $value);
        return $this;
    }

    public function attrs(array $attrs)
    {
        foreach ($attrs as $name => $value) {
            $this->setAttribute($name, $value);
        }
        return $this;
    }

    function addElement(string $el, array $property = []): ElementNode
    {
        $element = $this->appendElement($el);

        foreach ($property as $key => $value) {
            $element->setAttribute($key, $value);
        }

        return $element;
    }

    function addChildren($children)
    {
        $this->appendHTML($children);

        return $this;
    }
}
