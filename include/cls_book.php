<?php
class cls_book
{
    public function list_book()
    {
        $sql="select * from books order by book_id desc";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            return $ret;
        } catch (Exception $e) {
            return false;
        }
    }
    public function get_book_by_id($id)
    {
        $sql="select * from books where book_id='$id'";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            if(count($ret)>0) {
                return $ret[0];
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_max_id()
    {
        if (!$books=$this->list_book()) {
            return false;
        }
        return intval(substr($books[0]['book_id'],1));
    }

    public function get_next_id()
    {
        $maxid=$this->get_max_id();
        $maxid++;
        $nextid="b";
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
    
    public function name2id($bookname)
    {
        $sql="select * from books where book_name='$bookname'";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            if(count($ret)>0) {
                return $ret[0]['book_id'];
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function add_book($book)
    {
        $fields='';
        $values='';
        foreach($book as $k=>$v) {
            $fields.=",$k";
            $values.=",'$v'";
        }
        $fields=substr($fields,-1*strlen($fields)+1);
        $values=substr($values,-1*strlen($values)+1);
        $sql="insert into books($fields)values($values)";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function edit_book_by_id($bookid, $book)
    {
        $fv='';
        foreach($book as $k=>$v) {
            $fv.=",$k='$v'";
        }
        $fv=substr($fv,-1*strlen($fv)+1);
        $sql="update books set $fv where book_id='$bookid'";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function delete_book_by_id($bookid)
    {
        $sql="delete from books where book_id='$bookid'";
        try {
            $GLOBALS['db']->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function search_book($condition, $offset=0, $limit=30, $orderby='book_id')
    {
        $sql="select * from books where $condition order by $orderby limit $offset,$limit";
        try {
            $ret=$GLOBALS['db']->getAll($sql);
            return $ret;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
