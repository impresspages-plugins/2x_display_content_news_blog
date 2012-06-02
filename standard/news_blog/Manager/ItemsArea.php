<?php

namespace Modules\standard\news_blog\Manager;

if (!defined('BACKEND')) exit;  //this file can't be accessed directly

require_once(__DIR__.'/../std_mod/std_mod.php'); //include standard module to manage data records

class ItemsArea extends \Modules\standard\news_blog\Area{  //extending standard data management module area

    function __construct(){
        global $parametersMod;  //global object to get parameters

        parent::__construct(
                array(
                        'dbTable' => 'language',
                        'title' => 'News / Blog',
                        'dbPrimaryKey' => 'id',
                        'searchable' => false,
                        'orderBy' => 'row_number',
                        'allowUpdate' => false,
                        'allowDelete' => false,
                        'allowInsert' => false
                )
        );

        $element = new \Modules\standard\news_blog\ElementText(
                array(
                        'title' => $parametersMod->getValue('standard','languages','admin_translations','long'),
                        'useInBreadcrumb' => true,
                        'showOnList' => true,
                        'dbField' => 'd_long',
                )
        );
        $this->addElement($element);

        $this->addArea(new ZoneArea());
    }
    

}


