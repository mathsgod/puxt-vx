<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTimeline extends ComponentBaseNode
{

    public function addTimelineItem(): ElTimelineItem
    {
        return $this->appendHTML('<el-timeline-item></el-timeline-item>')[0];
    }
}
