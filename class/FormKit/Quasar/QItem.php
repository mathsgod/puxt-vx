<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QItem extends ComponentNode
{

    public function addSection(?string $string = null)
    {
        $section = $this->appendHTML('<q-item-section></q-item-section>')[0];

        if ($string) {
            $section->addChildren($string);
        }
        return $section;
    }
}
