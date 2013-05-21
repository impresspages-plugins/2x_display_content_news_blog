<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog;


require_once (BASE_DIR . INCLUDE_DIR . 'db_system.php');

class Model {

    
    public function getMenuManagementWorkerUrl() {
        global $cms;
        $menuManagementModule = $this->getMenuManagementModule();
        $menuManagementWorkerUrl = $cms->generateWorkerUrl($menuManagementModule['id']);
        return $menuManagementWorkerUrl;
    }
    
    public function getNewsZones(){
        global $site;
        $answer = array();
        foreach($site->getZones() as $zone){
            if ($zone->getAssociatedModuleGroup() == 'standard' && $zone->getAssociatedModule() == 'news_blog') {
                $answer[] = $zone;
            }
        }
        return $answer;
    }


    private function getMenuManagementModule() {
        global $cms;
        $backendDb = new \Backend\Db();
        $moduleGroups = $backendDb->modules(null, $cms->session->userId());
        $menuManagementModule = null;
        foreach ($moduleGroups as $moduleGroup) {
            foreach ($moduleGroup as $module) {
                if ($module['g_name'] == 'standard' && $module['m_name'] == 'menu_management') {
                    $menuManagementModule = $module;
                }
            }
        }
        if (!isset($menuManagementModule)) {
            throw new \Exception("Menu Management module is not available for current user.");
        }
        return $menuManagementModule;
    }
}