<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class File extends FormKitNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        parent::__construct('file', [], $translator);
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#accept
     */
    function accept(string $accept)
    {
        $this->property['accept'] = $accept;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#capture
     */
    function capture(bool $capture)
    {
        $this->property['capture'] = $capture;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#multiple
     */
    function multiple(bool $multiple)
    {
        $this->property['multiple'] = $multiple;
        return $this;
    }

    /**
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#webkitdirectory
     */
    function webkitdirectory(bool $webkitdirectory)
    {
        $this->property['webkitdirectory'] = $webkitdirectory;
        return $this;
    }

    /**
     * 	Specifies an icon to put in the fileItemIcon section. Only shows when there is a file selected. Defaults to the fileDoc icon.
     */
    function fileItemIcon(string $fileItemIcon)
    {
        $this->property['file-item-icon'] = $fileItemIcon;
        return $this;
    }

    /**
     * Specifies an icon to put in the fileRemoveIcon section. Only shows when a file is selected. Defaults to the close icon.
     */
    function fileRemoveIcon(string $fileRemoveIcon)
    {
        $this->property['file-remove-icon'] = $fileRemoveIcon;
        return $this;
    }

    /**
     * no-files-icon
     */
    function noFilesIcon(string $noFilesIcon)
    {
        $this->property['no-files-icon'] = $noFilesIcon;
        return $this;
    }
}
