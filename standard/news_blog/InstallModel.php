<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog;


if (!defined('CMS')) exit;


class InstallModel
{
  public function getTemplate() {
    global $site;
    $contentManagementZone = $site->getZoneByModule('standard', 'content_management');
    if ($contentManagementZone) {
      return $contentManagementZone->getLayout();
    }
    
    $zonesModule = new \Modules\developer\zones\Manager();
    
    $templates = $zonesModule->getAvailableTemplates();
    if (count($templates)) {
      return array_pop($templates);
    }
    
    return '';
  }
  
  public function newRowNumber() {
    $sql="
    SELECT max(row_number) as max_row_number FROM `".DB_PREF."zone` WHERE 1";
    
    $rs = mysql_query($sql);
    if ($rs){
      if ($lock = mysql_fetch_assoc($rs)) {
        return $lock['max_row_number'] + 1;
      } else {
        return false;
      }
    } else {
      trigger_error($sql." ".mysql_error());
      return false;
    }
      
          
  }
  
  public function updateAssociatedModule($zoneId) {
    $sql="
    UPDATE `".DB_PREF."zone` SET 
   	`associated_group` = 'standard',
   	`associated_module` = 'news_blog'
   	WHERE `id` = ".(int)$zoneId." 
    ";
    
    $rs = mysql_query($sql);
    if(!$rs){
      trigger_error($sql." ".mysql_error());
    }
          
  }    

}