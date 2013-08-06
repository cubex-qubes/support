<?php
namespace Qubes\Support\Applications\Front\Search\Views;

use Qubes\Support\Applications\Front\Base\Views\FrontView;

class SearchIndexView extends FrontView
{
  public function __construct()
  {
    $this->setTitle($this->t("Support : Search Results"));
  }
}
