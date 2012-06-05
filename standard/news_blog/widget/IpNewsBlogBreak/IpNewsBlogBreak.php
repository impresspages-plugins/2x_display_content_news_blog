<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */
namespace Modules\standard\news_blog\widget;

if (!defined('CMS')) exit;

class IpNewsBlogBreak extends \Modules\standard\content_management\Widget{


    public function getTitle() {
        global $parametersMod;
        return $parametersMod->getValue('standard', 'news_blog', 'widget_IpNewsBlogBreak', 'widget_title');
    }
    
    public function previewHtml($instanceId, $data, $layout) {
        global $site;
        if (
                $site->managementState() ||
                isset($_POST['g']) && $_POST['g'] == 'standard' &&
                isset($_POST['m']) && $_POST['m'] == 'content_management' &&
                isset($_POST['a']) && ($_POST['a'] == 'updateWidget') 
        ) {
            return parent::previewHtml($instanceId, $data, $layout);
        } else {
            return '';
        }
    }
    
}