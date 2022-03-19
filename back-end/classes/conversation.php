<?php
class Conversation extends Database
{
    // properties
    private $room;
    private $idUserA;
    private $idUserB;
    // setters
    public function set_All($room, $idA, $idB)
    {
        $this->room = $room;
        $this->idUserA = $idA;
        $this->idUserB = $idB;
    }
    public function  __construct()
    {
        $this->table = "conversation";
    }
    // add new conversation 
    public function new_conversation()
    {
        $query = "INSERT INTO " . $this->table . "(room, idUserA, idUserB) VALUES (:room,:idUserA,:idUserB)";
        $prepared_convers = $this->connect()->prepare($query);
        $prepared_convers->bindParam(':room', $this->room);
        $prepared_convers->bindParam(':idUserA', $this->idUserA);
        $prepared_convers->bindParam(':idUserB', $this->idUserB);
        if ($prepared_convers->execute()) {
            return true;
        }
        return false;
    }
    //delete conversation 
    public function deleteConversation($room)
    {
        $query = "DELETE FROM " . $this->table . " WHERE room=?";
        $prepared_conversations = $this->connect()->prepare($query);
        if ($prepared_conversations->execute([$room])) {
            return true;
        }
        return false;
    }
    // get all user conversations from database
    public function getUserConversations($id)
    {
        $query = "SELECT c.*,u.photo as photoA,u1.photo as photoB,u.Phone as phoneA,u1.phone as phoneB,u.userName as UserNameA,u1.userName as UserNameB from conversation c join users u on c.idUserA=u.id join users u1 on u1.Id=c.idUserB where c.idUserA=" . $id . " or c.idUserB=" . $id . "";
        $prepared_conversations = $this->connect()->prepare($query);
        $prepared_conversations->execute([$id]);
        if ($prepared_conversations->rowCount()) {

            return $prepared_conversations->fetchAll();
        } else {
            return array();
        }
    }
    // get number of user conversations
    public function getCountConversations($id)
    {
        $query = "SELECT COUNT(*) as nbrConversations FROM " . $this->table . " WHERE idUserA=" . $id . " or idUserB=" . $id . "";
        $prepared_count = $this->connect()->prepare($query);
        $prepared_count->execute();
        if ($prepared_count->rowCount()) {

            return $prepared_count->fetch();
        } else {
            return array();
        }
    }
}
