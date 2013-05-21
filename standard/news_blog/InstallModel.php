<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog;


if (!defined('CMS')) exit;

require_once(BASE_DIR.MODULE_DIR.'developer/zones/manager.php');


class InstallModel
{

    public function addStream($streamTitle) {
        global $site;
        $name = preg_replace("/[^a-zA-Z0-9\s]/", "", $streamTitle);
        $name = strtolower($name);
        if ($name == '') {
            $name = 'news';
        }
        
        $i = null;
        while($site->getZone($name.$i)) {
            $i++;
        }
        
        $name = $name.$i;

        $sql="
        INSERT INTO `".DB_PREF."zone` SET
        `row_number` = '".(int)$this->newRowNumber()."',
        `name` = '".mysql_real_escape_string($name)."',
        `template` = '".mysql_real_escape_string($this->getTemplate())."',
        `translation` = '".mysql_real_escape_string($streamTitle)."',
        `associated_group` = 'standard',
        `associated_module` = 'content_management'
        ";

        $rs = mysql_query($sql);
        $zoneId = mysql_insert_id();
        if($rs){
            $zonesModule = new \Modules\developer\zones\ZonesArea();
            $zonesModule->after_insert($zoneId);
            $this->updateAssociatedModule($zoneId);
            $this->removeFromMenuManagement($name);
        } else {
            trigger_error($sql." ".mysql_error());
        }
    }

    
    public function removeStream($name) {
        global $site;
        $zone = $site->getZone($name);
        $zoneId = $zone->getId();
        $zonesModule = new \Modules\developer\zones\ZonesArea();
        $zonesModule->before_delete($zoneId);
        $sql="DELETE from `".DB_PREF."zone` WHERE id = ".(int)$zoneId."";

        $rs = mysql_query($sql);
    
    }

    public function getTemplate() {
        global $site;
        $contentManagementZone = $site->getZoneByModule('standard', 'content_management');
        if ($contentManagementZone) {
            return $contentManagementZone->getLayout();
        }

        require_once(BASE_DIR.MODULE_DIR.'developer/zones/db.php');
        $db = new \Modules\developer\zones\Db();

        return $db->getDefaultTemplate();
        if (count($templates)) {
            return array_pop($templates);
        }

        return '';
    }

    public function newRowNumber() {
        $sql="
        SELECT max(row_number) as max_row_number FROM `".DB_PREF."zone` WHERE 1";

        $rs = mysql_query($sql);
        if ($rs){
            if ($lock = mysql_fetch_assoc($rs)) {
                return $lock['max_row_number'] + 1;
            } else {
                return false;
            }
        } else {
            trigger_error($sql." ".mysql_error());
            return false;
        }


    }

    public function updateAssociatedModule($zoneId) {
        $sql="
        UPDATE `".DB_PREF."zone` SET
        `associated_group` = 'standard',
        `associated_module` = 'news_blog'
        WHERE `id` = ".(int)$zoneId."
        ";

        $rs = mysql_query($sql);
        if(!$rs){
            trigger_error($sql." ".mysql_error());
        }

    }
    
    
    public function removeFromMenuManagement($name) {
        global $parametersMod;
        $zonesModule = new \Modules\developer\zones\ZonesArea();
        $associatedZonesStr = $zonesModule->removeFromAssociatedZones($parametersMod->getValue('standard', 'menu_management', 'options', 'associated_zones'), $name);
        $parametersMod->setValue('standard', 'menu_management', 'options', 'associated_zones', $associatedZonesStr);
    }
    
    

}