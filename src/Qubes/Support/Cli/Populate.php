<?php
namespace Qubes\Support\Cli;

use Cubex\Cli\Shell;
use Cubex\Cli\UserPrompt;
use Cubex\FileSystem\FileSystem;
use Cubex\I18n\Processor\Cli;
use Cubex\Mapper\Database\RecordMapper;
use Cubex\Text\TextTable;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Article\Mappers\ArticleText;
use Qubes\Support\Components\Content\Article\Mappers\Block;
use Qubes\Support\Components\Content\Article\Mappers\BlockGroup;
use Qubes\Support\Components\Content\Category\Mappers\Category;
use Qubes\Support\Components\Content\Category\Mappers\CategoryText;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;
use Qubes\Support\Components\Content\Platform\Mappers\PlatformText;
use Qubes\Support\Components\Content\Video\Mappers\Video;
use Qubes\Support\Components\Content\Video\Mappers\VideoText;
use Qubes\Support\Components\User\Mappers\User;

/**
 * Populate the database with demo content
 */
class Populate extends Cli
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
    echo 'Populating data...' . PHP_EOL;
    $this->_addUsers();
    $this->_addPlatforms();
    $this->_addCategories();
    $this->_addArticles();
    $this->_addWalkthroughs();
    $this->_addVideos();
    echo 'Demo content import complete!' . PHP_EOL;
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

    echo Shell::colourText(
      "***** Resetting Database!!! *****",
      true,
      Shell::COLOUR_FOREGROUND_BROWN,
      Shell::COLOUR_BACKGROUND_RED
    );
    echo PHP_EOL;

    $reset = UserPrompt::confirm('Are you sure? You will lose ALL data?');
    if(!$reset)
    {
      exit;
    }

    /** @var RecordMapper[] $mappers */
    $mappers = [
      new User,
      new Platform,
      new PlatformText,
      new Category,
      new CategoryText,
      new Article,
      new ArticleText,
      new Block,
      new BlockGroup,
      new Video,
      new VideoText,
    ];

    foreach($mappers as $mapper)
    {
      $mapper->createTable(true);
      echo Shell::colourText(
        sprintf("Dropped & Created `%s`", $mapper->tableName()),
        true,
        Shell::COLOUR_FOREGROUND_LIGHT_GREY,
        Shell::COLOUR_BACKGROUND_RED
      );
      echo PHP_EOL;
    }

    echo 'Done, now run without flag...' . PHP_EOL;
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
    echo 'Adding Categories: ';
    $count          = 0;
    $categoryTitles = $this->_getTitleArray('Category', rand(2, 4));
    foreach($categoryTitles as $categoryTitle)
    {
      $subCategory              = new Category;
      $subCategory->title       = $categoryTitle;
      $subCategory->subTitle    = $this->_getExampleContent();
      $subCategory->description = $this->_getExampleContent(rand(5, 15));
      $subCategory->saveChanges();
      $count++;
    }
    echo $count . PHP_EOL;

    // Add sub-categories
    echo 'Adding Sub-Categories: ';
    $count      = 0;
    $categories = Category::collection();

    foreach($categories as $category)
    {
      $subCategoryCount = rand(1, 2);

      $categoryTitles = $this->_getTitleArray('Category', $subCategoryCount);
      foreach($categoryTitles as $categoryTitle)
      {
        $subCategory                   = new Category;
        $subCategory->parentCategoryId = $category->id();
        $subCategory->title            = $categoryTitle;
        $subCategory->subTitle         = $this->_getExampleContent(rand(5, 15));
        $subCategory->saveChanges();
        $count++;
      }
    }
    echo $count . PHP_EOL;

    return $this;
  }

  /**
   * Add example platforms
   *
   * @return $this
   */
  protected function _addPlatforms()
  {
    echo 'Adding Platforms: ';
    $platformNames = array(
      'Generic',
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
      $platform              = new Platform();
      $platform->name        = $platformName;
      $platform->description = $this->_getExampleContent(rand(4, 6));
      $platform->saveChanges();
    }

    echo count($platformNames) . PHP_EOL;

    return $this;
  }

  protected function _addUsers()
  {
    echo 'Adding Users: ';

    $users = [
      'admin' => 'admin'
    ];

    foreach($users as $username => $password)
    {
      $user           = new User;
      $user->username = $username;
      $user->password = password_hash($password, PASSWORD_DEFAULT);
      $user->saveChanges();
    }

    echo count($users) . PHP_EOL;
  }

  /**
   * Add example articles
   *
   * @return $this
   */
  protected function _addArticles()
  {
    echo 'Adding Articles: ';
    $count = 0;

    /** @var Category[] $categories */
    $categories = Category::collection();

    /** @var Platform[] $platforms */
    $platforms = Platform::collection();

    foreach($categories as $category)
    {
      $articleTitles = $this->_getTitleArray('Article', rand(1, 3));
      foreach($articleTitles as $articleTitle)
      {
        $article             = new Article;
        $article->categoryId = $category->id();
        $article->title      = $articleTitle;
        $article->subTitle   = $this->_getExampleContent(rand(4, 20));
        $article->saveChanges();

        $blockCount = rand(2, 6);
        $i          = 0;
        do
        {
          $blockGroup            = new BlockGroup;
          $blockGroup->articleId = $article->id();
          $blockGroup->saveChanges();

          foreach($platforms as $platform)
          {
            $block                          = new Block;
            $block->blockGroupId = $blockGroup->id();
            $block->platformId              = $platform->id();
            $block->title                   = $this->_getExampleContent(
              3
            );
            $block->content                 = $this->_getExampleContent(
              rand(10, 30)
            );
            $block->saveChanges();
          }

          $i++;
        }
        while($i <= $blockCount);

        $count++;
      }
    }

    echo $count . PHP_EOL;

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

    echo 'Adding Walkthroughs: ';
    echo $count . PHP_EOL;

    return $this;
  }

  /**
   * Add videos
   *
   * @return $this
   */
  protected function _addVideos()
  {
    echo 'Adding Videos: ';
    $count = 0;

    /** @var Category[] $categories */
    $categories = Category::collection();
    foreach($categories as $category)
    {
      if(!(bool)rand(0, 3))
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
    }

    echo $count . PHP_EOL;

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
