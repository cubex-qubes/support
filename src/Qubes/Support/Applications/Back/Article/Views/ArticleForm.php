<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 13:24
 */

namespace Qubes\Support\Applications\Back\Article\Views;

use Cubex\Form\Form;
use Cubex\Form\FormElement;
use Cubex\Foundation\Container;
use Cubex\View\TemplatedViewModel;
use Qubes\Support\Components\Content\Category\Mappers\Category;

class ArticleForm extends TemplatedViewModel
{
  public $heading;
  protected $_form;
  protected $_platforms;
  protected $_article;


  public function __construct($heading, $articleMapper, $platforms)
  {
    $this->heading = $heading;
    $this->_platforms = $platforms;
    $this->_article = $articleMapper;
  }

  public function form()
  {
    if($this->_form == null)
    {
      $this->_form = new Form('articleForm', '');
      $this->_form->setDefaultElementTemplate('{{input}}');

      $this->_form->addTextElement(
        "title",
        $this->_article->title
      );
      $this->_form->getElement("title")
      ->addAttribute('placeholder', 'Title');

      $this->_form->addTextElement(
        "subTitle",
        $this->_article->subTitle
      );
      $this->_form->getElement("subTitle")
      ->addAttribute('placeholder', 'Sub Title');

      $this->_form->addTextElement(
        "slug",
        $this->_article->slug
      );
      $this->_form->getElement("slug")
      ->addAttribute('placeholder', 'Slug');

      $this->_form->addSelectElement(
        'view',
        $this->getArticle()->getViewOptions()
      );

      $options = Category::collection()->getKeyPair('id', 'title');
      $this->_form->addSelectElement(
        'categoryId',
        $options,
        $this->_article->categoryId
      );

      $this->_appendArticleSectionForm();

      if($this->_article->exists())
      {
        $this->_form->addHiddenElement('id', $this->_article->id());
        $this->_form->addSubmitElement('Update Article');
      }
      else
      {
        $this->_form->addSubmitElement('Create Article');
      }

      $this->_form->getElement("submit")
      ->addAttribute('class', 'btn btn-success');
    }

    return $this->_form;
  }

  private function _appendArticleSectionForm()
  {
    foreach($this->getArticleSections() as $articleSection)
    {
      foreach($articleSection->getBlocks() as $platformBlock)
      {
        $articleSectionId = $articleSection->id();
        $platformId       = $platformBlock->platformId;

        $platformName = $platformBlock->getPlatform()->name;

        $this->_form->addTextElement(
          "title[$articleSectionId][$platformId]",
          $platformBlock->title
        );
        $this->_form->getElement("title[$articleSectionId][$platformId]")
        ->setRequired(false)
        ->addAttribute('class', 'block-title')
        ->addAttribute('placeholder', 'Title');

        $this->_form->addTextareaElement(
          "content[$articleSectionId][$platformId]",
          $platformBlock->content
        );
        $this->_form->getElement("content[$articleSectionId][$platformId]")
        ->setRequired(false)
        ->addAttribute('class', 'block-content');

        $this->_form->addElement(
          "submit[$articleSectionId][$platformId]",
          FormElement::BUTTON,
          "Save $platformName Block"
        );
        $this->_form->getElement("submit[$articleSectionId][$platformId]")
        ->addAttribute('class', 'btn btn-success save-block');
      }
    }
  }

  /**
   * @return \Qubes\Support\Components\Content\Article\Mappers\Article
   */
  public function getArticle()
  {
    return $this->_article;
  }

  /**
   * @return \Qubes\Support\Components\Content\Article\Mappers\ArticleSection[]
   */
  public function getArticleSections()
  {
    if($this->getArticle()->exists())
    {
      return $this->getArticle()->getArticleSections();
    }

    return [];
  }

  /**
   * @return \Qubes\Support\Components\Content\Platform\Mappers\Platform[]
   */
  public function getPlatforms()
  {
    return $this->_platforms;
  }
}
