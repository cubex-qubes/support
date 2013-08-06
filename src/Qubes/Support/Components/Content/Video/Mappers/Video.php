<?php
namespace Qubes\Support\Components\Content\Video\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;

/**
 * @method static \Qubes\Support\Components\Content\Video\Mappers\Video[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class Video extends I18nRecordMapper
{
  public $categoryId;
  public $title;
  public $subTitle;
  public $url;
  /**
   * @datatype int(11)
   */
  public $order;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'subTitle'
    );
  }

  /**
   * @return VideoText
   */
  public function getTextContainer()
  {
    return new VideoText;
  }
}
