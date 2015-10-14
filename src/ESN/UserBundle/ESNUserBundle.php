<?php

namespace ESN\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ESNUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
