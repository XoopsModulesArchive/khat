<?php

require dirname(__DIR__) . '/cache/config.php';
require dirname(__DIR__, 3) . '/mainfile.php';
require dirname(__DIR__) . '/include/fonctions.php';

require_once $xoopsConfig['root_path'] . 'class/module.textsanitizer.php';
if (file_exists($xoopsConfig['root_path'] . 'modules/khat/language/' . $xoopsConfig['language'] . '/main.php')) {
    include $xoopsConfig['root_path'] . 'modules/khat/language/' . $xoopsConfig['language'] . '/main.php';
} else {
    include $xoopsConfig['root_path'] . 'modules/khat/language/english/main.php';
}

$myts = new MyTextSanitizer();

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

EcrireMsg($message, $person, $xoopsConfig['root_path'] . $chat_file);

$person = $person;

echo AfficherEnteteHTML();
include $xoopsConfig['root_path'] . 'include/xoopsjs.php';
echo '<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">';
echo AfficherFichier($xoopsConfig['root_path'] . $chat_file, $chat_length_p, $khatsmiley, $khathtml, $khatbbcode);

//echo "<form action=\"/modules/khat/blocks/index.php\" method=\"get\" name=\"coolsus\">\n"
echo "<form action=\"chat_ns.php\" method=\"post\">\n"
     . "<input type=\"text\" name=\"message\" style=\"boxStyle\" align=\"absmiddle\" value=\"$boxTextDefault\" size=\"50\">\n"
     . "<br>\n"
     . "<input type=\"hidden\" name=\"person\" size=\"10\" maxlength=\"20\" value=\"$person\"  align=\"middle\">\n"
     . "<br>\n"
     . '<input type="submit" name="Submit" value="'
     . _KHAT_POP_SUBMIT
     . "\">\n"
     . '<input type="button" name="Submit1" value="'
     . _KHAT_POP_REFRESH
     . "\" onClick=\"goToURL('parent','chat_ns.php');return document.MM_returnValue\">\n"
     . '<input type="button" name="Submit2" value="'
     . _KHAT_POP_CLOSE
     . "\" onClick=\"callJS('window.close()')\">\n"
     . '<input type="button" name="emoticones" value="'
     . _KHAT_SMILIES
     . "\" onClick=\"openWithSelfMain('"
     . $xoopsConfig['xoops_url']
     . "/misc.php?action=showpopups&amp;type=smilies&amp;target=message','smilies',300,430)\">\n"
     . "</form>\n"
     . "<body>\n"
     . "<html>\n";
