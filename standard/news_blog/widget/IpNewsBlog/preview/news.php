<?php
//print links to pages
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

//loop all news / blog records
foreach ($elements as $element) {
    $publishedRevision = \Ip\Revision::getPublishedRevision($zone->getName(), $element->getId());
    $widgetRecords = \Modules\standard\content_management\Model::getBlockWidgetRecords('main', $publishedRevision['revisionId']);
    //loop all widgets
    $printedWidgets = 0;
    foreach ($widgetRecords as $key => $widgetRecord) {
        if ($printedWidgets >= 2) {
            break; //we print only two widgets per article (first one is title, next one is first paragraph of content)
        }
        $widgetHtml = \Modules\standard\content_management\Model::generateWidgetPreview($widgetRecord['instanceId'], false);
         
        //put link to whole article on first title widget
        if ($key == 0) {
            $count = 0;
            $widgetHtml = preg_replace('/<h[1-6](.*?)>(.*?)<\/h[1-6]>/', '<h'.$titleLevel.'$1><a href="'.$element->getLink().'">$2</a></h'.$titleLevel.'>', $widgetHtml, 1, $count);
            if ($count == 0) {
                $printedWidgets++;
                $autoTitle = $this->renderWidget('IpTitle', array('title' => $element->getPageTitle()), 'level'.$titleLevel); 
                $autoTitle = preg_replace('/<h[1-6](.*?)>(.*?)<\/h[1-6]>/', '<h'.$titleLevel.'$1><a href="'.$element->getLink().'">$2</a></h'.$titleLevel.'>', $autoTitle, 1, $count);
                echo $autoTitle;
            }
        }
        $printedWidgets++;
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


//print links to pages
if ($pagination && is_array($pages)) {
    echo $this->renderWidget('IpText', array('text' => $pagesHtml));
}
?>