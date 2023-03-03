<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElContainer extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElContainer', $property, $translator);
    }

    function addHeader()
    {
        $header = new ElHeader([], $this->translator);
        $this->children[] = $header;
        return $header;
    }

    function addMain()
    {
        $main = new ElMain([], $this->translator);
        $this->children[] = $main;
        return $main;
    }

    function addFooter()
    {
        $footer = new ElFooter([], $this->translator);
        $this->children[] = $footer;
        return $footer;
    }

    function addAside()
    {
        $aside = new ElAside([], $this->translator);
        $this->children[] = $aside;
        return $aside;
    }

    function addContainer()
    {
        $container = new ElContainer([], $this->translator);
        $this->children[] = $container;
        return $container;
    }

    function direction(string $direction)
    {
        $this->props['direction'] = $direction;
        return $this;
    }
}
