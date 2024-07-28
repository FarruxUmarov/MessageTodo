<?php

class Todo extends DB {

    public function setTodo(string $todoName){
        $status = false;
        $todoName = trim($todoName);
        $stmt = $this->pdo->prepare("INSERT INTO todos(text, status) VALUES(:text, :status)");
        $stmt->bindParam(':text', $todoName);
        $stmt->bindParam(':status', $status, PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function getTodo(){
        return $this->pdo->query("SELECT * FROM todos")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Delete($todoId){
        $todoId = trim($todoId);
        $this->pdo->query("DELETE FROM todos WHERE id={$todoId}");
    }

    public function Update($todoId){
        $todoId = trim($todoId);
        $todo = $this->pdo->query("SELECT * FROM todos WHERE id={$todoId}")->fetch(PDO::FETCH_ASSOC);
        if($todo['status']){
            $this->pdo->query("UPDATE todos SET status=0 WHERE id={$todoId}");
            return;
        }
        $this->pdo->query("UPDATE todos SET status=1 WHERE id={$todoId}");
    }

    public function saveAddTask(string $text) {
        $query = "INSERT INTO users (addtask) VALUES (:addtask)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':addtask', $text);
        $stmt->execute();
    }

    public function getAddTask() {
        $query = "SELECT addtask FROM users";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function sendAddTask(string $text) {
        $query = "INSERT INTO todos (text, status) VALUES (:text, :status)";
        $status = 0;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':status', $status);
        $stmt->execute();    
    }

    public function deleteAddTask() {
        $value = "add";

        $query = "DELETE FROM users WHERE addtask = :value";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
    }
    public function AllTodo() 
    {
        $query = "SELECT * FROM todos";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>

<!-- CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    addtask VARCHAR(32),
    gettask VARCHAR(32),
    checktask VARCHAR(32),
    unchecktask VARCHAR(32),
    deletetask VARCHAR(32),
    edittask VARCHAR(32)
); -->