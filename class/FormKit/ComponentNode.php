<?php

namespace FormKit;

use DOMNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentNode extends Component
{
    protected $translator;
    public function setProp(string $key, $value)
    {
        if (is_bool($value)) {
            if ($value) {
                $this->setAttribute($key, '');
            } else {
                $this->removeAttribute($key);
            }
        } else {
            $this->setAttribute($key, $value);
        }
        return $this;
    }

    public function addChildren($children)
    {
        return $this->append($children);
    }

    public function children($children)
    {
        $this->append($children);
        return $this;
    }
}
