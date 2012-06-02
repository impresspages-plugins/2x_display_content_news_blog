<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog;

if (!defined('BACKEND'))
    exit;


require_once (BASE_DIR . INCLUDE_DIR . 'db_system.php');

class Manager {

    private $formFields;
    private $model;

    function __construct() {
        global $parametersMod;
        //$this->model = new Model();

    }

    function manage() {
        global $cms;
        global $parametersMod;
        global $log;

        $model = new Model();
        
        $answer = '';

        $itemsArea = new Manager\ItemsArea();  //this class is in file items_area.php
        $this->standardModule = new \Modules\standard\news_blog\StandardModule($itemsArea); //create management tool
        $answer .= $this->standardModule->manage();  //return management tools
        
        return $answer;
    }


}

