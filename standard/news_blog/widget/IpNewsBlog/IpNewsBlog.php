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
        $answer = '';
        
        $data['streams'] = $this->getAvailableStreams();
        
        if (!isset($data['limit']) || $data['limit'] == '') {
            $data['limit'] = 10;
        }
        
        return parent::managementHtml($instanceId, $data, $layout);
    }

    public function previewHtml($instanceId, $data, $layout) {
        
        //var_dump($data);
//         if (isset($data['stream']))
//         $zone = 
        
//         $data['records'] = 
        
//         $answer = '';
//         try {
//             $answer = \Ip\View::create(BASE_DIR.PLUGIN_DIR.$this->moduleGroup.'/'.$this->moduleName.'/'.Model::WIDGET_DIR.'/'.$this->name.'/'.self::PREVIEW_DIR.'/'.$layout.'.php', $data)->render();
//         } catch (\Ip\CoreException $e){
//             global $site;
            
//             if ($site->managementState()) {
//                 $tmpData = array(
//                     'widgetName' => $this->name,
//                     'layout' => $layout
//                 );
//                 $answer = \Ip\View::create('view/unknown_widget_layout.php', $tmpData)->render();
//             } else {
//                 $answer = '';
//             }
//         }
//         return $answer;
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