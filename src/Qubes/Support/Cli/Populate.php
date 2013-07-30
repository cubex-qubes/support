<?php
/**
 * Populate the database with demo content
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Cli;

use Cubex\Cli\CliCommand;
use Cubex\Cli\Shell;
use Cubex\Cli\UserPrompt;
use Cubex\FileSystem\FileSystem;
use Cubex\Mapper\Database\RecordMapper;
use Cubex\Text\TextTable;
use Qubes\Support\Components\Content\Article\ArticleTextContainer;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Block\BlockTextContainer;
use Qubes\Support\Components\Content\Block\Mappers\Platform;
use Qubes\Support\Components\Content\Block\Mappers\PlatformBlock;
use Qubes\Support\Components\Content\Category\CategoryTextContainer;
use Qubes\Support\Components\Content\Category\Mappers\Category;
use Qubes\Support\Components\Content\Video\Mappers\Video;
use Qubes\Support\Components\Content\Video\VideoTextContainer;

class Populate extends CliCommand
{
  /**
   * Reset database!!!
   *
   * @valuerequired
   * @example true
   */
  public $reset = false;

  /**
   * Execute the process
   *
   * @return int|void
   */
  public function execute()
  {
    $this->_resetDatabase();
    $this->_print('Populating data...');
    $this->_addCategories();
    $this->_addArticles();
    $this->_addPlatforms();
    $this->_addPlatformBlocks();
    $this->_addWalkthroughs();
    $this->_addVideos();
    $this->_print('Demo content import complete!');
  }

  public function test()
  {
    $category = new Category(1);
    echo json_pretty($category->getChildCategories());
  }

  /**
   * Perform a database reset
   * --reset=true
   *
   * @return $this
   */
  protected function _resetDatabase()
  {
    if(!$this->reset)
    {
      return $this;
    }

    $this->_print(
      "***** Resetting Database!!! *****",
      true,
      Shell::COLOUR_FOREGROUND_BROWN,
      Shell::COLOUR_BACKGROUND_RED
    );

    $reset = UserPrompt::confirm('Are you sure? You will lose ALL data?');
    if(!$reset)
    {
      exit;
    }

    /** @var RecordMapper[] $mappers */
    $mappers = [
      new BlockTextContainer,
      new PlatformBlock,
      new Platform,
      new Category,
      new CategoryTextContainer,
      new Article,
      new ArticleTextContainer,
      new Video,
      new VideoTextContainer,
    ];

    foreach($mappers as $mapper)
    {
      $mapper->createTable(true);
      $this->_print(
        "Dropped " . $mapper->tableName(),
        true,
        Shell::COLOUR_FOREGROUND_LIGHT_GREY,
        Shell::COLOUR_BACKGROUND_RED
      );
    }

    $this->_print('Done, now run without flag...');
    exit;
  }

  /**
   * Add example categories
   *
   * @return $this
   */
  protected function _addCategories()
  {
    // Add parent categories
    $this->_print('Adding Categories: ', false);
    $count          = 0;
    $categoryTitles = $this->_getTitleArray('Category', rand(3, 6));
    foreach($categoryTitles as $categoryTitle)
    {
      $category              = new Category;
      $category->title       = $categoryTitle;
      $category->subTitle    = $this->_getExampleContent();
      $category->description = $this->_getExampleContent(rand(5, 15));
      $category->saveChanges();
      $count++;
    }
    $this->_print($count);

    // Add sub-categories
    $this->_print('Adding Sub-Categories: ', false);
    $count      = 0;
    $categories = Category::collection();
    foreach($categories as $category)
    {
      $categoryTitles = $this->_getTitleArray('Category', rand(0, 6));
      foreach($categoryTitles as $categoryTitle)
      {
        $category           = new Category;
        $category->parentCategoryId = $category->id();
        $category->title    = $categoryTitle;
        $category->subTitle = $this->_getExampleContent(rand(5, 15));
        $category->saveChanges();
        $count++;
      }
    }
    $this->_print($count);

    return $this;
  }

  /**
   * Add example platforms
   *
   * @return $this
   */
  protected function _addPlatforms()
  {
    $this->_print('Adding Platforms: ', false);
    $platformNames = array(
      'Windows',
      'Linux',
      'Mac',
      'Android',
      'iPhone',
      'iPad',
      'Blackberry',
    );

    foreach($platformNames as $platformName)
    {
      $platform              = new Platform;
      $platform->name        = $platformName;
      $platform->description = $this->_getExampleContent(rand(4, 6));
      $platform->saveChanges();
    }

    $this->_print(count($platformNames));

    return $this;
  }

  /**
   * Add platform blocks
   *
   * @return $this
   */
  protected function _addPlatformBlocks()
  {
    $this->_print('Adding Platform Blocks: ', false);
    $count = 0;

    $article = new Article(1);

    /** @var Platform[] $platforms */
    $platforms = Platform::collection();

    foreach($platforms as $platform)
    {
      $block            = new PlatformBlock;
      $block->articleId = $article->id();
      $block->content   = sprintf(
        'Example %s Block... %s',
        $platform->name,
        $this->_getExampleContent(rand(20, 60))
      );
      $block->saveChanges();
      $count++;

      $article->title = 'Article 1: Block Example';
      $article->saveChanges();
    }

    $this->_print($count);

    return $this;
  }


  /**
   * Add example articles
   *
   * @return $this
   */
  protected function _addArticles()
  {
    $this->_print('Adding Articles: ', false);
    $count = 0;

    /** @var Category[] $categories */
    $categories = Category::collection();

    foreach($categories as $category)
    {
      $articleTitles = $this->_getTitleArray('Article', rand(1, 3));
      foreach($articleTitles as $articleTitle)
      {
        $article             = new Article;
        $article->categoryId = $category->id();
        $article->title      = $articleTitle;
        $article->content    = $this->_getExampleContent(rand(20, 100));
        $article->saveChanges();
        $count++;
      }
    }

    $this->_print($count);

    return $this;
  }

  /**
   * Add example walkthroughs
   *
   * @return $this
   */
  protected function _addWalkthroughs()
  {
    $count = 0;

    $this->_print('Adding Walkthroughs: ', false);
    $this->_print($count);

    return $this;
  }

  /**
   * Add videos
   *
   * @return $this
   */
  protected function _addVideos()
  {
    $this->_print('Adding Videos: ', false);
    $count = 0;

    /** @var Category[] $categories */
    $categories = Category::collection();
    foreach($categories as $category)
    {
      $videoTitles = $this->_getTitleArray('Video', rand(1, 3));
      foreach($videoTitles as $videoTitle)
      {
        $video             = new Video;
        $video->title      = $videoTitle;
        $video->subTitle   = $this->_getExampleContent(rand(3, 15));
        $video->categoryId = $category->id();
        $video->saveChanges();
        $count++;
      }
    }

    $this->_print($count);

    return $this;
  }

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
    $message = 'info...',
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

  /**
   * Get an array of example titles
   *
   * @param string $prefix
   * @param int    $count
   *
   * @return array
   */
  protected function _getTitleArray($prefix = 'Title', $count = 10)
  {
    $data = [];
    $i    = 1;
    do
    {
      $data[] = $prefix . ' ' . $this->_getExampleContent(1);

      $i++;
    }
    while($i <= $count);

    return $data;
  }

  /**
   * Get a string to be used as example content
   *
   * @param int $wordCount
   *
   * @return string
   */
  protected function _getExampleContent($wordCount = 30)
  {
    $content = [];
    $i       = 1;
    do
    {
      $word = $this->_getRandomString();
      if($i == 1)
      {
        $word = ucfirst($word);
      }
      $content[] = $word;

      $i++;
    }
    while($i <= $wordCount);

    return implode(' ', $content);
  }

  /**
   * Get a random string between 2 & 10 characters
   *
   * @return string
   */
  protected function _getRandomString()
  {
    $length     = rand(2, 10);
    $characters = 'abcdefghijklmnoprstuvw';
    $string     = '';
    for($p = 0; $p < $length; $p++)
    {
      $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
  }
}
