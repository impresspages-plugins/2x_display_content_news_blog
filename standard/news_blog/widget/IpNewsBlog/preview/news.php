<?php
//loop all pages
foreach ($elements as $element) {
    $publishedRevision = \Ip\Revision::getPublishedRevision($zone->getName(), $element->getId());
    $widgetRecords = \Modules\standard\content_management\Model::getBlockWidgetRecords('main', $publishedRevision['revisionId']);
    //loop all widgets
    foreach ($widgetRecords as $key => $widgetRecord) {
        if ($key >= 2) {
            break; //print only first two widgets
        }
        echo \Modules\standard\content_management\Model::generateWidgetPreview($widgetRecord['instanceId'], false); 
    }
}
?>