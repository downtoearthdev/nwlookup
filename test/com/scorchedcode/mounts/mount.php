<?php

    class Mount implements JsonSerializable {
        private $name, $speed, $insignia, $equip, $combat, $picture;

        public function __construct($name, $speed, $insignia, $equip, $combat, $picture) {
            $this->name = $name;
            $this->speed = $speed;
            $this->insignia = $insignia;
            $this->equip = $equip;
            $this->combat = $combat;
            $this->picture = ($picture == null) ? "img/coming-soon-icon.png" : "data:image/png;base64, ".base64_encode($picture);
        }
        
        public function getName() {
            return $this->name;
        }
        
        public function getSpeed() {
            return $this->speed;
        }
        
        public function getInsignia() {
            return $this->insignia;
        }
        
        public function getEquip() {
            return $this->equip;
        }
        
        public function getCombat() {
            return $this->combat;
        }
        
        public function getPicture() {
            return $this->picture;
        }

         public function jsonSerialize() {
            return [
                'name' => $this->name,
                'speed' => intval($this->speed),
                'insignia' => $this->insignia,
                'equip' => $this->equip,
                'combat' => $this->combat,
                'picture' => $this->picture
            ];
        }
    }
?>