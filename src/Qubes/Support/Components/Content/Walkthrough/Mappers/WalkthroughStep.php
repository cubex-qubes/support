<?php
namespace Qubes\Support\Components\Content\Walkthrough\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Walkthrough\Mappers\WalkthroughText;

class WalkthroughStep extends I18nRecordMapper
{
  public $walkthroughId;
  public $title;
  public $content;
  public $slug;
  /**
   * @datatype int(11)
   */
  public $order;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'content'
    );
  }

  /**
   * @return \Cubex\Mapper\Database\RecordMapper|Walkthrough
   */
  public function getWalkthrough()
  {
    return $this->belongsTo(new Walkthrough, 'walkthroughId');
  }

  public function getTextContainer()
  {
    return new WalkthroughText;
  }
}
