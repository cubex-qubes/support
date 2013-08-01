<?php
/**
 * Platform Text Container
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Platform\Mappers;

use Cubex\Mapper\Database\I18n\TextContainer;

class PlatformText extends TextContainer
{
  /**
   * @datatype mediumtext
   */
  public $text;
}
