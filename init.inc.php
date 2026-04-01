<?php

define('MINI_ENGINE_LIBRARY', true);
define('MINI_ENGINE_ROOT', __DIR__);
include(__DIR__ . '/mini-engine.php');
if (file_exists(__DIR__ . '/config.inc.php')) {
    include(__DIR__ . '/config.inc.php');
}
set_include_path(
    __DIR__ . '/libraries'
    . PATH_SEPARATOR . __DIR__ . '/models'
);

// 從子網域解析 CCAPI_HOST
$_datacc_host = $_SERVER['HTTP_HOST'] ?? '';
$_datacc_postfix = getenv('DATACC_DOMAIN_POSTFIX') ?: '.datacc.openfun.app';
$_ccapi_postfix = getenv('CCAPI_DOMAIN_POSTFIX') ?: '.cc.govapi.tw';
$_bare_domain = ltrim($_datacc_postfix, '.');

if ($_datacc_host === $_bare_domain) {
    // 轉址：裸網域 → all 子網域
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: https://all' . $_datacc_postfix . ($_SERVER['REQUEST_URI'] ?? '/'));
    exit;
} elseif (!getenv('CCAPI_HOST') && substr($_datacc_host, -strlen($_datacc_postfix)) === $_datacc_postfix) {
    $_subdomain = substr($_datacc_host, 0, -strlen($_datacc_postfix));
    putenv('CCAPI_HOST=' . $_subdomain . $_ccapi_postfix);
}

if (!getenv('CCAPI_HOST')) {
    putenv('CCAPI_HOST=all.cc.govapi.tw');
}

MiniEngine::initEnv();
