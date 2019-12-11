<?php
    class Artifact implements JsonSerializable {
        private $name, $level, $stat, $uses, $set, $bonuses, $picture, $type;

        public function __construct($level, $name, $stat, $uses, $set, $bonuses, $picture, $type) {
            $this->name = $name;
            $this->level = $level;
            $this->stat = $stat;
            $this->uses = $uses;
            $this->set = $set;
            $this->bonuses = $bonuses;
            $this->picture = ($picture == null) ? "img/coming-soon-icon.png" : "data:image/png;base64, ".base64_encode($picture);
            $this->type = $type;
        }

        public function getName() {
            return $this->name;
        }

        public function getLevel() {
            return $this->level;
        }


        public function getStat() {
            return $this->stat;
        }

        public function getUses() {
            return $this->uses;
        }

        public function getSet() {
            return $this->set;
        }

        public function getBonuses() {
            return $this->bonuses;
        }

        public function getPicture() {
            return $this->picture;
        }

        public function getType() {
            return $this->type;
        }
        
        public function jsonSerialize() {
            return [
                'name' => $this->name,
                'level' => $this->level,
                'stat' => $this->stat,
                'uses' => $this->uses,
                'set' => $this->set,
                'bonuses' => $this->bonuses,
                'picture' => $this->picture,
                'type' => $this->type
            ];
        }
        

    }