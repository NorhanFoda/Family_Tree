<?php
    class Tree{
        private $conn;
        private $table_name = 'tree';

        public $id;
        public $name;
        public $birth_date;
        public $parent_id;
        public $type; // 1->grandFather, 2->father, 3->son

        public $son;
        public $father;
        public $grandFather;



        public function __construct($db){
            $this->conn = $db;
        }

        function create(){
            $query = 'INSERT INTO '.$this->table_name.' SET name=:name, birth_date=:birth_date, parent_id=:parent_id, type=:type';
            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->birth_date = htmlspecialchars(strip_tags($this->birth_date));
            $this->parent_id = htmlspecialchars(strip_tags($this->parent_id));
            $this->type = htmlspecialchars(strip_tags($this->type));

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':birth_date', $this->birth_date);
            $stmt->bindParam(':parent_id', $this->parent_id);
            $stmt->bindParam(':type', $this->type);

            if($stmt->execute()){
                return true;
            }

            return false;
        }

        function getPerson(){

            $query1 = 'SELECT type FROM '.$this->table_name.' WHERE id = ?';
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(1, $this->id);
            $stmt1->execute();
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $this->type = $row1['type'];

            if($this->type == 3){ // the person is son
                $query = 'SELECT a.name as son, b.name as father, c.name as grandFather
                            FROM '.$this->table_name.' a, '.$this->table_name.' b, '.$this->table_name.' c 
                            WHERE a.id = ? 
                            AND a.id <> b.id 
                            AND b.id <> c.id
                            AND a.parent_id = b.id
                            AND b.parent_id = c.id';
                $stmt = $this->conn->prepare( $query );
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->son = $row['son'];
                $this->father = $row['father'];
                $this->grandFather = $row['grandFather'];
            }
            else if($this->type == 2){ // the person is father
                $query = 'SELECT a.name as son, b.name as father, c.name as grandFather
                            FROM '.$this->table_name.' a, '.$this->table_name.' b, '.$this->table_name.' c 
                            WHERE b.id = ? 
                            AND b.id <> a.id 
                            AND a.id <> c.id
                            AND b.id = a.parent_id
                            AND b.parent_id = c.id';
                $stmt = $this->conn->prepare( $query );
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->son = $row['son'];
                $this->father = $row['father'];
                $this->grandFather = $row['grandFather'];
            }
            else{ // the person is grandFather
                $query = 'SELECT a.name as son, b.name as father, c.name as grandFather
                            FROM '.$this->table_name.' a, '.$this->table_name.' b, '.$this->table_name.' c 
                            WHERE c.id = ? 
                            AND c.id <> a.id 
                            AND a.id <> b.id
                            AND c.id = b.parent_id
                            AND b.id = a.parent_id';
                $stmt = $this->conn->prepare( $query );
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->son = $row['son'];
                $this->father = $row['father'];
                $this->grandFather = $row['grandFather'];
            }
        }

        function GetpersonsBetweenDates($date1, $date2){
            $query = 'SELECT * FROM '.$this->table_name.'
                        WHERE birth_date BETWEEN :date1 AND :date2';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':date1', $date1);
            $stmt->bindParam(':date2', $date2);
            $stmt->execute();
            return $stmt;
        }
    }
?>