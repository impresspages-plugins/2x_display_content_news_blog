<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */


namespace Modules\standard\news_blog;

if (!defined('CMS')) exit;


class Install{

  public function execute(){

    global $site;
    
    $installModel = new \Modules\standard\news_blog\InstallModel();
    $newsZone = $site->getZoneByModule('standard', 'news_blog');
    
    if (!$newsZone) {
      $installModel->addStream('News');
    }
  }
} 
  
