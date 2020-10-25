<?php

/*
************************************************************************************************
* Khat 1.1 admin pour xoops 2
*************************************************************************************************
*/

// ajouts pour XOOPS
include 'admin_header.php';
require XOOPS_ROOT_PATH . '/modules/khat/cache/config.php';
//error_reporting(E_ALL);
/*
*********************************************************
* administration de khat : gestion des parametres du fichier config.php
*
*********************************************************
*/

function khatAdmin()
{
    global $xoopsModule;

    xoops_cp_header();

    echo "<b>- <a href='" . XOOPS_URL . '/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid') . "'>" . _PREFERENCES . "</a></b><br>\n";

    echo '<b>- <a href="' . XOOPS_URL . '/modules/khat/admin/index.php?req=khatLoadConfigFile">' . _KHAT_CHARGER_FICHIER_CONFIG . '</a></b><br>';

    echo '<b>- <a href="' . XOOPS_URL . '/modules/khat/admin/index.php?req=khatSaveConfigFile">' . _KHAT_SAUVER_FICHIER_CONFIG . '</a></b><br>';
}

function khatconfigsauve($xchat_file, $xchat_soundfile, $xchat_length_p, $xmax_file_size, $xkhatimeout, $xkhatformatdate, $xkhatano, $xkhatsmiley, $xkhathtml, $xkhatbbcode, $xkhatnouveauxmsg, $xkhatmode, $xkhatsalon, $xpopupScrollbar, $xpopupResizable, $xpopupWidth, $xpopupHeight, $xpopupBoxCols)
{
    $myts = MyTextSanitizer::getInstance();

    $filename = '../cache/config.php';

    $file = fopen($filename, 'wb');

    $content = '';

    $content .= "<?\n";

    $content .= "/*\n";

    $content .= "************************************************************************************************\n";

    $content .= "*                    Module khat 1.1  pour XOOPS 2\n";

    $content .= "*\n";

    $content .= "* adapté à XOOPS et enrichi par kyex (http://kyex.inconnueteam.net)\n";

    $content .= "* pour toute question n'hésitez pas à me contacter sur kyeXoops\n";

    $content .= "* Fichier CONFIG.PHP pour le module khat\n";

    $content .= "* Ce fichier sert à renseigner les parametres de votre chat\n";

    $content .= "* Les modifications de ce fichier sont apportées via le module admin de votre site XOOPS\n";

    $content .= "*************************************************************************************************\n";

    $content .= "*/\n";

    $content .= "\n";

    $content .= "/////////////////////////////////\n";

    $content .= "// variables generales \n";

    $content .= "/////////////////////////////////\n";

    $content .= "\$chat_file = \"$xchat_file\";\n"; // fichier txt (ou autre) utilisé pour stocker les messages
    $content .= "\$chat_soundfile = \"$xchat_soundfile\";\n"; // fichier wav pour avertir d'un nouveau message
    $content .= "\$chat_length_p = $xchat_length_p;\n"; // nombre de messages affichés dans le popup
    $content .= "\$max_file_size = \"$xmax_file_size\";\n"; //taille en bytes (100,000 bytes = 100Kb)
    $content .= "\$khatAno = \"$xkhatano\";\n";

    $content .= "\$khatsmiley = \"$xkhatsmiley\";\n";

    $content .= "\$khathtml = \"$xkhathtml\";\n";

    $content .= "\$khatbbcode = \"$xkhatbbcode\";\n";

    $content .= "\$khatimeout= \"$xkhatimeout\";\n";

    $content .= "\$khatformatdate= \"$xkhatformatdate\";\n";

    $content .= "\$khatnouveauxmsg= \"$xkhatnouveauxmsg\";\n";

    $content .= "\$khatMode=\"$xkhatmode\";\n";

    $content .= "\$khatSalon=\"$xkhatsalon\";\n";

    $content .= "/////////////////////////////////\n";

    $content .= "// Popup \n";

    $content .= "/////////////////////////////////\n";

    //	$content .= "\$boxTextDefault_p = \"$xboxTextDefault_p\";\n";

    $content .= "\$popupScrollbar = \"$xpopupScrollbar\";\n";

    $content .= "\$popupResizable = \"$xpopupResizable\";\n";

    $content .= "\$popupWidth = \"$xpopupWidth\";\n";

    $content .= "\$popupHeight = \"$xpopupHeight\";\n";

    $content .= "\$popupBoxCols=\"$xpopupBoxCols\";\n";

    $content .= '?';

    $content .= '>';

    fwrite($file, $content);

    fclose($file);

    //Header("Location: index.php");

    redirect_header('index.php', 3, _KHAT_CONFIG_FILE_SAVED);
}

