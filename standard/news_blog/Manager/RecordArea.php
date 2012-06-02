<?php

namespace Modules\standard\news_blog\Manager;

if (!defined('BACKEND')) exit;  //this file can't be accessed directly

require_once(__DIR__.'/../std_mod/std_mod.php'); //include standard module to manage data records


class RecordArea extends \Modules\standard\news_blog\Area{  //extending standard data management module area

    function __construct(){
        global $parametersMod;  //global object to get parameters
        global $site;

        $options = array(
                        'dbTable' => 'content_element',
                        'title' => 'Record',
                        'dbPrimaryKey' => 'id',
                        'searchable' => false,
                        'orderBy' => 'row_number',
                        'allowUpdate' => false,
                        'allowDelete' => true,
                        'allowInsert' => true,
                        'dbReference' => '',
                        'whereCondition' => ' 1 '
                    );
        if (isset($_GET['road'][1])) {
            $rootElementId = $this->getRootElementId($_GET['road'][1], $_GET['road'][0]);
            $options['whereCondition'] = ' parent = '.(int)$rootElementId.' ';
        }
        
        parent::__construct(
                $options
        );

        $element = new \Modules\standard\news_blog\ElementText(
                array(
                        'title' => $parametersMod->getValue('developer', 'zones','admin_translations','name'),
                        'useInBreadcrumb' => true,
                        'showOnList' => true,
                        'dbField' => 'button_title',
                )
        );
        $this->addElement($element);
        
        $element = new \Modules\standard\news_blog\ElementText(
                array(
                        'title' => '',
                        'useInBreadcrumb' => false,
                        'showOnList' => false,
                        'defaultValue' => isset($_GET['road'][0]) ? $_GET['road'][0] : '',
                        'hidden' => true,
                        'visibleOnInsert' => false,
                        'dbField' => 'languageId'
                )
        );
        $this->addElement($element);
        
        
        $element = new \Modules\standard\news_blog\ElementText(
                array(
                        'title' => '',
                        'useInBreadcrumb' => false,
                        'showOnList' => false,
                        'defaultValue' => isset($_GET['road'][1]) ? $_GET['road'][1] : '',
                        'hidden' => true,
                        'visibleOnInsert' => false,
                        'dbField' => 'zoneName'
                )
        );
        $this->addElement($element);
        
        
        $model = new \Modules\standard\news_blog\Model();
        $managementUrl = $model->getMenuManagementWorkerUrl();
        $element = new \Modules\standard\news_blog\ElementText(
                array(
                        'title' => '',
                        'useInBreadcrumb' => false,
                        'showOnList' => false,
                        'defaultValue' => $managementUrl,
                        'hidden' => true,
                        'visibleOnInsert' => false,
                        'dbField' => 'managementUrl'
                )
        );
        $this->addElement($element);
        
        
        $element = new ElementManagementLink(
                array(
                        'title' => '',
                        'useInBreadcrumb' => true,
                        'showOnList' => true,
                        'dbField' => 'id',
                )
        );
        $this->addElement($element);

    }
    
    
    private function getRootElementId($zoneName, $language){
        $sql = "select mte.element_id from
    `".DB_PREF."zone` m, 
    `".DB_PREF."zone_to_content` mte 
    where mte.zone_id = m.id and mte.language_id = '".mysql_real_escape_string($language)."'
    and m.name = '".mysql_real_escape_string($zoneName)."'
    ";
        $rs = mysql_query($sql);
        if($rs){
            $lock = mysql_fetch_assoc($rs);
            return $lock['element_id'];
        }else
        trigger_error($sql." ".mysql_error());
    }       


}