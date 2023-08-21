<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ComponentBaseNode extends Component
{

    protected $props = [];
    protected $translator;

    public function addComponent(string $name, array $props = []): ComponentNode
    {
        //check to kebab case
        $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));

        /** @var Schema $schema */
        $schema = $this->ownerDocument;
        $schema->registerClass($name, ComponentNode::class);


        $comp = $this->appendHTML("<{$name}></{$name}>")[0];
        foreach ($props as $key => $value) {
            $comp->setAttribute($key, $value);
        }
        return $comp;
    }
    
    public function setClass(string $class)
    {
        $this->setProp('class', $class);
        return $this;
    }

    /**
     * @deprecated use setAttribute instead
     */
    public function setProp(string $key, $value)
    {
        if (is_bool($value)) {
            if ($value) {
                $this->setAttribute($key, '');
            } else {
                $this->removeAttribute($key);
            }
        } elseif (!is_string($value)) {
            $this->setAttribute(":{$key}", json_encode($value, JSON_UNESCAPED_UNICODE));
        } else {
            $this->setAttribute($key, $value);
        }
        return $this;
    }



    public function setAttribute(string $qualifiedName, $value)
    {
        if (!is_string($value)) {
            return parent::setAttribute(":{$qualifiedName}", json_encode($value, JSON_UNESCAPED_UNICODE));
        }
        return parent::setAttribute($qualifiedName, $value);
    }
}
