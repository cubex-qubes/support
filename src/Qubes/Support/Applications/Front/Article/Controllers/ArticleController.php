<?php
namespace Qubes\Support\Applications\Front\Article\Controllers;

use dflydev\markdown\MarkdownParser;
use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Article\Views\ArticleView;
use Qubes\Support\Components\Content\Article\Mappers\Article;

class ArticleController extends FrontController
{
  /**
   * Render an Article
   *
   * @param $id
   * @param $slug
   *
   * @return ArticleView
   */
  public function renderArticle($id, $slug)
  {
    $article = new Article($id);
    if(!$article->exists())
    {
      return $this->renderNotFound();
    }

    /** @var ArticleView $view */
    $view = $this->getView('ArticleView');
    $view->setArticle($article);

    return $this->setView($view);
  }

  public function renderPdf($id, $platformId)
  {
    $article = new Article($id);
    if(!$article->exists())
    {
      return $this->renderNotFound();
    }

    $markdown = new MarkdownParser();

    $pdf = new \mPDF();

    $pdf->WriteHTML(sprintf('<h1>%s</h1>', $article->title));

    if($article->title)
    {
      $pdf->WriteHTML(sprintf('<h2>%s</h2>', $article->subTitle));
    }

    foreach($article->getArticleSections() as $section)
    {
      foreach($section->getBlocks($platformId) as $block)
      {
        $pdf->WriteHTML($markdown->transformMarkdown($block->content));
        $pdf->WriteHTML('<br/>');
      }
    }

    $pdf->Output();
    exit;
  }

  /**
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    return [
      '/article/:id@num:slug@all' => 'article',
      '/article/pdf/:id@num/:platformId@num'  => 'pdf',
    ];
  }
}
