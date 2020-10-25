<?php

require dirname(__DIR__, 3) . '/mainfile.php';
require dirname(__DIR__) . '/cache/config.php';
require dirname(__DIR__) . '/include/fonctions.php';

if (file_exists(XOOPS_ROOT_PATH . '/modules/khat/language/' . $xoopsConfig['language'] . '/main.php')) {
    require XOOPS_ROOT_PATH . '/modules/khat/language/' . $xoopsConfig['language'] . '/main.php';
} else {
    require XOOPS_ROOT_PATH . '/modules/khat/language/english/main.php';
}

echo AfficherEnteteHTML();

echo '<body class="bg1" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">';
require XOOPS_ROOT_PATH . '/include/xoopsjs.php';

// traitement message (on fait de la place dans le fichier si necessaire
NettoyageFichier($xoopsConfig['root_path'] . $chat_file, $max_file_size, $chat_length_p);
$msg = $xoopsMyts->htmlSpecialChars($message, 0);
$msg = $xoopsMyts->makeClickable($msg);

if ($person) {
    $person = $xoopsMyts->htmlSpecialChars($person, 0);
} else {
    if ($xoopsUser) {
        $person = $xoopsUser->uname();

        if ('' == $person) {
            $person = khatAno($khatAno, $xoopsUser);
        }
    } else {
        $person = khatAno($khatAno, null);
    }
}

// on sauve le msg
EcrireMsg($msg, $person, $xoopsConfig['root_path'] . $chat_file);

if (!isset($nbcar) || $nbcar <= 0) {
    $nbcar = $popupBoxCols;
}
$option_pop = "?nblig=$nblig";  //options[1]
$option_pop .= "&nbcar=$nbcar"; //options[2]
if (1 == $modepop) {
    $option_pop .= '&modepop=1';
}
$option_pop .= '&refresh=' . random_int(0, 10000);
echo "<script language=\"JavaScript\">\n" . "function optionSon() {\n" . 'var sononoff;' . "if (document.coolsus.son.value == \"On\") {sononoff = \"Off\";} else {sononoff = \"On\";}\n" // ."alert(document.coolsus.son.value);alert(sononoff);"
     . "document.coolsus.son.value = sononoff;\n" . "document.coolsus.action='post.php$option_pop'+'&son='+sononoff;" . "return('chataction.php$option_pop'+'&son='+sononoff);" . "}\n";
echo " function check() {setTimeout('coolsus.message.value=\'\'',50); return true;}";
if (!isset($son)) {
    $son = 'On';
}
$option_pop .= "&son=$son";
//echo "alert(parent.mainFrame.chataction.location.href);\n";

echo '' . "parent.mainFrame.chataction.location.href = 'chataction.php$option_pop';\n" . '</script>' . "<form action=\"post.php$option_pop\" onsubmit=\"return check();\"  method=\"post\" name=\"coolsus\">\n" // kyex 01/2002 type person => hidden au lieu de text
     . "<input type=\"hidden\" name=\"person\" size=\"6\" maxlength=\"50\" value=\"$person\" align=\"absmiddle\">\n";
if (1 == $modepop) {
    echo ''
         . "<input type=\"text\" name=\"message\" style=\"boxStyle\" align=\"absmiddle\" value=\"$boxTextDefault\" size=\"$popupBoxCols\">\n"
         . "<br>\n"
         . '<input type="submit" value="'
         . _KHAT_POP_SUBMIT
         . "\">\n"
         . '<input type="button" name="refresh" value="'
         . _KHAT_POP_REFRESH
         . "\" onClick=\"parent.mainFrame.location.href = 'chat.php$option_pop';return document.MM_returnValue\">\n"
         . '<input type="button" name="close" value="'
         . _KHAT_POP_CLOSE
         . "\" onClick=\"callJS('top.close()')\">\n";
} else {
    echo ''
         . "<input type=\"text\" name=\"message\" style=\"boxStyle\" align=\"absmiddle\" value=\"\" size=\"$nbcar\">\n"
         . '<input type="submit" value="'
         . _KHAT_BLOC_SUBMIT
         . '">'
         . '<input type="button" name="Submit" value="'
         . _KHAT_POP
         . "\" onClick=\"openPopup('frames.php?person=$person&modepop=1','Chat','scrollbars=$popupScrollbar,resizable=$popupResizable,width=$popupWidth,height=$popupHeight')\">\n";
}

echo '<input type="button" name="emoticones" value="'
     . _KHAT_SMILIES
     . "\" onClick=\"openWithSelfMain('"
     . $xoopsConfig['xoops_url']
     . "/misc.php?action=showpopups&amp;type=smilies&amp;target=message','smilies',300,430)\">\n"
     . "<input type=\"button\" ID=\"son\" name=\"son\" value=\"$son\" onClick=\"parent.mainFrame.chataction.location.href = optionSon();return document.MM_returnValue\" >"
     . "</form>\n";
echo '</body>' . '</html>';
