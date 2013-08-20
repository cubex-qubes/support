<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:19
 */

namespace Qubes\Support\Applications\Back\Article\Controllers;

use Cubex\Core\Http\Response;
use Cubex\Data\Transportable\TransportMessage;
use Cubex\Facade\Redirect;
use Cubex\Form\Form;
use Cubex\Routing\StdRoute;
use Cubex\Routing\Templates\ResourceTemplate;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Article\Mappers\ArticleSection;
use Qubes\Support\Components\Content\Article\Mappers\ArticleSectionBlock;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;

class ArticleSectionBackController extends BaseBackController
{
  public function renderIndex()
  {
    return "Block Controller";
  }

  public function renderNew()
  {
    $articleId = $this->getInt('id');

    //if user tries to create a section before an article exists,
    //create the article for them and give them a section to write in
    if($articleId == 0)
    {
      $article           = new Article();
      $article->title    = '';
      $article->subTitle = '';
      $article->saveChanges();

      $articleId = $article->id();
    }

    $platforms = Platform::collection()->loadAll();

    if($platforms->hasMappers())
    {
      $blockGroup            = new ArticleSection();
      $blockGroup->articleId = $articleId;
      $blockGroup->order     = ArticleSection::collection(
                                 ['article_id' => $articleId]
                               )->count() + 1;
      $blockGroup->saveChanges();

      foreach($platforms as $platform)
      {
        $sectionBlock                   = new ArticleSectionBlock();
        $sectionBlock->articleSectionId = $blockGroup->id();
        $sectionBlock->platformId       = $platform->id();
        $sectionBlock->title            = '';
        $sectionBlock->content          = '';
        $sectionBlock->saveChanges();
      }

      Redirect::to('/admin/article/' . $articleId . '/edit')->now();
    }
    else
    {
      Redirect::to('/admin/article/' . $articleId . '/edit')
      ->with(
          'msg',
          new TransportMessage(
            'error',
            'Failed to add section to article. No Platforms exist. ' .
            'Ensure you had created ' .
            'some platforms first. <a href="/admin/platform/new">' .
            'Create Platform Now</a>'
          )
        )->now();
    }
  }

  public function ajaxEdit()
  {
    $postData = $this->request()->postVariables();

    $sectionBlock                   = ArticleSectionBlock::loadWhereOrNew(
      [
      'article_section_id' => $postData['sectionId'],
      'platform_id'        => $postData['platformId']
      ]
    );
    $sectionBlock->articleSectionId = $postData['sectionId'];
    $sectionBlock->platformId       = $postData['platformId'];
    $sectionBlock->title            = $postData['title'];
    $sectionBlock->content          = $postData['content'];
    $sectionBlock->saveChanges();

    $msg       = new \stdClass();
    $msg->type = 'success';
    $msg->text = 'Block was successfully saved';

    return new Response(json_encode($msg));
  }

  public function renderOrder()
  {
    $sectionId = $this->getInt('id');
    $direction = $this->getStr('direction');

    $blockGroup = new ArticleSection($sectionId);

    $oldOrder  = $blockGroup->order;
    $lastOrder = ArticleSection::collection(
                   ['article_id' => $blockGroup->articleId]
                 )->count();

    if($oldOrder == 1 && $direction == 'up'
      || $oldOrder == $lastOrder && $direction == 'down'
    )
    {
      // Invalid Order Action
      Redirect::to('/admin/article/' . $blockGroup->articleId . '/edit')->now();
    }
    else
    {
      $oldOrder = (int)$oldOrder;
      switch($direction)
      {
        case 'up':
          $swapOrder = $oldOrder - 1;
          $swapOrder = ($swapOrder < 1) ? 0 : $swapOrder;
          break;
        case 'down':
          $swapOrder = $oldOrder + 1;
          break;
      }

      $swapBlockGroup = ArticleSection::collection()->loadWhere(
                          [
                          'article_id' => $blockGroup->articleId,
                          'order'      => $swapOrder
                          ]
                        )->first();
      if($swapBlockGroup !== null)
      {
        $swapBlockGroup->order = $oldOrder;
        $swapBlockGroup->saveChanges();
      }

      $blockGroup->order = $swapOrder;
      $blockGroup->saveChanges();
      Redirect::to('/admin/article/' . $blockGroup->articleId . '/edit')->now();
    }
  }

  public function renderDestroy()
  {
    $sectionId      = $this->getInt('id');
    $articleSection = new ArticleSection($sectionId);
    $articleSection->delete();

    $sectionBlocks = ArticleSectionBlock::collection(
      ['article_section_id' => $sectionId]
    );

    foreach($sectionBlocks as $block)
    {
      $block->delete();
    }

    Redirect::to('/admin/article/' . $articleSection->articleId . '/edit')->now(
    );

    die;
  }


  public function getRoutes()
  {
    $routes   = ResourceTemplate::getRoutes();
    $routes[] = new StdRoute('/:id/order/(?<direction>(up|down))', 'order');
    return $routes;
  }
}
