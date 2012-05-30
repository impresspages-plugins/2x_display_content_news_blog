<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2011 ImpressPages LTD
 * @license   GNU/GPL, see license.html
 */
namespace Modules\standard\news_blog;

if (!defined('CMS')) exit;




class Template{
  
  
  public static function generatePage($element, $widgets){
    $answer = '';
    foreach($widgets as $key => $widget){
      $answer .= $widget['html'];
      
      if ($key == 0) { //add date after first widget
        $answer .= '<div class="ipWidget ipWidgetText ipNewsDate"><p>'.htmlspecialchars(substr($element->getCreatedOn(), 0, 10)).'</p></div>';
      }
    }
    return $answer;
  }
  
  public static function generateList($elements, $layout = ''){
    global $parametersMod;
    $answer = '';
    
    
    foreach($elements as $key => $element){

      $record = '';
      
      switch ($layout) {
        case '':
        case 'news':
        default: 
          
          $lead = $element->getLead();
          
          $record .= 
'
<div class="ipWidget ipWidgetTitle ipDisplayContentNews">
	<h2 class="ipWidgetTitleHeading">
		<a href="'.$element->getLink().'">'.htmlspecialchars($element->getPageTitle()).'</a>
	</h2>
</div>
<div class="ipWidget ipWidgetText ipNewsDate">
	<p>'.htmlspecialchars(substr($element->getCreatedOn(), 0, 10)).'</p>
</div>
<div class="ipWidget ipWidgetText ipDisplayContentNewsLead">
  '.$lead.'
  <p>
    <a href="'.$element->getLink().'">'.htmlspecialchars($parametersMod->getValue('standard', 'news_blog', 'translations', 'more')).'</a>
  </p>
</div>
';  
          break;
        case 'blog':
          
          $widgets = $element->getWidgets();
          
          $content = '';
          
          foreach ($widgets as $key => $widget) {
            if ($key != 0) { //skip title widget. It is generated automatically
              $content .= $widget['html'];
            }
          }
          
          $record .= 
'
<div class="ipWidget ipWidgetTitle ipDisplayContentNews">
	<h2 class="ipWidgetTitleHeading">
		<a href="'.$element->getLink().'">'.htmlspecialchars($element->getPageTitle()).'</a>
	</h2>
</div>
<div class="ipWidget ipWidgetText ipNewsDate">
	<p>'.htmlspecialchars(substr($element->getCreatedOn(), 0, 10)).'</p>
</div>
'.$content.'
<div class="ipWidget ipWidgetTitle ipDisplayContentNewsMore">
	<p>
		<a href="'.$element->getLink().'">'.htmlspecialchars($parametersMod->getValue('standard', 'news_blog', 'translations', 'more')).'</a>
	</p>
</div>
';
          break;
        case 'newsIntro':

          $widgets = $element->getWidgets();
          
          if (isset($widgets[1])) { //first widget is title. So skip it because the title is generated automatically.
            $intro = $widgets[1]['html'];  
          } else {
            $intro = '';
          }
          
          $record = 
'
<div class="ipWidget ipWidgetTitle ipDisplayContentNews">
	<h2 class="ipWidgetTitleHeading">
		<a href="'.$element->getLink().'">'.htmlspecialchars($element->getPageTitle()).'</a>
	</h2>
</div>
<div class="ipWidget ipWidgetText ipNewsDate">
	<p>'.htmlspecialchars(substr($element->getCreatedOn(), 0, 10)).'</p>
</div>
'.$intro.'
<div class="ipWidget ipWidgetTitle ipDisplayContentNewsMore">
	<p>
		<a href="'.$element->getLink().'">'.htmlspecialchars($parametersMod->getValue('standard', 'news_blog', 'translations', 'more')).'</a>
	</p>
</div>
';          
          break;
          
      }
      
      $answer = $record.$answer; 
      
      
    }
    return $answer;
  }

  public static function generateMainPage ($elements) {
    return self::generateList($elements, 'newsIntro');
  }
  
}