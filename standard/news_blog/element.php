<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog;


if (!defined('CMS')) exit;

require_once (BASE_DIR.MODULE_DIR.'standard/content_management/element.php');
global $site;
$site->requireTemplate('standard/news_blog/template.php');

/**
 * Website zone element. Typically each element represents one page on zone.<br />
 *
 * @package ImpressPages
 */

class NewsElement {
  var $realElement;

  function __call($name, $arguments ) {
    $argumentsStr = '';
    foreach ($arguments as $key => $value) {
      if ($argumentsStr != '') {
        $argumentsStr .= ', ';
      }
      $argumentsStr .= ' $arguments[\''.addslashes($key).'\'] ';
    }
    eval ('$answer = $this->realElement->'.$name.'('.$argumentsStr.');');
    return $answer;
  }
  

  public function generateContent() {
    global $site;

    if (count($site->urlVars) == 0) {
      return $site->getZone($this->getZoneName())->generateMainPage();
    }

    $widgets = $this->getWidgets();
    $initHtml = '';
    foreach ($widgets as $key => &$widget) {
      eval (' $new_module = new \\Modules\\standard\\content_management\\Widgets\\'.$widget['group_key'].'\\'.$widget['module_key'].'\\Module(); ');

      if(!isset($inited_modules[$widget['module_key']])) {
        if (method_exists ('\\Modules\\standard\\content_management\\Widgets\\'.$widget['group_key'].'\\'.$widget['module_key'].'\\Template', "initHtml")) {
          eval('$initHtml .= \\Modules\\standard\\content_management\\Widgets\\'.$widget['group_key'].'\\'.$widget['module_key'].'\\Template::initHtml();');
        }
      }
      $widget['html'] = $new_module->make_html($widget['module_id']);
    }
    
    $answer = '';
    $answer .= $initHtml;
    $answer .= Template::generatePage($this, $widgets); 
    
    return $answer;
  }
  

  
}




