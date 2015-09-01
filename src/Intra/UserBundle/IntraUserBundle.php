<?php

namespace Intra\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IntraUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
