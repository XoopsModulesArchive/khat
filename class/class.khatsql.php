<?php

// class.khatsql.php v1.0 26/05/2003 kyex

// MANQUE: nettoyage fichier, enteteHTML

require_once XOOPS_ROOT_PATH . '/modules/khat/class/class.khat.php';

/**
 * class KhatSql(Khat)
 *
 * Chat avec stockage en base de données
 */
class KhatSql extends Khat
{
    /**
     * KhatSql::$table
     *
     * Nom de la table dans laquelle est stockée le contenu du chat
     */

    public $table;

    /**
     * KhatSql::KhatSql()
     *
     * Constructeur
     *
     * @param int $id
     */
    public function __construct($id = 0)
    {
        $this->soundfile = XOOPS_ROOT_PATH . '/modules/khat/msg.wav';

        $this->db = XoopsDatabaseFactory::getDatabaseConnection();

        $this->table = $this->db->prefix('khat');

        if (is_array($id)) {
            $this->makeKhat($id);
        }
    }

    /**
     * KhatSql::AfficheLigne()
     *
     * retourne la ligne passée en parametre mise en forme
     *
     * @param string $row
     * @return string
     * @return string
     */
    public function AfficheLigne($row)
    {
        $myts = MyTextSanitizer::getInstance();

        $s = $row['message'];

        // traitement de l'heure

        $heure = formatTimestamp($row['heure'], $this->formatdate);

        $person = $row['person'];

        if ('' == $person) {
            $this->getPersonString($row['uid']);
        }

        $s = $myts->displayTarea($s, $this->html, $this->smiley, $this->xoopscode);

        $s = '<b>' . $heure . '</b> <i>' . $person . '</i>: ' . $s;

        // test si admin et si oui, on active le lien de suppression de la ligne (a mettre dans classe mere ???)

        return $this->liensAdmin($row['khatid']) . $s . '<br>';
    }

    /**
     * KhatSql::getAllLines()
     *
     * retourne le contenu des $length dernieres lignes
     *
     * @param int $length de ligne à lire pour affichage
     * @return string le contenu du chat en HTML
     */
    public function getAllLines($length = 5)
    {
        $content = '';

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE salon=' . $this->salon . ' ORDER by heure DESC';

        $result = $this->db->query($sql, (int)$length);

        while (false !== ($myrow = $this->db->fetchArray($result))) {
            if ('bas' != $this->nouveauxmsg) {
                $content .= $this->AfficheLigne($myrow);
            } else {
                $content = $this->AfficheLigne($myrow) . $content;
            }
        }

        return $content;
    }

    /**
     * KhatSql::lastMessageDate()
     *
     * Donne l'heure du dernier message envoyé qui correspondat à la date de modification du fichier
     *
     * @return int date du dernier message
     */
    public function lastMessageDate()
    {
        $sql = 'SELECT max(heure) FROM ' . $this->table . ' WHERE salon=' . $this->salon;

        $result = $this->db->query($sql);

        $myrow = $this->db->fetchRow($result);

        return $myrow[0];
    }

    /**
     * KhatSql::store()
     *
     * Sauvagarde du message dans la base
     */
    public function store()
    {
        global $xoopsUser;

        $myts = MyTextSanitizer::getInstance();

        $message = $this->message;

        $message = $myts->addSlashes($message);

        if ('' != $message) {
            // ecriture de l'heure au format time unix standard pour Xoops

            $heure = time();

            $person = $this->getPersonString();

            if ($xoopsUser) {
                $uid = $xoopsUser->getVar('uid');
            }

            $sql = 'INSERT INTO ' . $this->table . ' (salon, person, uid, heure, message) VALUES (' . $this->salon . ",'$person', $uid, $heure,'$message')";

            $this->db->query($sql);

            $this->nettoyage();
        }
    }

    /**
     * KhatSql::nettoyage()
     *
     * Supprime de la base les lignes trop ancienne
     */
    public function nettoyage()
    {
        // on compte le nb de lignes pour le salon

        $sql = 'SELECT count(*) FROM ' . $this->table . ' WHERE salon=' . $this->salon;

        $result = $this->db->query($sql);

        $myrow = $this->db->fetchRow($result);

        $nblignes = $myrow[0];

        if ($nblignes > $this->maxlignes) {
            // on garde les dernieres lignes => on recupere la date de la premiere ligne a garder

            $sql = 'SELECT heure FROM ' . $this->table . ' WHERE salon=' . $this->salon . ' ORDER by heure';

            $result = $this->db->query($sql, 1, $nblignes - $this->minlignes);

            $myrow = $this->db->fetchRow($result);

            $minheure = $myrow[0];

            $sql = 'DELETE FROM ' . $this->table . ' WHERE salon=' . $this->salon . ' AND heure <' . $minheure;

            $this->db->query($sql);
        }
    }

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

                $sql = 'DELETE FROM ' . $this->table . ' WHERE khatid=' . $lig;

                $s .= $sql;

                $res = $this->db->queryF($sql);

                $s .= $res . '<br>';

                $s .= $this->db->error() . ',' . $this->db->errno() . '.<br>';
            }
        }

        return $s;
    }

    public function search($queryarray, $andor, $limit, $offset, $userid)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE salon=0';

        if (is_array($queryarray) && $count = count($queryarray)) {
            $sql .= " AND ((message LIKE '%$queryarray[0]%')";

            for ($i = 1; $i < $count; $i++) {
                $sql .= " $andor ";

                $sql .= "(message LIKE '%$queryarray[$i]%')";
            }

            $sql .= ') ';
        }

        $sql .= 'ORDER BY heure DESC';

        $result = $this->db->query($sql, $limit, $offset);

        $ret = [];

        $i = 0;

        while (false !== ($myrow = $this->db->fetchArray($result))) {
            //$ret[$i]['image'] = "images/.gif";

            $ret[$i]['link'] = 'index.php?op=archive&lig=' . $myrow['khatid'] . '';

            $ret[$i]['title'] = $myrow['message'];

            $ret[$i]['time'] = $myrow['heure'];

            $ret[$i]['uid'] = $myrow['uid'];

            $i++;
        }

        return $ret;
    }
}



