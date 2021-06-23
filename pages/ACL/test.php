{{a}}
<?php

return new class
{
    public $a = "a";
    public function get(VX $context)
    {
        $this->a = 123;
    }

    
};
