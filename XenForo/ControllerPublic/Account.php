<?php

class SilverpopIntegration_XenForo_ControllerPublic_Account extends XFCP_SilverpopIntegration_XenForo_ControllerPublic_Account {
    public function actionEmailPreferences() {
        $visitor = XenForo_Visitor::getInstance();

        if (!$visitor->canEditProfile()) {
            return $this->responseNoPermission();
        }

        $viewParams = array(
            'silverpopintegration_subscription' => $visitor['silverpopintegration_subscription']
        );
        //Zend_Debug::dump($visitor);

        return $this->_getWrapper(
            'account', 'emailPreferences',
            $this->responseView(
                'SilverpopIntegration_ViewPublic_Account_EmailPreferences',
                'silverpopintegration_account_email_preferences',
                $viewParams
            )
        );
    }

    public function actionEmailPreferencesSave() {
        $this->_assertPostOnly();

        $visitor = XenForo_Visitor::getInstance();

        if (!$visitor->canEditProfile()) {
            return $this->responseNoPermission();
        }

        $settings = $this->_input->filter(array(
            //user_option
            'silverpopintegration_subscription' => XenForo_Input::UINT
        ));

        $writer = XenForo_DataWriter::create('XenForo_DataWriter_User');
        $writer->setExistingData(XenForo_Visitor::getUserId());
        $writer->bulkSet($settings);
        //Zend_Debug::dump($writer);

        if ($dwErrors = $writer->getErrors()) {
            return $this->responseError($dwErrors);
        }

        $writer->save();



        $silverpop = new SilverpopIntegration_Core;

        $config = $silverpop->getConfig();

        $xf_user = array(
            'Email' => $visitor['email'],
            '_newswire_subscription' => $settings['silverpopintegration_subscription']?'Yes':'No',
            'xf_user_id' => $visitor['user_id'],
            'xf_username' => $visitor['username']
        );

        $silverpop->addContact($config['DatabaseID'], $xf_user);




        return $this->responseRedirect(
            XenForo_ControllerResponse_Redirect::SUCCESS,
            $this->getDynamicRedirect(XenForo_Link::buildPublicLink('account/email-preferences'))
        );

    }
}
