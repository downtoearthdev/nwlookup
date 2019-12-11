<?php
    require "dbobject.php";
    require "artifact.php";

    class ArtifactFactory extends DBObject {
        public $levels = array("Uncommon", "Rare", "Epic", "Legendary", "Mythic");
        public $colors = array("Uncommon"=>"rgba(0, 153, 51, 0.6)", "Rare"=>"rgba(0, 64, 255, 0.6)", "Epic"=>"rgba(153, 51, 255, 0.6)", "Legendary"=>"rgba(255, 153, 51, 0.6)", "Mythic"=>"rgba(67, 244, 244, 0.6)");
        public $textsafecolors = array("Uncommon"=>"green", "Rare"=>"blue", "Epic"=>"purple", "Legendary"=>"orange", "Mythic"=>"aqua");
        public function __construct() {
            parent::__construct("SELECT * FROM Artifacts");


        }

        public function getArtifact($name, $level) {
            if(!empty($level) && !empty($name) && array_key_exists($level, $this->colors)) {
                foreach($this->arrayresult as $artifact) {
                    if(strcasecmp($artifact["Name"], $name) == 0) {
                        return  new Artifact($level, $artifact["Name"], $artifact[$level. " Stat"],
                                     $artifact[$level. " Use"], $artifact["Equipment Set"],
                                     $artifact["Set Bonus"], $artifact["Picture"],
                                     $artifact["Type"]);
                    }
                }
            }
            return null;
        }
        
        public function filterArtifacts(...$filters) {
            $resultartifacts = array();
            foreach($this->arrayresult as $artifact) {
                if(is_array($filters[0])) {
                    $required = count($filters[0]);
                    $met = array();
                    $metlevels = array();
                       for($x = 0; $x < $required; $x++) {
                           //var_dump($astat);
                           foreach($this->levels as $lvl) {
                            if(isset($artifact[$lvl." Stat"]) && strpos($artifact[$lvl." Stat"], $filters[0][$x]) !== false) {
                                if(!isset($met[$x]))
                                    $met[$x] = 1;
                                if(!in_array($lvl, $metlevels))
                                    array_push($metlevels, $lvl);
                                //$resultartifacts[$artifact["Name"]] = $resultartifacts[$artifact["Name"]].", ".$lvl;
                            }
                           }
                       }
                    if(count($met) == $required)
                        $resultartifacts[$artifact["Name"]] = implode(",", $metlevels);
                }
            }
            ksort($resultartifacts);
            return $resultartifacts;
        }
    }
?>          