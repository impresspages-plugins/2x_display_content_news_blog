<?php
//loop all pages
foreach ($elements as $element) {
    $publishedRevision = \Ip\Revision::getPublishedRevision($zone->getName(), $element->getId());
    $widgetRecords = \Modules\standard\content_management\Model::getBlockWidgetRecords('main', $publishedRevision['revisionId']);
    //loop all widgets
    foreach ($widgetRecords as $key => $widgetRecord) {
        $widgetHtml = \Modules\standard\content_management\Model::generateWidgetPreview($widgetRecord['instanceId'], false);
         
        //put link to whole article on first title widget
        if ($key == 0) {
            $count = 0;
            $widgetHtml = preg_replace('/<h[1-6](.*?)<\/h[1-6]>/', '<h'.$titleLevel.'$1</h'.$titleLevel.'>', $widgetHtml, 1, $count);
            if ($count == 0) {
                echo $this->renderWidget('IpTitle', array('title' => $element->getPageTitle()), 'level'.$titleLevel);
            }
        }
        echo $widgetHtml;
    }
    
    //if there is no widgets on the page, put at least the title
    if (count($widgetRecords) == 0) {
        echo $this->renderWidget('IpTitle', array('title' => $element->getPageTitle()), 'level'.$titleLevel);
    }
    
    if ($addReadMoreLink) {
        echo $this->renderWidget('IpText', array('text' => '<p><a class="ipmNewsBlogMore" href="'.$element->getLink().'">'.$this->escPar('standard/news_blog/translations/read_more').'</a></p>'));
    }
}
?>