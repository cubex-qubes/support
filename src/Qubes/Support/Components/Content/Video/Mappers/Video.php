<?php
/**
 * Video Mapper
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Video\Mappers;


use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Video\VideoTextContainer;

class Video extends I18nRecordMapper
{
  public $categoryId;
  public $title;
  public $subTitle;
  public $url;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'subTitle'
    );
  }

  /**
   * @return VideoTextContainer
   */
  public function getTextContainer()
  {
    return new VideoTextContainer();
  }
}
