<?php
	abstract class DBObject {
		
        private $sql;
        public $arrayresult = array();



		public function __construct($sql) {
            $this->sql = $sql;
			$conn = $this->connect();
			$result = $conn->query($sql);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					array_push($this->arrayresult, $row);            
				}
			}
		}


		private function connect() {
			$servername = "localhost";
			$username = "neverwinteruser";
			$password = "isitgeeseorgooses";
			$dbname = "neverwinter";
			
			//Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			//Check connection
			if($conn->connect_error)
				die("Connection failed : " . $conn->connect_error);
			return $conn;
		}
        
        public function listNames() {
            $namelist = array();
            foreach($this->arrayresult as $result)
                array_push($namelist, $result["Name"]);
            sort($namelist);
            return $namelist;
        }
        
        public function javascriptFriendly($string) {
            return str_replace("'", "\\'", $string);
        }

}

?>