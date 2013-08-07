<?php
namespace Qubes\Support\Components\Content\Walkthrough\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Walkthrough\Mappers\WalkthroughText;

class WalkthroughStep extends I18nRecordMapper
{
  public $walkthroughId;
  public $title;
  public $content;
  /**
   * @datatype int(11)
   */
  public $order;

  public function getTextContainer()
  {
    return new WalkthroughText;
  }
}
