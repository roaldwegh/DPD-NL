<?php namespace MCS;

use Exception;
use Soapclient;
use SoapFault;
use SOAPHeader;

class DPDAuthorisation{
 
    var $authorisation = [
        'staging' => false,
        'delisId' => null,
        'password' => null,
        'messageLanguage' => 'en_EN',
        'customerNumber' => null,
        'token' => null
    ];

    const TEST_LOGIN_WSDL = 'https://public-ws-stage.dpd.com/services/LoginService/V2_0/?wsdl';
    const LOGIN_WSDL = 'https://public-ws.dpd.com/services/LoginService/V2_0?wsdl';

    /**
     * Get an authorisationtoken from the DPD webservice
     * @param array $array
     */
    public function __construct($array)
    {
        $this->authorisation = array_merge($this->authorisation, $array);
        $this->environment = [
            'wsdlCache' => ( $this->authorisation['staging'] ? false : false ),
            'loginWsdl' => ( $this->authorisation['staging'] ? self::TEST_LOGIN_WSDL : self::LOGIN_WSDL),
        ];

        try{

            if ($this->environment['wsdlCache']){
                $client = new Soapclient($this->environment['loginWsdl'], [
                    'cache_wsdl' => WSDL_CACHE_BOTH,
                    'exceptions' => true
                ]);    
            } else {
                $client = new Soapclient($this->environment['loginWsdl'], [
                    'exceptions' => true
                ]);    
            }

            $auth = $client->getAuth([
                'delisId' => $this->authorisation['delisId'],
                'password' => $this->authorisation['password'],
                'messageLanguage' => $this->authorisation['messageLanguage'],
            ]);

            $auth->return->messageLanguage = $this->authorisation['messageLanguage'];
            $this->authorisation['token'] = $auth->return;
            $return = $this->authorisation;

        }
        catch (SoapFault $e)
        {
         throw new Exception($e->detail->authenticationFault->errorMessage);   
        } 
    }
        
}