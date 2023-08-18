<?php

namespace FormKit;

use DOMNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentNode extends Component
{
    use FormKitTrait;

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

            if (is_array($value)) {
                $this->setAttribute(":{$key}", json_encode($value, JSON_UNESCAPED_UNICODE));
            } else {
                $this->setAttribute($key, $value);
            }
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
    public function addComponent(string $name): ComponentNode
    {
        //check to kebab case
        $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));

        $schema = $this->ownerDocument;
        $schema->registerClass($name, ComponentNode::class);


        return $this->appendHTML("<{$name}></{$name}>")[0];
    }
}
