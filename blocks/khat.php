<?php

function b_khat_show($options)
{
    global $xoopsConfig;

    global $modversion;

    global $configHandler, $moduleHandler;

    $content = '';

    $configHandler = xoops_getHandler('config');

    $moduleHandler = xoops_getHandler('module');

    $xoopsModule = $moduleHandler->getByDirname('khat');

    $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    if ('on' == $options[3]) {
        require_once XOOPS_ROOT_PATH . '/modules/khat/class/class.' . mb_strtolower($xoopsModuleConfig['mode']) . '.php';

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

        $content .= $khat->getAllLines($options[1]);

        //NettoyageFichier(XOOPS_ROOT_PATH."/".$chat_file,$max_file_size,$chat_length_p);

        // bouton popup

        $content .= "<input type=\"button\" name=\"Submit\" value=\"Popup\" onClick=\"window.open('"
                    . $xoopsConfig['xoops_url']
                    . "/modules/khat/frames.php?modepop=1','Chat','scrollbars="
                    . $xoopsModuleConfig['popupscrollbar']
                    . ',resizable='
                    . $xoopsModuleConfig['popupresizable']
                    . ',width='
                    . $xoopsModuleConfig['popupwidth']
                    . ',height='
                    . $xoopsModuleConfig['popupheight']
                    . "')\">\n";
    } else {
        // kyex 6/3/2003 : suppression test navigateur. On arrete la compatibilité avec les "anciens" anvigateurs.

        $content .= '<iframe src="' . $xoopsConfig['xoops_url'] . '/modules/khat/frames.php?nblig=' . $options[1] . '&nbcar=' . $options[2] . '" name="khat bloc" width="100%" height="' . $options[0] . '" frameborder="no" scrolling="no"></iframe>';
    }

    $block = [];

    $block['content'] = $content;

    $block['title'] = _KHAT_TITRE_BLOC;

    return $block;
}

function b_khat_edit($options)
{
    $form = _KHAT_IFRAMEH . "&nbsp;<input type='text' name='options[]' value='" . $options[0] . "'><br>";

    $form .= _KHAT_BLOC_NBLIGNES . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "'><br>";

    $form .= _KHAT_BLOC_NBCAR . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "'><br>";

    if ('on' == $options[3]) {
        $chk = "checked='on'";
    } else {
        $chk = '';
    }

    $form .= _KHAT_VISU_SEULE . "&nbsp;<input type='checkbox' name='options[]' $chk><br>";

    return $form;
}
