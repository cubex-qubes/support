<?php
namespace Qubes\Support\Components\Content\Video\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;

/**
 * @method static \Qubes\Support\Components\Content\Video\Mappers\VideoCaption[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class VideoCaption extends I18nRecordMapper
{
  public $videoId;
  public $text;
  /**
   * @datatype int(11)
   */
  public $startSecond;
  /**
   * @datatype int(11)
   */
  public $endSecond;

  protected function _configure()
  {
    $this->_addTranslationAttribute('text');
  }

  /**
   * @return VideoText
   */
  public function getTextContainer()
  {
    return new VideoText;
  }
}
