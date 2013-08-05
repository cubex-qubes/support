<?php
/**
 * SearchIndex View
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Applications\Front\Search\Views;

use Qubes\Support\Applications\Front\Base\Views\FrontView;

class SearchIndexView extends FrontView
{
  public function __construct()
  {
    $this->setTitle($this->t("Support : Search Results"));
  }
}
