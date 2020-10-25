<?php

// kyex 22/6/2003

function khat_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $ret = [];

    if (0 != $userid) {
        return $ret;
    }

    error_reporting(E_ALL);

    $moduleHandler = xoops_getHandler('module');

    $khatModule = $moduleHandler->getByDirname('khat');

    $configHandler = xoops_getHandler('config');

    $khatModuleConfig = &$configHandler->getConfigsByCat(0, $khatModule->getVar('mid'));

    require_once XOOPS_ROOT_PATH . '/modules/khat/class/class.' . mb_strtolower($khatModuleConfig['mode']) . '.php';

    error_reporting(E_ALL);

    $khat = new $khatModuleConfig['mode']();

    return $khat->search($queryarray, $andor, $limit, $offset, $userid);
}
