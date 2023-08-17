<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QCard extends ComponentNode
{

    public function flat()
    {
        return $this->setProp("flat", true);
    }

    public function addSection(): QCardSection
    {
        return $this->appendHTML('<q-card-section></q-card-section>')[0];
    }
}
