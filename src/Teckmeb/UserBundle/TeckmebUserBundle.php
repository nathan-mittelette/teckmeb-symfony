<?php

namespace Teckmeb\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TeckmebUserBundle extends Bundle
{
    public function getParent()
  {
    return 'FOSUserBundle';
  }
}
