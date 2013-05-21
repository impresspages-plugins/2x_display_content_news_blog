<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace Modules\standard\news_blog;

if (!defined('BACKEND'))
    exit;



class BackendWorker {
    
    
    public function work() {
        if (!isset($_REQUEST['action']) ) {
            return;
        }

        switch ($_REQUEST['action']) {
            case 'createStream' :
                if (!isset($_POST['title'])) {
                    $answer = array(
                            'status' => 'error',
                            'error' => 'Title parameter missing'
                    );
                    $this->_printJson($answer);
                    break;
                }
                
                $title = $_POST['title'];
                
                $installModel = new InstallModel();
                $installModel->addStream($title);
                $answer = array(
                        'status' => 'success',
                );
                $this->_printJson($answer);
                break;
            
        }
        
    }
    
    /*
     * Print Json answer
     */
    private function _printJson ($data) {
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Pragma: no-cache");
        echo json_encode($data);

    }    
    
    
}