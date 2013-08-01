<?php
/**
 * Category Text Container
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Category\Mappers;

use Cubex\Mapper\Database\I18n\TextContainer;

class CategoryText extends TextContainer
{
  /**
   * @datatype mediumtext
   */
  public $text;
}
