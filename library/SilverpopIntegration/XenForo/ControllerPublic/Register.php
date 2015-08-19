<?php

class SilverpopIntegration_XenForo_ControllerPublic_Register extends XFCP_SilverpopIntegration_XenForo_ControllerPublic_Register {

    public function _completeRegistration(array $user, array $extraParams = array()) {
        if(isset($errors)) {
            return parent::_completeRegistration($user);
        }

        $silverpop = new SilverpopIntegration_Core;

        $config = $silverpop->getConfig();

        $xf_user = array(
            'Email' => $user['email'],
            '_newswire_subscription' => 'Yes',
            'xf_user_id' => $user['user_id'],
            'xf_username' => $user['username']
        );

        $silverpop->addContact($config['DatabaseID'], $xf_user);

        return parent::_completeRegistration($user);
    }
}
