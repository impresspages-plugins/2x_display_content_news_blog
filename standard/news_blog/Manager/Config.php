<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog\Manager;

if (!defined('CMS'))
    exit;

require_once(BASE_DIR . LIBRARY_DIR . 'php/form/standard.php');


class Config {

    public static function getCreateFields() {
        global $parametersMod;
        global $site;

        $fields = array();

        $values = array();
        $languages = $site->getLanguages();
        foreach($languages as $language) {
            $values[] = array($language->getId(), $language->getShortDescription());
        }
        $field = new \Library\Php\Form\FieldSelect();
        $field->name = 'languageId';
        $field->caption = 'Language';
        $field->values = $values;
        $field->note = '';
        $field->required = true;
        $fields[] = $field;
        
        
        $values = array();
        $model = new \Modules\standard\news_blog\Model();
        $newsZones = $model->getNewsZones();
        foreach($newsZones as $newsZone) {
            $values[] = array($newsZone->getName(), $newsZone->getTitle());
        }
        $field = new \Library\Php\Form\FieldSelect();
        $field->caption = 'Zone';
        $field->name = 'zoneName';
        $field->values = $values;
        $field->required = true;
        $fields[] = $field;
        
        
        $field = new \Library\Php\Form\FieldText();
        $field->name = 'buttonTitle';
        $field->caption = 'Title';
        $field->value = '';
        $field->note = '';
        $field->required = true;
        $fields[] = $field;


        $field = new \Library\Php\Form\FieldHidden();
        $field->name = 'rel';
        $field->value = 'zone';
        $field->required = true;
        $fields[] = $field;



        $field = new \Library\Php\Form\FieldHidden();
        $field->name = 'type';
        $field->value = 'zone';
        $field->required = true;
        $fields[] = $field;        
        
        $field = new \Library\Php\Form\FieldHidden();
        $field->name = 'websiteId';
        $field->value = '0';
        $field->required = true;
        $fields[] = $field;
        
        $field = new \Library\Php\Form\FieldHidden();
        $field->name = 'action';
        $field->value = 'createPage';
        $field->required = true;
        $fields[] = $field;
        

        
        
        return $fields;
    }


}