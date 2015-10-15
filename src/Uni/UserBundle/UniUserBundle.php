<?php

namespace Uni\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UniUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
