<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class QCard extends ComponentNode
{
    public function tag(string $tag)
    {
        $this->setAttribute("tag", $tag);
        return $this;
    }

    public function dark(bool $dark = true)
    {
        $this->setAttribute("dark", $dark);
        return $this;
    }

    public function square(bool $square = true)
    {
        $this->setAttribute("square", $square);
        return $this;
    }

    public function bordered(bool $bordered = true)
    {
        $this->setAttribute("bordered", $bordered);
        return $this;
    }

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
