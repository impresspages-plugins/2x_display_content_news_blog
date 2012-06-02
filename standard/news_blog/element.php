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
  
  
  
  public function getWidgets(){
    $inited_modules = array();
    $sql = "
        select etm.module_key, etm.module_id, g.name as 'group_key' 
        from `".DB_PREF."content_element_to_modules` etm, `".DB_PREF."content_module_group` g, `".DB_PREF."content_module` m 
        where 
        etm.module_key = m.name and g.id = m.group_id and
        etm.element_id = '".$this->getId()."' and etm.visible 
        order by etm.row_number";
    $rs = mysql_query($sql);
    $widgets = array();
    if ($rs) {
      while ($lock = mysql_fetch_assoc($rs)) {
        if ($lock) {
          $widget = $lock; 
          eval (' $new_module = new \\Modules\\standard\\content_management\\Widgets\\'.$lock['group_key'].'\\'.$lock['module_key'].'\\Module(); ');
          $widget['html'] = $new_module->make_html($lock['module_id']);
        }
        $widgets[] = $widget;
      }
    } else {
      $this->set_error("Can't make HTML ".$sql." ".mysql_error());
    }
    
    return $widgets;
  }  
  

  public function getLead() {
    
    $widgets = $this->getWidgets();

    foreach ($widgets as $key => $widget) {
      if ($widget['group_key'] == 'text_photos' && $widget['module_key'] == 'text') {
        $sql = "select text from `".DB_PREF."mc_text_photos_text` where id = '".(int)$widget['module_id']."' ";
        $rs = mysql_query($sql);
        if ($rs){
          if ($lock = mysql_fetch_assoc($rs)){
            return ($lock['text']);
          }
        } else {
          trigger_error("Can't get text to create HTML " . $sql);
        }
        break;
      }

      if ($widget['group_key'] == 'text_photos' && $widget['module_key'] == 'text_photo') {
        $sql = "select text from `".DB_PREF."mc_text_photos_text_photo` where id = '".(int)$widget['module_id']."' ";
        $rs = mysql_query($sql);
        if ($rs){
          if ($lock = mysql_fetch_assoc($rs)){
            return ($lock['text']);
          }
        } else {
          trigger_error("Can't get text to create HTML " . $sql);
        }
        break;
      }
      
    
      if ($widget['group_key'] == 'text_photos' && $widget['module_key'] == 'text_title') {
        $sql = "select text from `".DB_PREF."mc_text_photos_text_title` where id = '".(int)$widget['module_id']."' ";
        $rs = mysql_query($sql);
        if ($rs){
          if ($lock = mysql_fetch_assoc($rs)){
            return ($lock['text']);
          }
        } else {
          trigger_error("Can't get text to create HTML " . $sql);
        }
        break;
      }
       
      if ($widget['group_key'] == 'text_photos' && $widget['module_key'] == 'table') {
        $sql = "select text from `".DB_PREF."mc_text_photos_table` where id = '".(int)$widget['module_id']."' ";
        $rs = mysql_query($sql);
        if ($rs){
          if ($lock = mysql_fetch_assoc($rs)){
            return ($lock['text']);
          }
        } else {
          trigger_error("Can't get text to create HTML " . $sql);
        }
        break;
      }
      
      if ($widget['group_key'] == 'misc' && $widget['module_key'] == 'rich_text') {
        $sql = "select text from `".DB_PREF."mc_misc_rich_text` where id = '".(int)$widget['module_id']."' ";
        $rs = mysql_query($sql);
        if ($rs){
          if ($lock = mysql_fetch_assoc($rs)){
            return ($lock['text']);
          }
        } else {
          trigger_error("Can't get text to create HTML " . $sql);
        }
        break;
      }
      
    }    
    
    return '';
  }
  
}




