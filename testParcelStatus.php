<?php

	require_once 'vendor/autoload.php';
	
    use MCS\DPDAuthorisation;
	use MCS\DPDParcelStatus;
	
	try{
	       
        // Be aware that this functionality doesn't work with test credentials
        $authorisation = new DPDAuthorisation([
            'staging' => false,
            'delisId' => '<delisId>',
            'password' => '<password>',
            'messageLanguage' => 'en_EN',
            'customerNumber' => '<customerNumber>'
        ]);

        $status = new DPDParcelStatus($authorisation);

        $parcelStatus = $status->getStatus('12345678987654');
        
        echo '<pre>';
        print_r($parcelStatus);
        echo '</pre>';
	
	}catch(Exception $e){
		echo $e->getMessage();		
	}
	
	
	
	
