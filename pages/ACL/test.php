{{a}}
<?php

return new class
{
    public $a = "a";
    public function get(VX $vx)
    {
        $this->a = 123;
    }
};
