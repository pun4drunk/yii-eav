<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EEavExtendedBehavior
 *
 * @author vladislav
 */
class EEavExtendedBehavior extends EEavBehavior {
    
    public function isUniqueValue($attribute, $value) {
        $count = $this->getCountSameEavAttributesCommand($attributes)->query();
        return !$count;
    }
    
    protected function getCountSameEavAttributesCommand($attributes) {
        return $this->getOwner()
            ->getCommandBuilder()
            ->createCountCommand($this->tableName, $this->getLoadSameEavAttributesCriteria($attributes));
    }
    
    protected function getLoadSameEavAttributesCriteria($attributes = array()) {
        $criteria = new CDbCriteria;
        $criteria->addCondition("{$this->entityField} <> {$this->getModelId()}");
        if (!empty($attributes)) {
            $criteria->addInCondition($this->attributeField, $attributes);
        }
        return $criteria;
    }
}
