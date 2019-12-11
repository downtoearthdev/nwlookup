<?php
    require "insigniafactory.php";

    class Mount implements JsonSerializable {
        private $name, $speed, $insignia, $equip, $combat, $picture, $possiblebonuses, $type;

        public function __construct($name, $speed, $insignia, $equip, $combat, $picture, $type) {
            $this->name = $name;
            $this->speed = $speed;
            $this->insignia = $insignia;
            $this->equip = $equip;
            $this->combat = $combat;
            $this->picture = ($picture == null) ? "img/coming-soon-icon.png" : "data:image/png;base64, ".base64_encode($picture);
            $this->possiblebonuses = (new InsigniaFactory())->getBonuses($insignia);
            $this->type = $type;
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
        
        public function getPossibleBonuses() {
            return $this->possiblebonuses;
        }
        
        public function getType() {
            return $this->type;
        }

         public function jsonSerialize() {
            return [
                'name' => $this->name,
                'speed' => intval($this->speed),
                'insignia' => $this->insignia,
                'equip' => $this->equip,
                'combat' => $this->combat,
                'type' => $this->type,
                'picture' => $this->picture,
                'possiblebonuses' => $this->possiblebonuses
            ];
        }
    }
?>