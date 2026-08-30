<?php

class DeliveryVehicle extends DeliveryVehicleBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDescriptionAndPlate() {
        return $this->description . ' - ' . $this->plate_number;
    }
}
