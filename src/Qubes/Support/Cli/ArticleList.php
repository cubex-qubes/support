<?php
namespace Qubes\Support\Cli;

use Cubex\Cli\Shell;
use Cubex\I18n\Processor\Cli;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;

/**
 * Display an article list
 */
class ArticleList extends Cli
{

  /**
   * Execute the process
   *
   * @return int|void
   */
  public function execute()
  {
    $articles = Article::collection();

    if($articles->count() === 0)
    {
      echo 'No articles to list.';
      exit;
    }

    $platforms = Platform::collection();

    foreach($articles as $article)
    {
      echo PHP_EOL;

      echo Shell::colourText(
        "Title: " . $article->title . PHP_EOL,
        true,
        Shell::COLOUR_FOREGROUND_BROWN,
        Shell::COLOUR_BACKGROUND_RED
      );
      echo 'Article ID:  ' . $article->id() . PHP_EOL;
      echo 'Sub-Title:   ' . $article->subTitle . PHP_EOL;
      echo 'View:   ' . $article . PHP_EOL;

      foreach($article->getBlockGroups() as $blockGroup)
      {
        foreach($blockGroup->getBlocks() as $block)
        {
          /** @var Platform $platform */
          $platform = $platforms->getById($block->platformId);

          echo PHP_EOL;
          echo 'Block Platform: ' . $platform->name . PHP_EOL;
          echo 'Block Title: ' . $block->title . PHP_EOL;
          echo 'Block Content: ' . $block->content . PHP_EOL;
        }
      }
      echo PHP_EOL;
    }

    return $this;
  }
}
