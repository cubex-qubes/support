<?php
namespace Qubes\Support\Components\Content\Walkthrough\Mappers;


use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Walkthrough\Mappers\WalkthroughText;

class Walkthrough extends I18nRecordMapper
{
  public $categoryId;
  public $title;
  public $subTitle;
  public $description;

  public function getTextContainer()
  {
    return new WalkthroughText;
  }
}
