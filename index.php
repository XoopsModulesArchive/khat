<?php

error_reporting(E_ALL);
include 'header.php';
include 'cache/config.php';

if ('khat' == $xoopsConfig['startpage']) {
    $xoopsOption['show_rblock'] = 1;

    require XOOPS_ROOT_PATH . '/header.php';

    make_cblock();

    echo '<br>';
} else {
    $xoopsOption['show_rblock'] = 0;

    require XOOPS_ROOT_PATH . '/header.php';
}

OpenTable();

$op = $_GET['op'] ?? 'main';
$lig = $_GET['lig'] ?? 0;
$lig = (int)$lig;

if ('archive' == $op) {
    require_once __DIR__ . '/class/class.' . mb_strtolower($xoopsModuleConfig['mode']) . '.php';

    $khat = new $xoopsModuleConfig['mode']();

    $khat->makeKhat(
        [
            'ano' => $xoopsModuleConfig['ano'],
'smiley' => $xoopsModuleConfig['smiley'],
'html' => $xoopsModuleConfig['html'],
'xoopscode' => $xoopsModuleConfig['xoopscode'],
'timeout' => $xoopsModuleConfig['timeout'],
'formatdate' => $xoopsModuleConfig['formatdate'],
'nouveauxmsg' => $xoopsModuleConfig['nouveauxmsg'],
        ]
    );

    echo $khat->getAllLines($khat->maxlignes);
}

if (main == $op) {
    echo '' . '<center>' . '<iframe src="' . $xoopsConfig['xoops_url'] . '/modules/khat/frames.php?nblig=' . $chat_length_p . '&nbcar=50" name="khat bloc" width="100%" height="' . $popupHeight . '" frameborder="no" scrolling="no"></iframe>';
}
CloseTable();

include 'footer.php';
