<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog\Manager;

if (!defined('BACKEND'))
    exit;


class HtmlOutput {

    public static function header() {
        global $parametersMod;
        return '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head> 
        <link rel="stylesheet" href="'.BASE_URL.BACKEND_DIR.'design/ip_admin.css">
        <link rel="stylesheet" href="'.BASE_URL.MODULE_DIR.'administrator/system/style.css">
        <link href="'.BASE_URL.PLUGIN_DIR.'standard/news_blog/public/manager.css" rel="stylesheet" type="text/css" />  
        <link REL="SHORTCUT ICON" HREF="backend_design/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="' . LIBRARY_DIR . 'js/default.js"></script>
        <script type="text/javascript" src="' . LIBRARY_DIR . 'js/jquery/jquery.js"></script>
        <script type="text/javascript" src="'.BASE_URL.PLUGIN_DIR.'standard/news_blog/public/manager.js"></script>
    </head>   
    <body>

      ';
    }

    public static function footer() {
        return "
    </body>
</html>";
    }
    
    public static function block($content) {
        $answer = '
        <div class="ipAdminWrapper">
            '.$content.'
        </div>
        ';
              
        return $answer;
    }
    
    public static function error($error) {
        return '<div class="note">'.$error.'</div>';
    }
    

}

