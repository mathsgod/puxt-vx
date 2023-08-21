<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QCard extends ComponentNode
{

    public function flat(bool $flat = true)
    {
        $this->setAttribute("flat", $flat);
        return $this;
    }

    public function addSection(): QCardSection
    {
        return $this->appendHTML('<q-card-section></q-card-section>')[0];
    }
}
