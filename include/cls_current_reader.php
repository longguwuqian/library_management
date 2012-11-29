<?php
class cls_current_reader
{
    public $reader_name;
    public $reader_id;

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

    public function login($name,$pwd)
    {
        $pwd=md5($pwd);
        echo $pwd;
        $sql="select * from readers where reader_name='$name' and reader_pwd='$pwd'";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            if(count($ret)>0) {
                $this->$reader_name=$name;
                $this->$reader_id = $this->get_id_by_name($this->$reader_name);
                $_SESSION['reader']=$ret[0];
                return $ret[0];
            } else {
                return false;
            }
        } catch(Exception $e) {
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

    public function logout()
    {
        if(isset($_SESSION['reader'])) {
            unset($_SESSION['reader']);
        }
    }

    private function borrow_avaliable($bookid)
    {
        try {
            $sql="select books.quantity_in,books.quantity_out,books.quantity_loss from books where book_id='$bookid'";
            $ret=$GLOBALS['db']->getAll($sql);
            if(count($ret)>0) {
                $quantity_in = $ret[0]['quantity_in'];
                $quantity_out = $ret[0]['quantity_out'];
                $quantity_loss = $ret[0]['quantity_loss'];
                if($quantity_in-$quantity_out-$quantity_loss > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch(Exception $e) {
            return false;
        }
    }

    public function borrow($bookid)
    {
        if(!$this->borrow_avaliable($bookid)) {
            return false;
        }
        /* 添加借阅记录 */
        $_date = getdate();
        $date = $_date['year']."-".$date['mon']."-".$date['mday'];
        $sql_add_borrow_record = "insert into borrow (reader_id, book_id, date_borrow, deadline, loss, is_returned) values (
                 '$this->$reader_id','$bookid', '$date', '2012-12-21', '否', '否')";

        /* 增加借阅数量 */
        $sql_inc_quantity_out = "update books set quantity_out = (select books.quantity_out from books where book_id = '$bookid') + 1 where book_id = '$bookid";


        try {
            $GLOBALS['db']->query($sql_add_borrow_record);
            $GLOBALS['db']->query($sql_inc_quantity_out);
            return true;
        } catch (Exception $e) {
            return false;
        }



    }
}
?>
