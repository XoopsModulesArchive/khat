<?php

// class.khattxt.php v1.0 25/05/2003 kyex

// MANQUE: nettoyage fichier, enteteHTML

require_once XOOPS_ROOT_PATH . '/modules/khat/class/class.khat.php';

/**
 * class KhatTxt(Khat)
 *
 * Chat avec stockage dans un fichier texte
 */
class KhatTxt extends Khat
{
    /**
     * KhatTxt::KhatTxt()
     *
     * { Description }
     *
     * @param int $id
     */
    public function __construct($id = 0)
    {
        $this->filename = XOOPS_ROOT_PATH . '/modules/khat/cache/msg.php';

        //$this->soundfile = XOOPS_ROOT_PATH."/modules/khat/msg.wav";

        //	$this->db = XoopsDatabaseFactory::getDatabaseConnection();

        if (is_array($id)) {
            $this->makeKhat($id);
        }
    }

    /**
     * private
     *
     * Renvoie l'interpretation en HTML de la ligne passée en parametre
     *
     * @param string $s ligne à afficher
     * @param int    $i numero de la ligne
     * @return string ligne en HTML pour affichage
     */
    public function AfficheLigne($s, $i)
    {
        $myts = MyTextSanitizer::getInstance();

        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return '';
        }

        // traitement de l'heure

        $heure = formatTimestamp(mb_substr($s, 0, 10), $this->formatdate);

        $s = '<b>' . $heure . ' ' . mb_substr($s, 10);

        // kyex 21/05/2003 pour v1.1 - et myts xoops2

        if (1 == $this->html) {
            $s = $myts->undoHtmlSpecialChars($s);
        }

        $s = $myts->displayTarea($s, 1, $this->smiley, $this->xoopscode);

        return $this->liensAdmin($i) . $s . '<br>';
    }

    public function getMessage($s)
    {
        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return '';
        }

        return mb_substr($s, mb_strpos($s, '</b>') + 4);
    }

    public function getUser($s)
    {
        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return '';
        }

        $s = mb_substr($s, 13, mb_strpos($s, '</i>') - 13);

        return $s;
    }

    public function getUid($s)
    {
        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return 0;
        }

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $s = $this->getUser($s);

        $sql = 'SELECT uid FROM ' . $db->prefix('users') . " WHERE uname='$s'";

        $res = $db->query($sql);

        if (0 == $res) {
            return 0;
        }

        $row = $db->fetchArray($res);

        return $row['uid'];
    }

    public function getHeure($s)
    {
        if ('' == $s || $s == '<?php exit; ?' . '>') {
            return '';
        }

        return mb_substr($s, 0, 10);
    }

    /**
     * public
     *
     * Donne le contenu des $length dernieres lignes
     *
     * @param int $length de ligne à lire pour affichage
     * @return string le contenu du chat en HTML
     */
    public function getAllLines($length = 5)
    {
        $content = '';

        $lines = file($this->filename);

        $a = count($lines);

        $u = $a - $length;

        if ($u < 0) {
            $u = 0;
        }

        if ('bas' == $this->nouveauxmsg) {
            for ($i = $u; $i < $a; $i++) {
                $content .= $this->AfficheLigne(rtrim($lines[$i]), $i);
            }
        } else {
            for ($i = $a - 1; $i >= $u; $i--) {
                $content .= $this->AfficheLigne(rtrim($lines[$i]), $i);
            }
        }

        return $content;
    }

    /**
     * public
     *
     * Donne l'heure du dernier message envoyé qui correspondat à la date de modification du fichier
     *
     * @return int date du dernier message
     */
    public function lastMessageDate()
    {
        return filemtime($this->filename);
    }

    /**
     * public
     *
     * Sauvagarde du message dans le fichier
     */
    public function store()
    {
        $myts = MyTextSanitizer::getInstance();

        $message = $this->message;

        //$message=$myts->addSlashes($message,0);

        $message = htmlspecialchars($message, ENT_QUOTES | ENT_HTML5);

        $message = $myts->stripSlashesGPC($message);

        if ('' != $message) {
            // ecriture de l'heure au format time unix standard pour Xoops

            $infos = time() . '<i>' . $this->getPersonString() . '</i>';

            $fp = fopen($this->filename, 'a+b');

            $fw = fwrite($fp, "\n$infos :</b> $message");

            fclose($fp);
        }

        $this->nettoyage();
    }

    /**
     * KhatSql::nettoyage()
     *
     * Supprime de la base les lignes trop ancienne
     */
    public function nettoyage()
    {
        $lignes = file($this->filename);

        $nblignes = count($lignes);

        if ($nblignes > $this->maxlignes) {
            // on garde les dernieres lignes => on recupere la date de la premiere ligne a garder

            $premiereligne = $nblignes - $this->minlignes;

            $deleted = unlink($this->filename);

            $fp = fopen($this->filename, 'wb');

            fwrite($fp, '<?php exit; ?' . ">\n");

            for ($i = $premiereligne; $i < $nblignes; $i++) {
                fwrite($fp, $lignes[$i]);
            }

            fclose($fp);
        }
    }

    /**
     * KhatSql::supplig()
     *
     * Supprime ddu fichier une ligne (censure)
     *
     * @param mixed $lig
     * @return string
     * @return string
     */
    public function supplig($lig)
    {
        global $xoopsUser;

        $s = '';

        //$s.= "supplig $lig<br>";

        if ($xoopsUser) {
            //$s.= "user!";

            $xoopsKhatModule = XoopsModule::getByDirname('khat');

            if ($xoopsUser->isAdmin($xoopsKhatModule->mid())) {
                // on a le droit de virer la ligne $lig

                $s .= 'on supprime<br>';

                $lignes = file($this->filename);

                $nblignes = count($lignes);

                // on garde les dernieres lignes => on recupere la date de la premiere ligne a garder

                $deleted = unlink($this->filename);

                $fp = fopen($this->filename, 'wb');

                for ($i = 0; $i < $lig; $i++) {
                    fwrite($fp, $lignes[$i]);
                }

                for ($i = $lig + 1; $i < $nblignes; $i++) {
                    fwrite($fp, $lignes[$i]);
                }

                fclose($fp);
            }
        }

        return $s;
    }

    public function search($queryarray, $andor, $limit, $offset, $userid)
    {
        $lignes = file($this->filename);

        $ret = [];

        $nblignes = count($lignes);

        $i = 0;

        foreach ($lignes as $num => $ligne) {
            if (mb_stristr($ligne, $queryarray[0])) {
                $ret[$i]['link'] = 'index.php?op=archive&lig=' . $num . '';

                $ret[$i]['title'] = $this->getMessage($ligne);

                $ret[$i]['time'] = $this->getHeure($ligne);

                $ret[$i]['uid'] = $this->getUid($ligne);

                $i++;
            }
        }

        return $ret;
    }
}
