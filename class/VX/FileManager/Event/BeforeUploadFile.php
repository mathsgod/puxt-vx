<?php

namespace VX\FileManager\Event;

use Psr\Http\Message\UploadedFileInterface;

class BeforeUploadFile
{
    public $target;

    public function __construct(UploadedFileInterface $target)
    {
        $this->target = $target;
    }
}
