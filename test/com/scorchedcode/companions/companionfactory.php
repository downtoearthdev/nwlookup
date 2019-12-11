<?php
    require "dbobject.php";
    require "companion.php";

    class CompanionFactory extends DBObject {

        public $color = array("25"=>"green", "50"=>"blue", "75"=>"purple", "100"=>"orange");

        public function __construct() {
            parent::__construct("SELECT * FROM Companions");


        }

        public function getCompanion($name) {
            if(!empty($name)) {
                foreach($this->arrayresult as $companion) {
                    if(strcasecmp($companion["Name"], $name) == 0) {
                        return new Companion($companion["Name"], $companion["Item level"], $companion["Type"], $companion["Player Bonus Power"],
                                        $companion["Enhancement Power"], $companion["Bolster Class"],
                                        $companion["Picture"], $companion["Summoned Abilities"]);
                    }
                }
            }
            return null;
        }
        
        public function filterCompanions(...$filters) {
            $resultcompanions = array();
            foreach($this->arrayresult as $companion) {
                $required = 0;
                $met = 0;
                for($x = 0; $x < 4; $x++) {
                    if($x == 0 && $filters[$x] != "") {
                        $required++;
                        if(strpos($companion["Bolster Class"], $filters[$x]) !== false)
                            $met++;
                    }
                    if($x == 1 && $filters[$x] != "") {
                        $required++;
                        if(strpos($companion["Type"], $filters[$x]) !== false)
                            $met++;   
                    }
                    if($x == 2 && $filters[$x] != "") {
                        $required++;
                        if(strpos($companion["Enhancement Power"], $filters[$x].":") !== false)
                            $met++;
                    }                       
                    if($x == 3 && is_array($filters[$x])) {
                        $required++;
                        $submet = 0;
                       foreach($filters[$x] as $cstat) {
                           if(!(strpos($companion["Companion Stats"], $cstat) === false))
                               $submet++;
                       }
                        if($submet == count($filters[$x]))
                            $met++;
                    }
               }
                if($required == $met)
                    $resultcompanions[$companion["Name"]] = $companion["Item level"];
            }
            ksort($resultcompanions);
            return $resultcompanions;
        }
    }
// int multiply(int x, int y) {} becomes - function multiply(int $x, int $y) : int {}
?>