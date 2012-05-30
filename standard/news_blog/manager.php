<?php

/**
 * @package	ImpressPages
 * @copyright	Copyright (C) 2011 ImpressPages LTD.
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


        
        
        
        $answer = '';

        $answer .= Manager\HtmlOutput::header();

        if (isset($_SESSION['modules']['multisite']['note'])) {
            $answer .= Manager\HtmlOutput::error(htmlspecialchars($_SESSION['modules']['multisite']['note']));
            unset($_SESSION['modules']['multisite']['note']);
        }
        
        $form = new \Library\Php\Form\Standard(Manager\Config::getCreateFields());
        $answer .= '<div class="ipAdminWrapper"><h1 class="ipaHeadline">News / Blog</h1></div>';
        
        $tmpHtml = $form->generateForm('Create', $cms->generateWorkerUrl($cms->curModId));
        $answer .= Manager\HtmlOutput::block($tmpHtml);

        $answer .= Manager\HtmlOutput::footer();

        return $answer;
    }


}

