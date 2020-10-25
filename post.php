<?php

require dirname(__DIR__, 2) . '/mainfile.php';
//include ('cache/config.php');
error_reporting(E_ALL);
//include ('include/fonctions.php'); // on garde juste pour afficherentetehtml et khatano
require_once __DIR__ . '/class/class.' . mb_strtolower($xoopsModuleConfig['mode']) . '.php';

// mode objet 21/05/2003 pour v1.1
$khat = new $xoopsModuleConfig['mode']();

xoops_header(false);

// kyex 9/6/2003 : on prend le reste de fonctions.php ici:
echo "<script type='text/javascript'><!-- \n"
     . "function openPopup(theURL,winName,features) {\n"
     . "window.open(theURL,winName,features);\n"
     . "}\n"
     . 'function callJS(jsStr) {'
     . 'return eval(jsStr)'
     . "}\n"
     . "function goToURL() {\n"
     . "var i, args=goToURL.arguments; document.MM_returnValue = false;\n"
     . "for (i=0; i<(args.length-1); i+=2) eval(args[i]+\".location='\"+args[i+1]+\"'\");\n"
     . "}\n"
     . '--></script>';
echo '</head>';

$nblig = $_GET['nblig'] ?? 0;
$nblig = (int)$nblig;
$nbcar = $_GET['nbcar'] ?? 0;
$nbcar = (int)$nbcar;
$modepop = $_GET['modepop'] ?? 0;
$son = $_GET['son'] ?? 'On';

$message = $_POST['message'] ?? '';
$person = $_POST['person'] ?? '';

/*
echo "<script type='text/javascript'><!--\n";
require XOOPS_ROOT_PATH."/include/xoopsjs.php";
echo "\n//--></script>";
*/

echo '<body class="bg1" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">';

// traitement message (on fait de la place dans le fichier si necessaire
//NettoyageFichier($xoopsConfig['root_path'].$chat_file,$max_file_size,$chat_length_p);
//// -> a remettre en place via l'objet $khat

$myts = MyTextSanitizer::getInstance();

// on sauve le msg
// kyex 21/05/2003 pour v1.1
$khat->setMessage($message);
$khat->store();

if (!isset($nbcar) || $nbcar <= 0) {
    $nbcar = $xoopsModuleConfig['popupboxcols'];
}
$option_pop = "?nblig=$nblig";  //options[1]
$option_pop .= "&nbcar=$nbcar"; //options[2]
if (1 == $modepop) {
    $option_pop .= '&modepop=1';
}
$option_pop .= '&refresh=' . random_int(0, 10000);
echo "<script language=\"JavaScript\"><!--\n" . "function optionSon() {\n" . "var sononoff;\n" . "if (document.khatformpost.son.value == \"On\") {sononoff = \"Off\";} else {sononoff = \"On\";}\n" // ."alert(document.khatformpost.son.value);alert(sononoff);"
     . "document.khatformpost.son.value = sononoff;\n" . "document.khatformpost.action='post.php$option_pop'+'&son='+sononoff;\n" . "return('chataction.php$option_pop'+'&son='+sononoff);\n" . "}\n";
echo " function check() {setTimeout('document.khatformpost.message.value=\'\'',50); return true;}\n";
//if(!isset($son))  $son="On";  // fait au debut du fichier!
$option_pop .= "&son=$son";

echo "//--></script>\n";
echo "<script language=\"JavaScript\"><!--\n";

echo '' . "if (parent.mainFrame.chataction) {\n"
     //."mainFr = xoopsGetElementById('mainFrame');\n"
     //."alert(mainFr);\n"
     //."alert(parent.mainFrame);\n"
     // ."mainFr.chataction.location.href = 'chataction.php$option_pop';\n"
     . "parent.mainFrame.chataction.location.href = 'chataction.php$option_pop';\n" . "}\n" . "//--></script>\n" . "<form action=\"post.php$option_pop\" onsubmit=\"return check();\"  method=\"post\" name=\"khatformpost\" id=\"khatformpost\" >\n" // kyex 01/2002 type person => hidden au lieu de text
     . "<input type=\"hidden\" name=\"person\" size=\"6\" maxlength=\"50\" value=\"$person\" align=\"absmiddle\">\n";
if (1 == $modepop) {
    echo ''
         . '<input type="text" id="message" name="message" style="boxStyle" align="absmiddle" value="" size="'
         . $xoopsModuleConfig['popupboxcols']
         . "\">\n"
         . "<br>\n"
         . '<input type="submit" value="'
         . _KHAT_POP_SUBMIT
         . "\">\n"
         // ."<input type=\"button\" name=\"refresh\" value=\""._KHAT_POP_REFRESH."\" onClick=\"parent.mainFrame.location.href = 'chat.php$option_pop';return document.MM_returnValue\">\n"
         . '<input type="button" name="close" value="'
         . _KHAT_POP_CLOSE
         . "\" onClick=\"callJS('top.close()')\">\n";
} else {
    echo ''
         . "<input type=\"text\" id=\message\" name=\"message\" style=\"boxStyle\" align=\"absmiddle\" value=\"\" size=\"$nbcar\">\n"
         . '<input type="submit" value="'
         . _KHAT_BLOC_SUBMIT
         . '">'
         . '<input type="button" name="Submit" value="'
         . _KHAT_POP
         . "\" onClick=\"openPopup('frames.php?modepop=1','Chat','scrollbars="
         . $xoopsModuleConfig['popupscrollbar']
         . ',resizable='
         . $xoopsModuleConfig['popupresizable']
         . ',width='
         . $xoopsModuleConfig['popupwidth']
         . ',height='
         . $xoopsModuleConfig['popupheight']
         . "')\">\n";
}
echo '<input type="button" name="emoticones" value="'
     . _KHAT_SMILIES
     . "\" onClick=\"openWithSelfMain('"
     . $xoopsConfig['xoops_url']
     . "/misc.php?action=showpopups&amp;type=smilies&amp;target=message','smilies',300,430)\">\n"
     . "<input type=\"button\" ID=\"son\" name=\"son\" value=\"$son\" onClick=\"parent.mainFrame.chataction.location.href = optionSon();return document.MM_returnValue\" >"
     . "</form>\n";

echo "<script language=\"JavaScript\"><!--\n";
echo "document.khatformpost.message.focus();\n";
echo '//--></script>';

xoops_footer();
//echo "</body>"
// ."</html>";
