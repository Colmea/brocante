<?php

namespace Brocante\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BrocanteUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
