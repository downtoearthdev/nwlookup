<?php
    require "dbobject.php";
    require "mount.php";

    class MountFactory extends DBObject {

        public $colors = array("50"=>"rgba(0, 153, 51, 0.6)", "80"=>"rgba(0, 64, 255, 0.6)", "110"=>"rgba(153, 51, 255, 0.6)", "140"=>"rgba(255, 153, 51, 0.6)");

        public function __construct() {
            parent::__construct("SELECT * FROM Mounts");

        }
        
        public function getMount($name) {
             if(!empty($name)) {
                foreach($this->arrayresult as $mount) {
                    if(strcasecmp($mount["Name"], $name) == 0) {
                        return new Mount($mount["Name"], $mount["Speed"], $mount["Insignia"], $mount["Equip Power"],
                                        $mount["Combat Power"], $mount["Picture"]);
                    }
                }
            }
            return null;
        }
    }
?>