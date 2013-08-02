<?php
/**
 * Base Cli script
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Cli;

use Cubex\Cli\CliCommand;
use Cubex\Cli\Shell;

abstract class BaseCli extends CliCommand
{
  /**
   * Print an info message
   *
   * @param string $message
   * @param bool   $eol
   * @param null   $foreground
   * @param null   $background
   *
   * @return $this
   */
  protected function _print(
    $message = '',
    $eol = true,
    $foreground = null,
    $background = null
  )
  {
    echo Shell::colourText(
      $message,
      $foreground,
      $background
    );

    if($eol)
    {
      echo PHP_EOL;
    }

    return $this;
  }
}
