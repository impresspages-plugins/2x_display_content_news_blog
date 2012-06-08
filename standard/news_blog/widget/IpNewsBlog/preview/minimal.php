<?php
//print pagination
if ($pagination && count($pages) > 0) {
    $pagesHtml = '';
    foreach($pages as $key => $page) {
        if ($page['current']) {
            $class = 'ipmNewsBlogPage ipmNewsBlogPageCurrent';
        } else {
            $class = 'ipmNewsBlogPage';
        }
        $pagesHtml .= '<a class="'.$class.'" href="'.$page['url'].'">'.$key.'</a> ';
    }
    echo $this->renderWidget('IpText', array('text' => $pagesHtml));
}
//--

//loop all news / blog records
foreach ($elements as $element) {
    $publishedRevision = \Ip\Revision::getPublishedRevision($zone->getName(), $element->getId());
    
    
    $description = $this->esc($element->getDescription());
    if ($description == '') {
        //if SEO description is empty, take first paragraph from widgets
        $widgetRecords = \Modules\standard\content_management\Model::getBlockWidgetRecords('main', $publishedRevision['revisionId']);
        foreach ($widgetRecords as $widgetRecord) {
            $widgetHtml = \Modules\standard\content_management\Model::generateWidgetPreview($widgetRecord['instanceId'], false);
            preg_match("/<p>(.*)<\/p>/i", $widgetHtml, $matches);
            if (count($matches) == 2) {
                $description = $matches[1];
                break;
            }
        }
    }
    
    $articleHtml = '<a href="'.$element->getLink().'">'.$this->esc($element->getPageTitle()).'</a><p>'.$description.'</p>';
    
    echo $this->renderWidget('IpText', array('text' => $articleHtml));
}
//--


//print pagination
if ($pagination && count($pages) > 0) {
    echo $this->renderWidget('IpText', array('text' => $pagesHtml));
}
//--
?>