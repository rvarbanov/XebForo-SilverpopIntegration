<?php

class SilverpopIntegration_Installer {
    public static function install() {
        $db = XenForo_Application::get('db');

        try {
            $db->query("ALTER TABLE xf_user_option ADD COLUMN silverpopintegration_subscription TINYINT(3) NOT NULL DEFAULT 1");
        } catch(Zend_Db_Exception $e) {}

        /*try {
            $db->query("ALTER TABLE xf_user_option
                CHANGE silverpopintegration_subscription silverpopintegration_subscription VARCHAR(100) NOT NULL DEFAULT 1");
        } catch(Zend_Db_Exception $e) {}*/
    }

    public static function uninstall() {
        $db = XenForo_Application::get('db');

        try {
            $db->query("ALTER TABLE xf_user_option DROP COLUMN silverpopintegration_subscription");
        } catch(Zend_Db_Exception $e) {}
    }
}
