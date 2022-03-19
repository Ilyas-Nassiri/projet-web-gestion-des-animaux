<?php
class Message extends Database
{
    // properties
    private $message;
    private $date;
    private $idUser;
    private $room;
    //Setters
    public function Set_All($message, $date, $idUser, $room)
    {
        $this->message = $message;
        $this->date = $date;
        $this->idUser = $idUser;
        $this->room = $room;
    }

    public function __construct()
    {
        $this->table = "Message";
    }
    // add new message 
    public function new_Message()
    {
        $query = "INSERT INTO " . $this->table . "(message,date,idUser,room) VALUES (:message,:date,:idUser,:room)";
        $prepared_message = $this->connect()->prepare($query);
        $prepared_message->bindParam(":message", $this->message);
        $prepared_message->bindParam(":date", $this->date);
        $prepared_message->bindParam(":idUser", $this->idUser);
        $prepared_message->bindParam(":room", $this->room);
        if ($prepared_message->execute()) {
            return true;
        }
        return false;
    }
    // get all message conversation
    public function getMessagesConversation($room)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE room=? ";
        $prepared_messages = $this->connect()->prepare($query);
        $prepared_messages->execute([$room]);
        if ($prepared_messages->rowCount() > 0) {
            return $prepared_messages->fetchAll();
        } else {
            return array();
        }
    }
}
