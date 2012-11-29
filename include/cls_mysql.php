<?php

class cls_mysql
{
    var $link_id    = NULL;
    var $settings   = array();
    var $error_message  = array();

    function __construct($dbhost, $dbuser, $dbpw, $dbname = '', $charset = 'utf8', $pconnect = 0)
    {
        $this->cls_mysql($dbhost, $dbuser, $dbpw, $dbname, $charset, $pconnect);
    }

    function cls_mysql($dbhost, $dbuser, $dbpw, $dbname = '', $charset = 'utf8', $pconnect = 0)
    {
        $this->settings = array(
                                    'dbhost'   => $dbhost,
                                    'dbuser'   => $dbuser,
                                    'dbpw'     => $dbpw,
                                    'dbname'   => $dbname,
                                    'charset'  => $charset,
                                    'pconnect' => $pconnect
                                    );
    }

    function connect($dbhost, $dbuser, $dbpw, $dbname = '')
    {
        $this->link_id = mysql_connect($dbhost, $dbuser, $dbpw, true);
        if (!$this->link_id) {
              return false;
        }

        /* 选择数据库 */
        if ($dbname) {
            if (mysql_select_db($dbname, $this->link_id) === false ) {
                    $this->ErrorMsg("Can't select MySQL database($dbname)!");
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    function select_database($dbname)
    {
        return mysql_select_db($dbname, $this->link_id);
    }

    function fetch_array($query, $result_type = MYSQL_ASSOC)
    {
        return mysql_fetch_array($query, $result_type);
    }

    function query($sql, $type = '')
    {
        if ($this->link_id === NULL) {
            $this->connect($this->settings['dbhost'], $this->settings['dbuser'], $this->settings['dbpw'], $this->settings['dbname'], $this->settings['charset'], $this->settings['pconnect']);
            $this->settings = array();
        }
        if (!($query = mysql_query($sql, $this->link_id)) && $type != 'SILENT') {
            $this->error_message[]['message'] = 'MySQL Query Error';
            $this->error_message[]['sql'] = $sql;
            $this->error_message[]['error'] = mysql_error($this->link_id);
            $this->error_message[]['errno'] = mysql_errno($this->link_id);

            $this->ErrorMsg();

            return false;
        }

        return $query;
    }
    function error()
    {
        return mysql_error($this->link_id);
    }

    function errno()
    {
        return mysql_errno($this->link_id);
    }

    function result($query, $row)
    {
        return @mysql_result($query, $row);
    }

    function close()
    {
        return mysql_close($this->link_id);
    }

    function ErrorMsg($message = '', $sql = '')
    {
        if ($message) {
            echo "<b>info</b>: $message\n\n<br /><br />";
        } else {
            echo "<b>MySQL server error report:";
            print_r($this->error_message);
        }

        exit;
    }
    function getAll($sql)
    {
        $res = $this->query($sql);
        if ($res !== false) {
            $arr = array();
            while ($row = mysql_fetch_assoc($res)) {
                $arr[] = $row;
            }
            return $arr;
        } else {
            return false;
        }
    }

}

?>