<?php

namespace VX\UI\EL;

use P\HTMLElement;

class _Empty extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-empty");
    }

    /**
     * image URL
     */
    function setImage(string $image)
    {
        $this->setAttribute("image", $image);
    }

    /**
     * image size (width)
     */
    function setImageSize(int $width)
    {
        $this->setAttribute(":image-size", $width);
    }

    function setDescription(string $description)
    {
        $this->setAttribute("description", $description);
    }
}
