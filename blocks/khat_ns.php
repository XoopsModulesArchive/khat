<?php

global $person, $message, $REMOTE_ADDR, $HTTP_REFERER, $xoopsUser;
global $xoopsConfig, $xoopsTheme;
global $modversion;

//include ('../cache/config.php');
//include $xoopsConfig['root_path']."modules/khat/blocks/config.php";
//include $xoopsConfig['root_path']."mainfile.php";

include $xoopsConfig['root_path'] . 'modules/khat/include/fonctions.php';
require_once $xoopsConfig['root_path'] . 'class/module.textsanitizer.php';
if (file_exists($xoopsConfig['root_path'] . 'modules/khat/language/' . $xoopsConfig['language'] . '/main.php')) {
    include $xoopsConfig['root_path'] . 'modules/khat/language/' . $xoopsConfig['language'] . '/main.php';
} else {
    include $xoopsConfig['root_path'] . 'modules/khat/language/english/main.php';
}

NettoyageFichier($xoopsConfig['root_path'] . $chat_file, $max_file_size, $chat_length_p);

$myts = new MyTextSanitizer();

if ($person) {
    $person = htmlspecialchars($person, 0);
} else {
    if ($xoopsUser) {
        $person = $xoopsUser->uname();

        if ('' == $person) {
            $person = $xoopsUser->getClientIP();
        }
    } else {
        $person = "($REMOTE_ADDR)";
    }
}

if ('' != $message) {
    EcrireMsg($message, $person, $xoopsConfig['root_path'] . $chat_file);

    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: no-store, no-cache, must-revalidate');  // HTTP/1.1
    header('Cache-Control: post-check=0, pre-check=0', false);

    header('Pragma: no-cache');                // HTTP/1.0

    header("Location: $HTTP_REFERER");

    echo '<html><head><meta http-equiv="Refresh" content="0; URL=' . $HTTP_REFERER . '">' . '</meta></head><body></body></html>';
}

$content .= AfficherFichier($xoopsConfig['root_path'] . $chat_file, $chat_length, $khatsmiley, $khathtml, $khatbbcode);

$content .= "<script language=\"JavaScript\">\n"
            . "function openPopup(theURL,winName,features) {\n"
            . "window.open(theURL,winName,features);\n"
            . "}\n"
            . "</script>\n"
            . '<form action="'
            . $xoopsConfig['xoops_url']
            . "/modules/khat/blocks/valid.php\" method=\"post\" name=\"coolsus\">\n"
            . "<input type=\"text\" name=\"message\" style=\"$boxStyle\" align=\"absmiddle\" size=\"$boxCols\" value=\"$boxTextDefault\">\n"
            . "<input type=\"hidden\" name=\"person\" size=\"1\" maxlength=\"50\" value=\"$person\" style=\"$boxPseudoStyle\" align=\"absmiddle\">\n"
            . '<input type="submit" value="'
            . _KHAT_BLOC_SUBMIT
            . "\">\n"
            . '<input type="button" name="Submit" value="'
            . _KHAT_POP
            . "\" onClick=\"openPopup('"
            . $xoopsConfig['xoops_url']
            . "/modules/khat/blocks/chat_ns.php','Chat','scrollbars=$popupScrollbar,resizable=$popupResizable,width=$popupWidth,height=$popupHeight')\">\n"
            . '<input type="button" name="emoticones" value="'
            . _KHAT_SMILIES
            . "\" onClick=\"openWithSelfMain('"
            . $xoopsConfig['xoops_url']
            . "/misc.php?action=showpopups&amp;type=smilies&amp;target=message','smilies',300,430)\">\n"
            . "</form>\n";
