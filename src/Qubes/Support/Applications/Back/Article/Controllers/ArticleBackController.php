<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:19
 */

namespace Qubes\Support\Applications\Back\Article\Controllers;

use Cubex\Data\Transportable\TransportMessage;
use Cubex\Facade\Redirect;
use Cubex\Form\Form;
use Cubex\Routing\Templates\ResourceTemplate;
use Qubes\Support\Applications\Back\Article\Views\ArticleForm;
use Qubes\Support\Applications\Back\Article\Views\Index;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Article\Mappers\ArticleSection;
use Qubes\Support\Components\Content\Article\Mappers\ArticleSectionBlock;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;

class ArticleBackController extends BaseBackController
{
  public function preRender()
  {
    parent::preRender();
    $this->requireCss('base');
  }

  public function renderIndex()
  {
    $articles = Article::collection()->loadAll();
    return $this->createView(new Index($articles));
  }

  public function renderNew()
  {
    $this->requireJs('article');
    $platforms = Platform::collection()->loadAll();
    return new ArticleForm('New Article', new Article(), $platforms);
  }

  public function postNew()
  {
    $postData   = $this->request()->postVariables();
    $newArticle = new Article();
    $newArticle->hydrateFromUnserialized($postData);
    $newArticle->saveChanges();

    Redirect::to('/' . $this->baseUri() . '/' . $newArticle->id() . '/edit')
    ->with(
      'msg',
      new TransportMessage('success', 'New Article was successfully added')
    )->now();
  }

  public function renderEdit()
  {
    $articleId = $this->getInt('id');
    $platforms = Platform::collection()->loadAll();

    $this->requireJs('article');
    $this->requireJs('articleEdit');
    $this->requireJs('autoSave');
    $this->requireCss('articleEdit');
    return $this->createView(
      new ArticleForm("Edit Article", new Article($articleId), $platforms)
    );
  }

  public function postEdit()
  {
    $postData = $this->request()->postVariables();
    $article  = new Article($postData['id']);
    $article->hydrateFromUnserialized($postData);
    $article->saveChanges();

    Redirect::to('/' . $this->baseUri() . '/' . $article->id() . '/edit')->with(
      'msg',
      new TransportMessage('success', 'Article was successfully updated')
    )->now();
  }

  public function renderDestroy()
  {
    $articleId = $this->getInt('id');
    $article   = new Article($articleId);
    $article->delete();

    $sections = ArticleSection::collection(
      ['article_id' => $articleId]
    );

    foreach($sections as $section)
    {
      $articleSection = new ArticleSection($section->id());
      $articleSection->delete();

      $sectionBlocks = ArticleSectionBlock::collection(
        ['article_section_id' => $section->id()]
      );

      foreach($sectionBlocks as $block)
      {
        $block->delete();
      }
    }

    Redirect::to('/' . $this->baseUri())->with(
      'msg',
      new TransportMessage('success', 'Article was successfully deleted')
    )->now();
  }

  public function getRoutes()
  {
    $routes = ResourceTemplate::getRoutes();
    return $routes;
  }
}
