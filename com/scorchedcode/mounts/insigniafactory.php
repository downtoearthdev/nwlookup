<?php

    class InsigniaFactory extends DBObject {
        
        public function __construct() {
            parent::__construct("SELECT * FROM `Insignia Bonus Power`");


        }
        
        public function getBonus($bonus) {
            if(!empty($bonus)) {
                foreach($this->arrayresult as $detail) {
                    if(strcasecmp($detail["Name"], $bonus) == 0) {
                        return $detail["Bonus Description"];
                    }
                }
            }
        }

        public function getBonuses($insignias) {
            $possiblebonuses = "";
            //$splitinsignias = trim(str_replace("\r\n", ", ", $insignias));
            $splitinsignias = explode("\r\n", $insignias);
            foreach($this->arrayresult as $bonus) {
                $requiredinsignias = explode(", ", $bonus["Insignia Combination"]);
                $required = count($requiredinsignias);
                if($required == count($splitinsignias)) {
                    $met = 0;
                    $usedindices = array();
                    for($x = 0; $x < count($requiredinsignias); $x++) {
                         for($y = 0; $y < count($splitinsignias); $y++) {
                          if((($requiredinsignias[$x] == $splitinsignias[$y]) ||
                                  ($splitinsignias[$y] == "Universal")) && !in_array($y, $usedindices)) {
                                 $met++;
                                 $usedindices[] = $y;
                             }
                         }
                    }
                    if($met == $required)
                        $possiblebonuses.=$bonus["Name"]."\n";
                }
                /*if($bonus["Insignia Combination"] == $splitinsignias) {
                    $possiblebonuses.=$bonus["Name"]."\n";
                }*/
            }
            return $possiblebonuses;
        }
        
    }
?>