<?php
    class Companion implements JsonSerializable {
        private $name, $level, $type, $bonus, $power, $bolster, $stats, $picture, $summonpower;

        public function __construct($name, $level, $type, $bonus, $power, $bolster, $picture, $summonpower) {
            $this->name = $name;
            $this->level = $level;
            $this->type = $type;
            $this->bonus = $bonus;
            $this->power = $power;
            $this->bolster = $bolster;
            $this->picture = ($picture == null) ? "img/coming-soon-icon.png" : "data:image/png;base64, ".base64_encode($picture);
            $this->summonpower = $summonpower;
        }

        public function getName() {
            return $this->name;
        }

        public function getLevel() {
            return $this->level;
        }

        public function getType() {
            return $this->type;
        }

        public function getBonus() {
            return $this->bonus;
        }

        public function getPower() {
            return $this->power;
        }

        public function getBolster() {
            return $this->bolster;
        }


        public function getPicture() {
            return $this->picture;
        }
        
        public function getSummonPower() {
            return $this->summonpower;
        }


        public function jsonSerialize() {
            return [
                'name' => $this->name,
                'level' => intval($this->level),
                'type' => $this->type,
                'bonus' => $this->bonus,
                'power' => $this->power,
                'bolster' => $this->bolster,
                'picture' => $this->picture,
                'summonpower' => $this->summonpower
            ];
        }
    }
?>