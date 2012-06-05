<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */
namespace Modules\standard\news_blog\widget;

if (!defined('CMS')) exit;

require_once(BASE_DIR.MODULE_DIR.'standard/content_management/widget.php');
require_once(BASE_DIR.LIBRARY_DIR.'php/file/functions.php');
require_once(BASE_DIR.LIBRARY_DIR.'php/image/functions.php');


class IpNewsBlog extends \Modules\standard\content_management\Widget{


    public function getTitle() {
        global $parametersMod;
        return $parametersMod->getValue('standard', 'news_blog', 'widget_IpNewsBlog', 'widget_title');
    }

    
    public function managementHtml($instanceId, $data, $layout) {
        global $parametersMod;
        $answer = '';
        
        $data['streams'] = $this->getAvailableStreams();

        if (!isset($data['recordsPerPage']) || $data['recordsPerPage'] == '') {
            $data['recordsPerPage'] = 10;
        }

        if (!isset($data['showReadMore'])) {
            $data['showReadMore'] = 1;
        }
        
        if (!isset($data['titleLevel']) || $data['titleLevel'] == '') {
            $data['titleLevel'] = 2;
        }
        
         
        $data['levels'] = array(
             array('value' => '1', 'title' => $parametersMod->getValue('standard', 'news_blog', 'admin_translations', 'title_big')),
             array('value' => '2', 'title' => $parametersMod->getValue('standard', 'news_blog', 'admin_translations', 'title_medium')),
             array('value' => '3', 'title' => $parametersMod->getValue('standard', 'news_blog', 'admin_translations', 'title_small'))
         );
        
        return parent::managementHtml($instanceId, $data, $layout);
    }

    public function previewHtml($instanceId, $data, $layout) {
         global $site;
         if (!isset($data['stream'])) {
             //widgets hasn't been properly setup.
             return '';
         }
         
         $zone = $site->getZone($data['stream']);

         if (!$zone) {
             //zone has been removed
             return '';
         }
         
         $language = null;
         $parentElementId = null;
         $startFrom = 0;
         $limit = null;
         $recordsPerPage = 10;
         $includeHidden = false;
         $reverseOrder = true;
         
         if (isset($data['recordsPerPage'])) {
             $recordsPerPage = $data['recordsPerPage'];
         }
         if (!isset($data['titleLevel'])) {
             $data['titleLevel'] = 2;
         };
         
         
         
         if ($data['pagination']) {
             $limit = $recordsPerPage;
             $data['curPage'] = 1;
             if(isset($_GET['nbp'])) { 
                 $data['curPage'] = (int)$_GET['nbp'];
                 $startFrom = ((int)$_GET['nbp'] - 1) * $recordsPerPage;
             }
             $pageCount = ceil(count($zone->getElements($language, $parentElementId, 0, null, $includeHidden, $reverseOrder)) / $recordsPerPage);
             $getVars = $site->getGetVars();
             $urlVars = $site->getUrlVars();
             $languageId = $site->getCurrentLanguage()->getId();
             $zoneName = $site->getCurrentZone()->getName();
             for($i = 1; $i <= $pageCount; $i++) {
                 if ($i == 1) {
                     unset($getVars['nbp']);
                 } else {
                     $getVars['nbp'] = $i;
                 }
                 $url = $site->generateUrl($languageId, $zoneName, $urlVars, $getVars);
                 $data['pages'][$i] = array(
                     'url' => $url,
                     'current' => $data['curPage'] == $i
                 );
             }
             
         }
         
         $elements = $zone->getElements($language, $parentElementId, $startFrom, $limit, $includeHidden, $reverseOrder);
        
         $data['elements'] = $elements;
         $data['zone'] = $zone;
         $data['addReadMoreLink'] = 1;
        
         return parent::previewHtml($instanceId, $data, $layout);
    }

    
    private function getAvailableStreams() {
        $streams = array();
        $model = new \Modules\standard\news_blog\Model();
        $newsZones = $model->getNewsZones();
        foreach ($newsZones as $newsZone) {
            $streams[] = array(
                    'value' => $newsZone->getName(),
                    'title' => $newsZone->getTitle()
            );
        }
        
        return $streams;
    }
}