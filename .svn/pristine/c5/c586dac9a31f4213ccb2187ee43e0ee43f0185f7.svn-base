<?php

class EmployeeComponent extends CComponent {

    public $header;
    public $detailRelationships;
    public $detailEducations;
    public $detailExperiences;

    public function __construct($header, array $detailRelationships, array $detailEducations, array $detailExperiences) {
        $this->header = $header;
        $this->detailRelationships = $detailRelationships;
        $this->detailEducations = $detailEducations;
        $this->detailExperiences = $detailExperiences;
    }

    public function addDetailRelationship() {
        $this->detailRelationships[] = new EmployeeFamilyRelationship();
    }

    public function addDetailEducation() {
        $this->detailEducations[] = new EmployeeFormalEducation();
    }

    public function addDetailExperience() {
        $this->detailExperiences[] = new EmployeeJobExperience();
    }

    public function removeDetailRelationshipAt($index) {
        array_splice($this->detailRelationships, $index, 1);
    }

    public function removeDetailEducationAt($index) {
        array_splice($this->detailEducations, $index, 1);
    }

    public function removeDetailExperienceAt($index) {
        array_splice($this->detailExperiences, $index, 1);
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate();
            if ($valid) {
                $valid = $valid && $this->flush();
                if ($valid)
                    $dbTransaction->commit();
                else {
                    $dbTransaction->rollback();
                }
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');

        if (count($this->detailRelationships) > 0) {
            foreach ($this->detailRelationships as $detail) {
                $fields = array('name', 'relationship');
                $valid = $valid && $detail->validate($fields);
                if (!$valid)
                    $this->header->addError('error', 'Detail Relationships Error');
            }
        }

        if (count($this->detailEducations) > 0) {
            foreach ($this->detailEducations as $detail) {
                $fields = array('educational_background', 'major');
                $valid = $valid && $detail->validate($fields);
                if (!$valid)
                    $this->header->addError('error', 'Detail Educations Error');
            }
        }

        if (count($this->detailExperiences) > 0) {
            foreach ($this->detailExperiences as $detail) {
                $fields = array('company_name', 'position');
                $valid = $valid && $detail->validate($fields);
                if (!$valid)
                    $this->header->addError('error', 'Detail Experiences Error');
            }
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);

        foreach ($this->detailRelationships as $detail) {
            if ($detail->isNewRecord) {
                $detail->employee_id = $this->header->id;
                $valid = $valid && $detail->save(false);
            } else {
                if ($detail->is_inactive == 1) {
                    $detail->delete();
                    continue;
                }
                else
                    $valid = $valid && $detail->save(false);
            }
        }

        foreach ($this->detailEducations as $detail) {
            if ($detail->isNewRecord) {
                $detail->employee_id = $this->header->id;
                $valid = $valid && $detail->save(false);
            } else {
                if ($detail->is_inactive == 1) {
                    $detail->delete();
                    continue;
                }
                else
                    $valid = $valid && $detail->save(false);
            }
        }

        foreach ($this->detailExperiences as $detail) {
            if ($detail->isNewRecord) {
                $detail->employee_id = $this->header->id;
                $valid = $valid && $detail->save(false);
            } else {
                if ($detail->is_inactive == 1) {
                    $detail->delete();
                    continue;
                }
                else
                    $valid = $valid && $detail->save(false);
            }
        }

        return $valid;
    }

    public function delete($db) {
        $dbTransaction = $db->beginTransaction();
        try {
            $valid = TRUE;
            foreach ($this->detailRelationships as $detail) {
                $detail->is_inactive = 1;
                $valid = $valid && $detail->save();
            }

            foreach ($this->detailEducations as $detail) {
                $detail->is_inactive = 1;
                $valid = $valid && $detail->save();
            }

            foreach ($this->detailExperiences as $detail) {
                $detail->is_inactive = 1;
                $valid = $valid && $detail->save();
            }

            $this->header->is_inactive = 1;
            $valid = $valid && $this->header->save();

            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            Yii::app()->user->setFlash('message', $e->getMessage());
        }

        return $valid;
    }

}

