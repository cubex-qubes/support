<?php
/**
 * Category Text Container
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Category;

use Cubex\Mapper\Database\I18n\TextContainer;

class CategoryTextContainer extends TextContainer
{
  /**
   * @datatype mediumtext
   */
  public $text;
}