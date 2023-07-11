<?php
require_once('Database.php');

class Message{
    public static function getMessageLabel($id){
        $db = new Database();
        $sql = 'SELECT label FROM message WHERE id = :id LIMIT 1';
        $request = $db->prepare($sql);
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();
        $msg = $request->fetch(PDO::FETCH_OBJ);
        $msg = $msg->label;
        return $msg;        
    }

    public static function getMessageCause($id){
        $db = new Database();
        $sql = 'SELECT cause FROM message WHERE id = :id LIMIT 1';
        $request = $db->prepare($sql);
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();
        $msg = $request->fetch(PDO::FETCH_OBJ);
        $msg = $msg->cause;
        return $msg;        
    }

    public static function getMessageAction($id){
        $db = new Database();
        $sql = 'SELECT action FROM message WHERE id = :id LIMIT 1';
        $request = $db->prepare($sql);
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();
        $msg = $request->fetch(PDO::FETCH_OBJ);
        $msg = $msg->action;
        return $msg;        
    }

}
?>