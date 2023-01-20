<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTimeline extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTimeline', $property, $translator);
    }

    public function addTimelineItem()
    {

        $timeline = new ElTimelineItem([], $this->translator);
        $this->children[] = $timeline;
        return $timeline;
    }
}