function khat_make_config_post($nomconf_xoops, $valeur, $conf)
{
    $id = $conf[(string)$nomconf_xoops];

    echo "<input type='hidden' name='$nomconf_xoops' id='$nomconf_xoops' value='$valeur'>";

    echo "<input type='hidden' name='conf_ids[]' id='conf_ids[]' value='$id'>";
}

function khat_load_config_file()
{
    global $configHandler, $xoopsModule;

    $configs = &$configHandler->getConfigs(new Criteria('conf_modid', $xoopsModule->getVar('mid')));

    $conf = [];

    foreach ($configs as $key => $config) {
        $conf[$config->getVar('conf_name')] = $config->getVar('conf_id');
    }

    require XOOPS_ROOT_PATH . '/modules/khat/cache/config.php';

    xoops_cp_header();

    echo "<form name='pref_form' id='pref_form'  action='" . XOOPS_URL . "/modules/system/admin.php?fct=preferences' method='post'>";

    khat_make_config_post('soundfile', $chat_soundfile, $conf);

    khat_make_config_post('ano', $khatAno, $conf);

    khat_make_config_post('smiley', $khatsmiley, $conf);

    khat_make_config_post('html', $khathtml, $conf);

    khat_make_config_post('xoopscode', $khatbbcode, $conf);

    khat_make_config_post('timeout', $khatimeout, $conf);

    khat_make_config_post('formatdate', $khatformatdate, $conf);

    khat_make_config_post('nouveauxmsg', $khatnouveauxmsg, $conf);

    khat_make_config_post('mode', $khatMode, $conf);

    khat_make_config_post('popuplength', $chat_mength_p, $conf);

    khat_make_config_post('popupscrollbar', $popupScrollbar, $conf);

    khat_make_config_post('popupresizable', $popupResizable, $conf);

    khat_make_config_post('popupwidth', $popupWidth, $conf);

    khat_make_config_post('popupheight', $popupHeight, $conf);

    khat_make_config_post('popupboxcols', $popupBoxCols, $conf);

    echo "<input type='hidden' name='op' id='op' value='save'>";

    echo '<input type=submit value=' . _KHAT_MODIFIER . '>';

    echo '</form>';
}

function khat_save_config_file()
{
    global $configHandler, $xoopsModule;

    $configs = &$configHandler->getConfigs(new Criteria('conf_modid', $xoopsModule->getVar('mid')));

    $conf = [];

    foreach ($configs as $key => $config) {
        $conf[$config->getVar('conf_name')] = $config->getVar('conf_value');
    }

    khatconfigsauve(
        'modules/khat/cache/msg.php',
        $conf['soundfile'],
        $conf['popuplength'],
        10000,
        $conf['timeout'],
        $conf['formatdate'],
        $conf['ano'],
        $conf['smiley'],
        $conf['html'],
        $conf['xoopscode'],
        $conf['nouveauxmsg'],
        $conf['mode'],
        0,
        $conf['popupscrollbar'],
        $conf['popupresizable'],
        $conf['popupwidth'],
        $conf['popupheight'],
        $conf['popupboxcols']
    );
}

//echo "op=$op ;req=$req !!!<br>";

switch ($req) {
    case 'khatconfigsauve':
        khatconfigsauve($xchat_file, $xchat_soundfile, $xchat_length_p, $xmax_file_size, $xkhatimeout, $xkhatformatdate, $xkhatano, $xkhatsmiley, $xkhathtml, $xkhatbbcode, $xkhatnouveauxmsg, $xkhatmode, $xkhatsalon, $xpopupScrollbar, $xpopupResizable, $xpopupWidth, $xpopupHeight, $xpopupBoxCols);
        break;
    case 'khatSaveConfigFile':
        khat_save_config_file();
        break;
    case 'khatLoadConfigFile':
        khat_load_config_file();
        break;
    default:
        khatAdmin();
        break;
}

// ajout XOOPS
include 'admin_footer.php';
