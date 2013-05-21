<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog\Manager;

if (!defined('BACKEND'))
    exit;


require_once (BASE_DIR . INCLUDE_DIR . 'db_system.php');

class ElementManagementLink extends \Modules\standard\news_blog\Element{

    var $regExpression;
    var $regExpressionError;
    var $maxLength;

    function __construct($variables){
        if(!isset($variables['order'])){
            $variables['order'] = true;
        }

        parent::__construct($variables);

        if(!isset($variables['dbField']) || $variables['dbField'] == ''){
            $backtrace = debug_backtrace();
            if(isset($backtrace[0]['file']) && $backtrace[0]['line'])
            trigger_error('ElementText dbField parameter not set. (Error source: '.$backtrace[0]['file'].' line: '.$backtrace[0]['line'].' ) ');
            else
            trigger_error('ElementText dbField parameter not set.');
            exit;
        }

        foreach ($variables as $name => $value) {
            switch ($name){
                case 'dbField':
                    $this->dbField = $value;
                    break;

            }
        }

    }

    function printFieldNew($prefix, $parentId = null, $area = null){
        return '';
    }



    function printFieldUpdate($prefix, $record, $area){
        return '';
    }

    function getParameters($action, $prefix, $area){
        return array();
    }


    function previewValue($record, $area){
        global $site;
        global $parametersMod;
        
        $zoneName = $_GET['road'][1];
        $zone = $site->getZone($zoneName);

        $answer = '<a target="_blank" href="'.$zone->getElement($record[$this->dbField])->getLink().'?cms_action=manage">'.htmlspecialchars($parametersMod->getValue('standard', 'menu_management', 'admin_translations', 'edit')).'</a>';
        return $answer;
    }

    function checkField($key, $action, $area) {
        return true;
    }




    function printSearchField($level, $key, $area){
        return '';
    }

}