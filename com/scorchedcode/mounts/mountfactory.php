<?php
    require_once "dbobject.php";
    require "mount.php";

    class MountFactory extends DBObject {

        public $colors = array("50"=>"rgba(0, 153, 51, 0.6)", "80"=>"rgba(0, 64, 255, 0.6)", "110"=>"rgba(153, 51, 255, 0.6)", "140"=>"rgba(255, 153, 51, 0.6)");
        public $textsafecolors = array("50"=>"green", "80"=>"blue", "110"=>"purple", "140"=>"orange");

        public function __construct() {
            parent::__construct("SELECT * FROM Mounts");

        }

        public function getMount($name) {
             if(!empty($name)) {
                foreach($this->arrayresult as $mount) {
                    if(strcasecmp($mount["Name"], $name) == 0) {
                        return new Mount($mount["Name"], $mount["Speed"], $mount["Insignia"], $mount["Equip Power"],
                                        $mount["Combat Power"], $mount["Picture"], $mount["Mount Type"]);
                    }
                }
            }
            return null;
        }

        public function getMountsFromFilter($insigniabonus, $mounttype) {
            $mountlist = array();
            foreach($this->arrayresult as $mount) {
                if(!$mounttype) {
                    $possible = $this->getMount($mount["Name"])->getPossibleBonuses();
                    if(strpos($possible, trim($insigniabonus)) !== false) {
                        $mountlist[] = $mount["Name"]."\n";
                    }
                }
                else {
                    if(strpos($mount["Mount Type"], $mounttype) !== false) {
                        $mountlist[] = $mount["Name"]."\n";
                    }
                }

            }
            return $mountlist;
        }
    }
?>