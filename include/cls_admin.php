<?php
class cls_admin
{
    private function check_unique($name)
    {
         $sql="select * from admin where admin_name='$name'";
         try {
              $ret=$GLOBALS['db']->getAll($sql);
              if(count($ret)<1) {
                  return true;
           } else {
                  return false;
           }
         } catch(Exception $e) {
           return false;
       }
    }

    public function list_admin()
    {
        $sql="select * from admin order by admin_id desc";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            return $ret;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete_admin($id)
    {
        $sql="delete from admin where admin_id='$id'";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function add_admin($admin)
    {
        $fields='';
        $values='';
        $admin['admin_pwd']=md5($admin['admin_pwd']);
        foreach($admin as $k=>$v) {
            $fields.=",$k";
            $values.=",'$v'";
        }
        $fields=substr($fields,-1*strlen($fields)+1);
        $values=substr($values,-1*strlen($values)+1);
        if(!$this->check_unique($admin['admin_name'])) {
            return false;
        }
        $sql="insert into admin ($fields)values($values)";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function edit_admin($id, $admin)
    {
        $fv='';
        foreach($admin as $k=>$v) {
            $fv.=",$k='$v'";
        }
        $fv=substr($fv,-1*strlen($fv)+1);
        $sql="update admin set $fv where admin_id='$id'";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function get_id_by_name($name)
    {
        $sql="select id from admin where admin_name='$name'";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            if(count($ret)<0) {
                return false;
            } else {
                return $ret[0]['admin_id'];
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function admin_login($name, $pwd)
    {
        $pwd=md5($pwd);
        $sql="select * from admin where admin_name='$name' and admin_pwd='$pwd'";
        try
        {
            $ret=$GLOBALS['db']->getAll($sql);
            if(count($ret)>0) {
                $_SESSION['admin']=$ret[0];
                echo $ret[0];
                return $ret[0];
            } else {
                return false;
            }
        } catch(Exception $e) {
            return false;
        }
    }

    public function get_admin_by_id($id)
    {
        $sql="select * from admin where admin_id='$id'";
        try
        {
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

    public function admin_logout()
    {
        if(isset($_SESSION['admin']))
        {
            unset($_SESSION['admin']);
        }
    }
}
?>

