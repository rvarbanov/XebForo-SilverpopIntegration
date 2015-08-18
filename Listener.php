<?php

class SilverpopIntegration_Listener {
	/**
	 *
	 * @var XenForo_ControllerRegister_Register::actionRegister
	 */
	public static $register;

	public static function loadControllers($class, array &$extend) {
		static $controllers = array(
			'XenForo_ControllerPublic_Account',
			//'XenForo_ControllerPublic_Register',

			//'XenForo_ControllerAdmin_Tools',
			//'XenForo_ControllerAdmin_Option',

			//'XenForo_Model_User',

			'XenForo_DataWriter_User'
		);

		if(in_array($class, $controllers)) {
			$extend[] = 'SilverpopIntegration_' . $class;
		}
	}
}
