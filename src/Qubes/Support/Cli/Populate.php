<?php
/**
 * Populate the database with demo content
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Cli;

use Cubex\Cli\Shell;
use Cubex\Cli\UserPrompt;
use Cubex\FileSystem\FileSystem;
use Cubex\Mapper\Database\RecordMapper;
use Cubex\Text\TextTable;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Article\Mappers\ArticleBlock;
use Qubes\Support\Components\Content\Article\Mappers\ArticleBlockContent;
use Qubes\Support\Components\Content\Article\Mappers\ArticleText;
use Qubes\Support\Components\Content\Category\Mappers\Category;
use Qubes\Support\Components\Content\Category\Mappers\CategoryText;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;
use Qubes\Support\Components\Content\Platform\Mappers\PlatformText;
use Qubes\Support\Components\Content\Video\Mappers\Video;
use Qubes\Support\Components\Content\Video\Mappers\VideoText;
use Qubes\Support\Components\User\Mappers\User;

class Populate extends BaseCli
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
    $this->_addUsers();
    $this->_addPlatforms();
    $this->_addCategories();
    $this->_addArticles();
    $this->_addWalkthroughs();
    $this->_addVideos();
    $this->_print('Demo content import complete!');
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
      new User,
      new Platform,
      new PlatformText,
      new Category,
      new CategoryText,
      new Article,
      new ArticleText,
      new ArticleBlock,
      new ArticleBlockContent,
      new Video,
      new VideoText,
    ];

    foreach($mappers as $mapper)
    {
      $mapper->createTable(true);
      $this->_print(
        sprintf("Dropped & Created `%s`", $mapper->tableName()),
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
    $this->_print($count);

    // Add sub-categories
    $this->_print('Adding Sub-Categories: ', false);
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

    $this->_print(count($platformNames));

    return $this;
  }

  protected function _addUsers()
  {
    $this->_print('Adding Users: ', false);

    $users = [
      'admin' => 'admin'
    ];

    foreach($users as $username => $password)
    {
      $user = new User;
      $user->username = $username;
      $user->password = md5($password);
      $user->saveChanges();
    }

    $this->_print(count($users));
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
          $block            = new ArticleBlock();
          $block->articleId = $article->id();
          $block->saveChanges();

          foreach($platforms as $platform)
          {
            $platformContent                 = new ArticleBlockContent();
            $platformContent->articleBlockId = $block->id();
            $platformContent->platformId     = $platform->id();
            $platformContent->title          = $this->_getExampleContent(3);
            $platformContent->content        = $this->_getExampleContent(
              rand(10, 30)
            );
            $platformContent->saveChanges();
          }

          $i++;
        }
        while($i <= $blockCount);

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

    $this->_print($count);

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
