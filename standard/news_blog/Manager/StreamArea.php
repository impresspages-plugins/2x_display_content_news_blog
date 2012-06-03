<?php

namespace Modules\standard\news_blog\Manager;

if (!defined('BACKEND')) exit;  //this file can't be accessed directly

require_once(__DIR__.'/../std_mod/std_mod.php'); //include standard module to manage data records


class StreamArea extends \Modules\standard\news_blog\Area{  //extending standard data management module area

    function __construct(){
        global $parametersMod;  //global object to get parameters

        parent::__construct(
                array(
                        'dbTable' => 'zone',
                        'title' => 'Stream',
                        'dbPrimaryKey' => 'name',
                        'searchable' => false,
                        'orderBy' => 'row_number',
                        'allowUpdate' => false,
                        'allowDelete' => true,
                        'allowInsert' => true,
                        'dbReference' => '',
                        'whereCondition' => ' `associated_module` = \'news_blog\' '
                )
        );

        $element = new \Modules\standard\news_blog\ElementText(
                array(
                        'title' => $parametersMod->getValue('developer', 'zones','admin_translations','name'),
                        'useInBreadcrumb' => true,
                        'showOnList' => true,
                        'dbField' => 'translation',
                )
        );
        $this->addElement($element);

        $this->addArea(new RecordArea());
        
    }

 

}