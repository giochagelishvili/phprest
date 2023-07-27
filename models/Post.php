<?php

class Post {
    // DB stuff
    private $conn;
    private $table = "posts";

    // Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Posts
    public function read() {
        // SQL
        $sql = "SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM " . $this->table . " p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);    
        
        $stmt->execute();
        
        return $stmt;
    }

    // Get Single Post
    public function read_single() {
        // SQL
        $sql = "SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM " . $this->table . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($sql);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->title = $row["title"];
        $this->body = $row["body"];
        $this->author = $row["author"];
        $this->category_id = $row["category_id"];
        $this->category_name = $row["category_name"];
    }
}