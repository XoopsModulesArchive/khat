<?php

$modversion['name'] = _MI_KHAT_NOM;
$modversion['version'] = '1.5';
$modversion['description'] = _MI_KHAT_DESC_BLOC;
$modversion['author'] = 'divers';
$modversion['credits'] = 'docs/CREDITS.txt';
$modversion['help'] = 'docs/INSTALL.txt';
$modversion['license'] = 'GPL : docs/LICENSE.txt';
$modversion['official'] = 0;
$modversion['image'] = 'images/khat.jpg';
$modversion['dirname'] = 'khat';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';

// Blocks
$modversion['blocks'][1]['file'] = 'khat.php';
$modversion['blocks'][1]['name'] = _MI_KHAT_NOM_BLOC;
$modversion['blocks'][1]['description'] = _MI_KHAT_DESC_BLOC;
$modversion['blocks'][1]['show_func'] = 'b_khat_show';
$modversion['blocks'][1]['edit_func'] = 'b_khat_edit';
$modversion['blocks'][1]['options'] = '170|10|20|checked';
// Menu
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'khat_search';

// Templates
$modversion['templates'][1]['file'] = 'khat_frames.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'khat_frames_pop.html';
$modversion['templates'][2]['description'] = '';

// Sql
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'khat';

// Config Settings (only for modules that need config settings generated automatically)

/////////////////////////////////
// variables generales
/////////////////////////////////

$modversion['config'][1]['name'] = 'soundfile';
$modversion['config'][1]['title'] = '_MI_KHAT_SOUNDFILE';
$modversion['config'][1]['description'] = '_MI_KHAT_SOUNDFILEDESC';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = 'modules/khat/msg.wav';

$modversion['config'][2]['name'] = 'ano';
$modversion['config'][2]['title'] = '_MI_KHAT_ANO';
$modversion['config'][2]['description'] = '_MI_KHAT_ANODESC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = '(@)';

$modversion['config'][3]['name'] = 'smiley';
$modversion['config'][3]['title'] = '_MI_KHAT_SMILEY';
$modversion['config'][3]['description'] = '_MI_KHAT_SMMILEYDESC';
$modversion['config'][3]['formtype'] = 'yesno';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 1;

$modversion['config'][4]['name'] = 'html';
$modversion['config'][4]['title'] = '_MI_KHAT_HTML';
$modversion['config'][4]['description'] = '_MI_KHAT_HTMLDESC';
$modversion['config'][4]['formtype'] = 'yesno';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = 0;

$modversion['config'][5]['name'] = 'xoopscode';
$modversion['config'][5]['title'] = '_MI_KHAT_XOOPSCODE';
$modversion['config'][5]['description'] = '_MI_KHAT_XOOPSCODEDESC';
$modversion['config'][5]['formtype'] = 'yesno';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = 1;

$modversion['config'][6]['name'] = 'timeout';
$modversion['config'][6]['title'] = '_MI_KHAT_TIMEOUT';
$modversion['config'][6]['description'] = '_MI_KHAT_TIMEOUTDESC';
$modversion['config'][6]['formtype'] = 'textbox';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = 10;

$modversion['config'][7]['name'] = 'formatdate';
$modversion['config'][7]['title'] = '_MI_KHAT_FORMATDATE';
$modversion['config'][7]['description'] = '_MI_KHAT_FORMATDATEDESC';
$modversion['config'][7]['formtype'] = 'textbox';
$modversion['config'][7]['valuetype'] = 'text';
$modversion['config'][7]['default'] = 'd/m H:i';

$modversion['config'][8]['name'] = 'nouveauxmsg';
$modversion['config'][8]['title'] = '_MI_KHAT_NOUVEAUXMSG';
$modversion['config'][8]['description'] = '_MI_KHAT_NOUVEAUXMSGDESC';
$modversion['config'][8]['formtype'] = 'select';
$modversion['config'][8]['valuetype'] = 'text';
$modversion['config'][8]['default'] = 'bas';
$modversion['config'][8]['options'] = ['_MI_KHAT_HAUT' => 'haut', '_MI_KHAT_BAS' => 'bas'];

$modversion['config'][9]['name'] = 'mode';
$modversion['config'][9]['title'] = '_MI_KHAT_MODE';
$modversion['config'][9]['description'] = '_MI_KHAT_MODEDESC';
$modversion['config'][9]['formtype'] = 'select';
$modversion['config'][9]['valuetype'] = 'text';
$modversion['config'][9]['default'] = 'KhatSql';
$modversion['config'][9]['options'] = ['_MI_KHAT_MODE_SQL' => 'KhatSql', '_MI_KHAT_MODE_TXT' => 'KhatTxt', '_MI_KHAT_MODE_CSV' => 'KhatCsv'];

/////////////////////  plus tard ...  $khatSalon="0";

/////////////////////////////////
// Popup
/////////////////////////////////
$modversion['config'][10]['name'] = 'popupscrollbar';
$modversion['config'][10]['title'] = '_MI_KHAT_POPUP_SCROLLBAR';
$modversion['config'][10]['description'] = '_MI_KHAT_POPUP_SCROLLBARDESC';
$modversion['config'][10]['formtype'] = 'yesno';
$modversion['config'][10]['valuetype'] = 'int';
$modversion['config'][10]['default'] = 1;

$modversion['config'][11]['name'] = 'popupresizable';
$modversion['config'][11]['title'] = '_MI_KHAT_POPUP_RESIZABLE';
$modversion['config'][11]['description'] = '_MI_KHAT_POPUP_RESIZABLEDESC';
$modversion['config'][11]['formtype'] = 'yesno';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 1;

$modversion['config'][12]['name'] = 'popupwidth';
$modversion['config'][12]['title'] = '_MI_KHAT_POPUP_WIDTH';
$modversion['config'][12]['description'] = '_MI_KHAT_POPUP_WIDTHDESC';
$modversion['config'][12]['formtype'] = 'textbox';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 400;

$modversion['config'][13]['name'] = 'popupheight';
$modversion['config'][13]['title'] = '_MI_KHAT_POPUP_HEIGHT';
$modversion['config'][13]['description'] = '_MI_KHAT_POPUP_HEIGHTDESC';
$modversion['config'][13]['formtype'] = 'textbox';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = 550;

$modversion['config'][14]['name'] = 'popupboxcols';
$modversion['config'][14]['title'] = '_MI_KHAT_POPUP_BOXCOLS';
$modversion['config'][14]['description'] = '_MI_KHAT_POPUP_BOXCOLSDESC';
$modversion['config'][14]['formtype'] = 'textbox';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = 50;

$modversion['config'][15]['name'] = 'popuplength';
$modversion['config'][15]['title'] = '_MI_KHAT_POPUP_LENGTH';
$modversion['config'][15]['description'] = '_MI_KHAT_POPUP_LENGTHDESC';
$modversion['config'][15]['formtype'] = 'textbox';
$modversion['config'][15]['valuetype'] = 'int';
$modversion['config'][15]['default'] = 50;
