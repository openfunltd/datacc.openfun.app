<?php

class IndexController extends MiniEngine_Controller
{
    public function indexAction()
    {
        $this->view->ccapi_host = getenv('CCAPI_HOST') ?: 'all.cc.govapi.tw';
        $this->view->app_name = getenv('APP_NAME') ?: 'DataCC 地方議會資料瀏覽';
    }

    public function robotsAction()
    {
        header('Content-Type: text/plain');
        echo "#\n";
        return $this->noview();
    }
}
