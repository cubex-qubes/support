<?php
/**
 * Platform, i.e. Windows, Mac, Linux
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Platform\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;


/**
 * Class Platform
 *
 * @package Qubes\Support\Components\Content\Platform\Mappers
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
