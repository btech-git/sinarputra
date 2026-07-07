<?php

/**
 * @property integer $id
 * @property integer $receive_header_id
 * @property string $extension
 * @property string $filename
 * @property integer $is_inactive
 *
 * @property ReceiveHeader $receiveHeader
 */
class ReceiveImageBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_receive_image';
    }

    public function rules() {
        return array(
            array('receive_header_id, extension, filename', 'required'),
            array('receive_header_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('extension', 'length', 'max' => 5),
            array('filename', 'length', 'max' => 60),
            // The following rule is used by search().
            array('id, receive_header_id, extension, filename, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'receiveHeader' => array(self::BELONGS_TO, 'ReceiveHeader', 'receive_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'receive_header_id' => 'Receive Header',
            'extension' => 'Extension',
            'filename' => 'Filename',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.receive_header_id', $this->receive_header_id);
        $criteria->compare('t.extension', $this->extension, true);
        $criteria->compare('t.filename', $this->filename, true);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}