<?php

class OnlyBoard_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function gets($table)    // 모든 행 select
    {
        return $this->db->query("select * from $table")->result_array();
    }

    public function get($table, $id)    // 하나의 행 select
    {
        return $this->db->query("select * from $table where id=$id")->result_array();
    }

    public function commend_gets($id)   // 댓글들 select
    {
        return $this->db->query("select * from commend where id=$id and type=1")->result_array();
    }

    public function commend_commend_gets($id) //댓글의 댓글 select
    {
        return $this->db->query("select * from commend where type=2 and id=$id")->result_array();
    }

    public function insert($user_id, $user_name, $subject, $context) // 글 쓰기
    {
        $this->db->query("insert into board (user_id, user_name, subject, context, hits) values(\"$user_id\", \"$user_name\", \"$subject\", \"$context\", 0);");
    }

    public function commend_insert($type, $id, $user_id, $subject) // 댓글 쓰기
    {
        $this->db->query("insert into commend(type, id, user_id, subject) values($type, $id, '$user_id', '$subject');");
    }

    public function commend_commend_insert($type, $id, $commend_commend_id, $user_id, $subject) // 댓글의 댓글 쓰기
    {
        $this->db->query("insert into commend(type, id, commend_commend_id, user_id, subject) values($type, $id, $commend_commend_id, '$user_id', '$subject');");
    }

    public function modify($table, $subject, $context, $id) // 글 수정
    {
        $sql = "update $table set subject='$subject', context='$context' where id=$id";
        $this->db->query($sql);
    }

    public function modify_hits($table, $id)        // 조회수 +1
    {
        $this->db->query("update $table set hits=hits+1 where id='$id'");
    }

    public function remove($table, $id)             // 글 삭제
    {
        $this->db->query("delete from $table where id=$id");
    }

    public function search($row, $table, $text)     // 검색
    {
        return $this->db->query("select * from $table where $row LIKE " . '"%' . "$text" . '%"')->result_array();
    }

}

?>