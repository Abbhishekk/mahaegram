<?php
    class Connect {
        private $username = "root";
        private $password = "";
        private $host = "localhost";
        private $db = "mahaegram";
        public function dbConnect() {
            $conn = new mysqli($this->host, $this->username, $this->password, $this->db);
            return $conn;
        }
    }

?>