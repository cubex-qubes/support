<?php
/**
 * Block Text Container
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Block;

use Cubex\Mapper\Database\I18n\TextContainer;

class BlockTextContainer extends TextContainer
{
  /**
   * @datatype mediumtext
   */
  public $text;
}
