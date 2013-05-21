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
  


  
}




