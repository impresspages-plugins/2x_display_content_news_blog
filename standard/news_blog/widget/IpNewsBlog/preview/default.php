<?php
//print pagination
if ($pagination && is_array($pages)) {
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
    $widgetRecords = \Modules\standard\content_management\Model::getBlockWidgetRecords('main', $publishedRevision['revisionId']);
    
    
    //loop all widgets
    foreach ($widgetRecords as $key => $widgetRecord) {
        $widgetHtml = \Modules\standard\content_management\Model::generateWidgetPreview($widgetRecord['instanceId'], false);
         
        //put link to article on first title widget. If there is no title widget, add it.
        if ($key == 0) {
            $count = 0;
            $widgetHtml = preg_replace('/<h[1-6](.*?)>(.*?)<\/h[1-6]>/', '<h'.$titleLevel.'$1><a href="'.$element->getLink().'">$2</a></h'.$titleLevel.'>', $widgetHtml, 1, $count);
            //if no h1 tag found, automatically add IpTitle widget.
            if ($count == 0) {
                $autoTitle = $this->renderWidget('IpTitle', array('title' => $element->getPageTitle()), 'level'.$titleLevel); 
                $autoTitle = preg_replace('/<h[1-6](.*?)>(.*?)<\/h[1-6]>/', '<h'.$titleLevel.'$1><a href="'.$element->getLink().'">$2</a></h'.$titleLevel.'>', $autoTitle, 1, $count);
                echo $autoTitle;
            }
        }
        echo $widgetHtml;
    }
    
    //if there is no widgets on the page, put at least the title
    if (count($widgetRecords) == 0) {
        $autoTitle = $this->renderWidget('IpTitle', array('title' => $element->getPageTitle()), 'level'.$titleLevel); 
        $autoTitle = preg_replace('/<h[1-6](.*?)>(.*?)<\/h[1-6]>/', '<h'.$titleLevel.'$1><a href="'.$element->getLink().'">$2</a></h'.$titleLevel.'>', $autoTitle, 1, $count);
        echo $autoTitle;
    }
    
    if ($addReadMoreLink) {
        echo $this->renderWidget('IpText', array('text' => '<p><a class="ipmNewsBlogMore" href="'.$element->getLink().'">'.$this->escPar('standard/news_blog/translations/read_more').'</a></p>'));
    }
}
//--


//print pagination
if ($pagination && is_array($pages)) {
    echo $this->renderWidget('IpText', array('text' => $pagesHtml));
}
//--
?>