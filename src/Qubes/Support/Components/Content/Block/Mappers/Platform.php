<?php
/**
 * Platform, i.e. Windows, Mac, Linux
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Block\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Block\BlockTextContainer;

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
   * @return BlockTextContainer
   */
  public function getTextContainer()
  {
    return new BlockTextContainer();
  }

}
