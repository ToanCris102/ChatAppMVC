<?php
    class DB{
        public $conn;
        private $hostname = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "chatapp";

        public function connectionDB(){
            $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
            $this->conn->set_charset("urf8");
            if($this->conn->connect_errno > 0){
                die('Unable to connect to database [' . $this->conn->connect_error . ']');
            }
            return $this->conn;
        }
        
        public function executeResult($sql){
            $this->connectionDB();
            $resultSet = $this->conn->query($sql);
            $list = [];
            if($resultSet){                
                while ($row = mysqli_fetch_array($resultSet)) {
                    $list[] = $row;
                } 
                $this->conn->close();                
                return $list;
            }
            return $list;
        }

        public function execute($sql) {
            $this->connectionDB();
            $bool = $this->conn->query($sql);
            $this->conn->close();
            return $bool;
        }
    }
?>