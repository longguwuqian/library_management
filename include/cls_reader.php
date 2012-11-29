<?php
class cls_reader
{
    private function check_unique($readername)
    {
         $sql="select * from readers where reader_name='$readername'";
         try {
              $ret=$GLOBALS['db']->getAll($sql);
              if(count($ret)<1) {
                  return true;
           } else {
                  return false;
           }
         } catch(Exception $e) {
             return false ;
         }
    }

    public function list_reader()
    {
        $sql="select * from readers order by reader_id desc";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            return $ret;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete_reader($id)
    {
        $sql="delete from readers where reader_id='$uid'";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function get_max_id()
    {
        if (!$readers=$this->list_reader()) {
            return false;
        }
        return intval(substr($readers[0]['reader_id'],1));
    }

    public function get_next_id()
    {
        $maxid=$this->get_max_id();
        $maxid++;
        $nextid="r";
        if($maxid > 99) {
            $nextid.=$maxid;
        } elseif($maxid > 9) {
            $nextid.="0";
            $nextid.=$maxid;
        } else {
            $nextid.="00";
            $nextid.=$maxid;
        }
        return $nextid;
    }

    public function add_reader($reader)
    {
        $fields='';
        $values='';
        $reader['reader_pwd']=md5($reader['reader_pwd']);
        foreach($reader as $k=>$v) {
            $fields.=",$k";
            $values.=",'$v'";
        }
        $fields=substr($fields,-1*strlen($fields)+1);
        $values=substr($values,-1*strlen($values)+1);
        if(!$this->check_unique($reader['reader_name'])) {
            return false;
        }
        $sql="insert into readers($fields)values($values)";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function edit_reader($id,$reader)
    {
        $fv='';
        foreach($reader as $k=>$v) {
            $fv.=",$k='$v'";
        }
        $fv=substr($fv,-1*strlen($fv)+1);
        $sql="update readers set $fv where reader_id='$id'";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function get_id_by_name($reader)
    {
        $sql="select reader_id from readers where reader_name='$reader'";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            if(count($ret)<0) {
                return false;
            } else {
                return $ret[0]['reader_id'];
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_reader_by_id($id)
    {
        $sql="select * from readers where reader_id='$id'";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            if(count($ret)>0) {
                return $ret[0];
            } else {
                return false;
            }
        } catch(Exception $e) {
            return false;
        }
    }

}
?>
