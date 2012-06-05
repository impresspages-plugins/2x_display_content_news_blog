<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog;



class System {
    public function init () {
        global $site;
        $site->addCss(BASE_URL.PLUGIN_DIR.'standard/news_blog/public/news_blog.css');
        
        if ($site->managementState()) {
            $site->addCss(BASE_URL.PLUGIN_DIR.'standard/news_blog/public/manager.css');
            $site->addCss(BASE_URL.PLUGIN_DIR.'standard/news_blog/public/show_page_break_in_admin.css');
        }
    }
}