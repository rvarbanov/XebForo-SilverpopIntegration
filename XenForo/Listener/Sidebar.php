<?php

class SilverpopIntegration_XenForo_Listener_Sidebar {

    public static function sidebarTemplateCreate(&$templateName, array &$params, XenForo_Template_Abstract $template) {
        if($templateName == 'account_wrapper') {
            $template->preloadTemplate('silverpopintegration_sidebar_email_preferences');
        }
    }

    public static function sidebarTemplateHook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
        switch($hookName) {
            case 'account_wrapper_sidebar_settings':
            case 'navigation_visitor_tab_links1':
                $contents .= $template->create('silverpopintegration_sidebar_email_preferences', $template->getParams());
                break;
        }
    }
}
