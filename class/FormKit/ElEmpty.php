<?php

namespace FormKit;

class ElEmpty extends ComponentNode
{
    public function __construct()
    {
        parent::__construct('ElEmpty');
    }

    /**
     * image URL
     */
    function image(string $value)
    {
        $this->props['image'] = $value;
        return $this;
    }

    /**
     * description
     */
    function description(string $value)
    {
        $this->props['description'] = $value;
        return $this;
    }

    /**
     * image size (width)
     */
    function imageSize(int $value)
    {
        $this->props['imageSize'] = $value;
        return $this;
    }
}
