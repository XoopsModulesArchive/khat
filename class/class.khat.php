<?php

// class.forumposts.php v1.0 18/05/2003 kyex

// MANQUE: nettoyage fichier -> uniquement dans sous-classes fichier, enteteHTML

require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

class Khat
{
    public $uid;

    public $person;

    public $message;

    public $html = 0;

    public $smiley = 0;

    public $xoopscode = 0;

    public $formatdate = 's';

    public $soundfile; // = XOOPS_ROOT_PATH."/modules/khat/msg.wav";

    public $timeout = '10';

    public $ano = '(@)';

    public $nouveauxmsg = 'bas';

    // variables concernant le stockage fichier, ici pour compatibilité anciennes versions
    // à supprimer dans future version
    public $filename; // = XOOPS_ROOT_PATH."/modules/khat/cache/msg.php";
    public $max_file_size = '10000';

    public $maxlignes = 500;

    public $minlignes = 100;

    public $lien = '';

    public $paramlien = '';

    public $mode = 'php';   // méthode de stockage des données du chat

    public $salon = '0';

    public $prefix;

    public $db;

    public function __construct($id = 0)
    {
        $this->filename = XOOPS_ROOT_PATH . '/modules/khat/cache/msg.php';

        $this->soundfile = XOOPS_ROOT_PATH . '/modules/khat/msg.wav';

        $this->db = XoopsDatabaseFactory::getDatabaseConnection();

        if (is_array($id)) {
            $this->makeKhat($id);
        }
    }

    public function setHtml($value = 0)
    {
        $this->html = $value;
    }

    public function setSmiley($value = 0)
    {
        $this->smiley = $value;
    }

    public function setXoopsCode($value = 0)
    {
        $this->xoopscode = $value;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setPerson($person)
    {
        $this->person = $person;
    }

    public function setLien($lien)
    {
        $this->lien = $lien;
    }

    public function setParamlien($paramlien)
    {
        $this->paramlien = $paramlien;
    }

    public function makeKhat($array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

    public function html()
    {
        return $this->html;
    }

    public function smiley()
    {
        return $this->smiley;
    }

    public function xoopsCode()
    {
        return $this->xoopscode;
    }

    public function getPersonString($id = 0)
    {
        global $REMOTE_ADDR;

        global $xoopsUser;

        if ($id > 0) {
            return (XoopsUser::getUnameFromId($id));
        }

        $res = $this->ano;

        $ip = null;

        if ($xoopsUser) {
            $person = $xoopsUser->uname();

            if ('' == $person) {
                $ip = $xoopsUser->getClientIP();
            }
        } else {
            $ip = $REMOTE_ADDR;
        }

        if ($ip) {
            $res = str_replace('@', $ip, $res);
        } else {
            $res = $person;
        }

        return ($res);
    }

    public function liensAdmin($ligne)
    {
        global $xoopsUser;

        $s = '';

        //$s.= "lienAdmins<br>";

        if ($xoopsUser) {
            //$s.= "user!";

            $xoopsModule = XoopsModule::getByDirname('khat');

            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                //$s.=",admin!";

                $liensupp = $this->lien;

                if ('' != $this->paramlien) {
                    $liensupp .= $this->paramlien . '&';
                } else {
                    $liensupp .= '?';
                }

                $s .= '<a href="' . $liensupp . 'op=supprlig&lig=' . $ligne . '"><img src="' . XOOPS_URL . '/modules/khat/images/delete.gif"></a>' . $s;
            }
        }

        return $s;
    }
}
