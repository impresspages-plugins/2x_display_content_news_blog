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
        global $dispatcher;
        $site->addCss(BASE_URL.PLUGIN_DIR.'standard/news_blog/public/news_blog.css');
        
        if ($site->managementState()) {
            $site->addCss(BASE_URL.PLUGIN_DIR.'standard/news_blog/public/manager.css');
            $site->addCss(BASE_URL.PLUGIN_DIR.'standard/news_blog/public/show_page_break_in_admin.css');
        }
        
        $dispatcher->bind('site.generateBlock', __NAMESPACE__ .'\System::generateContent');
        
    }
    
    
    public static function generateContent (\Ip\Event $event) {
        global $site;

        $blockName = $event->getValue('blockName');
        //we wan to prepopulate only 'main' block and only if we are in address book page
        if (
            $blockName != 'main' ||
            $site->getCurrentZone()->getAssociatedModuleGroup() != 'standard' ||
            $site->getCurrentZone()->getAssociatedModule() != 'news_blog' ||
            count($site->getUrlVars()) > 0
        ) {
            return;
        }
        
               
        //set content value for 'main' block of theme
        $newsBlogWidgetData = array (
            'stream' => $site->getCurrentZone()->getName(),
            'titleLevel' => 2,
            'pagination' => 1,
            'recordsPerPage' => 10
        );
        
        
        $event->setValue('content', \Ip\View::create('view/list.php', array('newsBlogWidgeData' => $newsBlogWidgetData))->render());
        
        //say system that we have processed this request. Otherwise ImpressPages will add widgets functionallity instead of our content
        $event->addProcessed();
        
    }    
    
}
