<?php

class SilverpopIntegration_XenForo_DataWriter_User extends XFCP_SilverpopIntegration_XenForo_DataWriter_User {

    /**
    * Gets the fields that are defined for the table. See parent for explanation.
    *
    * @return array
    */
    protected function _getFields() {
        $fields = parent::_getFields();
        $fields['xf_user_option']['silverpopintegration_subscription'] = array('type' => self::TYPE_BOOLEAN, 'default' => 1);

        //Zend_Debug::dump($fields);

        return $fields;
    }

    protected function _preSave() {

        return parent::_preSave();
    }

    protected function _postSave() {

        return parent::_postSave();
    }
}
