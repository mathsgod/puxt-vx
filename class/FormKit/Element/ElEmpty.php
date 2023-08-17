<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElEmpty extends ComponentNode
{
    /**
     * image URL
     */
    function image(string $value)
    {
        $this->setAttribute('image', $value);
        return $this;
    }

    /**
     * description
     */
    function description(string $value)
    {
        $this->setAttribute('description', $value);
        return $this;
    }

    /**
     * image size (width)
     */
    function imageSize(int $value)
    {
        $this->setAttribute('image-size', $value);
        return $this;
    }
}
