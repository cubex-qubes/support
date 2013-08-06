<?php
namespace Qubes\Support\Components\Content\Platform\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;

/**
 * Platform, i.e. Windows, Mac, Linux
 *
 * @method static \Cubex\Mapper\Database\RecordCollection|\Qubes\Support\Components\Content\Platform\Mappers\Platform[] collection
 */
class Platform extends I18nRecordMapper
{
  public $name;
  public $description;

  /**
   * @return $this|void
   */
  protected function _configure()
  {
    $this->_addTranslationAttribute("description");
  }

  /**
   * @return PlatformText
   */
  public function getTextContainer()
  {
    return new PlatformText;
  }
}
