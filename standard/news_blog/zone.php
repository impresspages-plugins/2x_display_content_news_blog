<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog; 


if (!defined('CMS')) exit;

require_once(BASE_DIR.MODULE_DIR.'standard/content_management/zone.php');
require_once(__DIR__.'/element.php');


class Zone extends \Modules\standard\content_management\Zone {

  function getElements($languageId = null, $parentElementId = null, $startFrom = 0, $limit = null, $includeHidden = false, $reverseOrder = false) {
    global $site;


    $tmpElements = parent::getElements($languageId, $parentElementId, $startFrom, $limit, $includeHidden, $reverseOrder);
    $elements = array();
    if ($tmpElements) {
      foreach ($tmpElements as $key => $tmpElement) {
        $element = new NewsElement();
        $element->realElement = $tmpElement;
        $elements[] = $element;
      } 
    }
    
    return $elements;

  }



  function getElement($elementId) {
    $tmpAnswer = parent::getElement($elementId);
    if ($tmpAnswer) {
      $element = new NewsElement();
      $element->realElement = $tmpAnswer;
      return $element;
    } else {
      return $tmpAnswer;
    }
  }



  function getFirstElement($parentId, $level) {
    $tmpAnswer = parent::getFirstElement($parentId, $level);
    if ($tmpAnswer) {
      $element = new NewsElement();
      $element->realElement = $tmpAnswer;
      return $element;
    } else {
      return $tmpAnswer;
    }
  }

  function findElement($urlVars, $getVars) {
    $tmpAnswer = parent::findElement($urlVars, $getVars);
    if ($tmpAnswer) {
      $element = new NewsElement();
      $element->realElement = $tmpAnswer;
      return $element;
    } else {
      return $tmpAnswer;
    }    
  }



  public function generateNews($limit = null, $layout = null){
    global $site;
    if ($limit < 0) {
      $limit = 0;
    }
    $start = 0;
    $site->requireTemplate('standard/news_blog/template.php');
    
    $elements = $this->getElements(null, null, $start, $limit, false, true);
    $elements = array_reverse($elements);
    $answer = Template::generateList($elements, $layout);
    return $answer;
  }

  public function generateMainPage(){
    global $site;
    $site->requireTemplate('standard/news_blog/template.php');

    $elements = $this->getElements();
    $elements = array_reverse($elements);
    $answer = Template::generateMainPage($elements);
    return $answer;
  }

    
  
}
