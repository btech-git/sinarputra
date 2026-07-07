<?php

class ReceiveImage extends ReceiveImageBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getFullFilename() {
        return $this->id . '-' . $this->filename;
    }
}
