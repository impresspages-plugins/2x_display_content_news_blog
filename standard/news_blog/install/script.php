<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */


namespace Modules\standard\news_blog;

if (!defined('CMS')) exit;

require_once(BASE_DIR.MODULE_DIR.'developer/zones/manager.php');

class Install{

  public function execute(){

    global $site;
    
    $installModel = new \Modules\standard\news_blog\InstallModel();
    
    $newsZone = $site->getZoneByModule('standard', 'news_blog');
    
    if (!$newsZone) {
      $name = 'news';
      $i = null;
      while($site->getZone($name.$i)) {
        $i++;
      }
      
      
      $sql="
      INSERT INTO `".DB_PREF."zone` SET 
         `row_number` = '".(int)$installModel->newRowNumber()."',
          `name` = '".mysql_real_escape_string($name.$i)."',
         `template` = '".mysql_real_escape_string($installModel->getTemplate())."',
         `translation` = 'News',
         `associated_group` = 'standard',
         `associated_module` = 'content_management'
      ";
      
      $rs = mysql_query($sql);
      $zoneId = mysql_insert_id();
      if($rs){
        $zonesModule = new \Modules\developer\zones\ZonesArea();
        $zonesModule->after_insert($zoneId);
        $installModel->updateAssociatedModule($zoneId);
      } else {
        trigger_error($sql." ".mysql_error());
      }
      
      
    }
    
    


  }
  

  
} 
  
