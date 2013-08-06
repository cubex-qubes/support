<?php
namespace Qubes\Support\Applications\Front\Index\Views;

use Qubes\Support\Applications\Front\Base\Views\FrontView;

class IndexView extends FrontView
{

  public function __construct()
  {
    $this->setTitle($this->t("Index"));
  }

}


