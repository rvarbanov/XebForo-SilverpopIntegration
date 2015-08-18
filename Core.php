<?php

$dir = dirname(__FILE__);
//require_once $dir . '/ThirdParties/SendyPHP.php';
//require_once $dir . '/Silverpop/EngagePod.php';
require_once 'vendor/autoload.php';

//use SendyPHP\SendyPHP;
//use Silverpop\EngagePod;
use SilverpopConnector\SilverpopConnector;

class SilverpopIntegration_Core {
    protected $config = array (
        'username'      => null,
        'password'      => null,
        'baseUrl'       => null,

        'DatabaseID'    => null,

        'client_id'     => null,
        'client_secret' => null,
        'refresh_token' => null
    );


    /**
     * @return SilverpopConnector
     */
    protected $silverpop;

    public function __construct(array $config = null) {
        if($config) {
            //$this->setConfig($config);
        }

        if(is_null($config)) {
            $this->getConfig();
        }
        $this->createConnection($this->config);
    }

    public function setConfig(array $config) {
        foreach ($this->config as $key => &$value) {
            if(isset($config[$key])) {
                $value = $config[$key];
                unset($config[$key]);
            }
        }
        unset($value);

        $this->config = array_merge($config, $this->config);
    }

    public function getConfig() {
        $config = array(
            'username'          => SilverpopIntegration_Option::get('UserName'),
            'password' 			=> SilverpopIntegration_Option::get('UserPassword'),
            'baseUrl'           => SilverpopIntegration_Option::get('EngageServer'),

            'DatabaseID'        => SilverpopIntegration_Option::get('DatabaseID'),

            'client_id'         => SilverpopIntegration_Option::get('ClientID'),
            'client_secret'     => SilverpopIntegration_Option::get('ClientSecret'),
            'refresh_token'     => SilverpopIntegration_Option::get('RefreshToken')
        );
        //var_dump($config);
        $this->config = $config;
        return $this->config;
    }

    public function createConnection($config) {
        /*$config = array(
            'username'          => SilverpopIntegration_Option::get('UserName'),
            'password' 			=> SilverpopIntegration_Option::get('UserPassword'),
            'baseUrl'           => SilverpopIntegration_Option::get('EngageServer'),

            'DatabaseID'        => SilverpopIntegration_Option::get('DatabaseID'),

            'client_id'         => SilverpopIntegration_Option::get('ClientID'),
            'client_secret'     => SilverpopIntegration_Option::get('ClientSecret'),
            'refresh_token'     => SilverpopIntegration_Option::get('RefreshToken')
        );*/

        // Setting base URL...
        SilverpopConnector::getInstance($config['baseUrl']);
        // Authenticating to REST API...

        $access_token = false;
        //$access_token = Cache::read('access_token', 'silverpop');
        // If Silverpop Access Token has expired get a new one
        if($access_token === false) {
            //SilverpopConnector::getInstance()->authenticateXml($config['username'], $config['password']);
            SilverpopConnector::getInstance()->authenticateRest($config['client_id'], $config['client_secret'], $config['refresh_token']);
            //$silverpopRestInstance = SilverpopRestConnector::getInstance();
            //$access_token = SilverpopRestConnector::getInstance()->getAccessToken();
            //Cache::write('access_token', $access_token, 'silverpop');
        } else {
            SilverpopRestConnector::getInstance()->setAccessToken($access_token);
        }
    }

    // Creating a new SilverPop contact... Update if email already exist
    public function addContact($databaseID, $xf_user) {
        $recipientId = SilverpopConnector::getInstance()->addRecipient($databaseID, $xf_user, true);
        //return $recipientId;
    }

    // Updating a SilverPop contact...
    public function updateContact($user, $recipientId, $oldEmail) {
        $optParams = array('OLD_EMAIL' => $oldEmail);

        $this->createConnection();
        $updatedContact = array(
            'Email'                     => $user['User']['email'],
            '_newswire_subscription'    => ($user['User']['email_notify_for_site']?'Yes':'No'),
            '_user_id'                  => $user['User']['id'],
            'first_name'                => $this->prepareForXml($user['User']['first_name']),
            'last_name'                 => $this->prepareForXml($user['User']['last_name'])
        );
        SilverpopConnector::getInstance()->updateRecipient(SILVERPOP_CTV_DB, $recipientId, $updatedContact, $optParams);
    }
}
