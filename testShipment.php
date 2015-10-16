<?php

	require_once 'vendor/autoload.php';
	
    use MCS\DPDAuthorisation;
	use MCS\DPDShipment;
	
	try{
	       
        $authorisation = new DPDAuthorisation([
            'staging' => true,
            'delisId' => '<delisId>',
            'password' => '<password>',
            'messageLanguage' => 'en_EN',
            'customerNumber' => '<customerNumber>'
        ]);

        $shipment = new DPDShipment($authorisation);

        $shipment->setTrackingLanguage('nl_NL');
        $shipment->setSaturdayDelivery(true);   

        $shipment->setPredict([
            'channel' => 'email',
            'value' => 'someone@mail.com',
            'language' => 'EN'
        ]);

        $shipment->setGeneralShipmentData([
            'product' => 'CL',
            'mpsCustomerReferenceNumber1' => 'Test shipment'
        ]);

        $shipment->setPrintOptions([
            'printerLanguage' => 'PDF',
            'paperFormat' => 'A6',
        ]);     

        $shipment->setSender([
            'name1' => 'Your Company',
            'street' => 'Street 12',
            'country' => 'NL',
            'zipCode' => '1234AB',
            'city' => 'Amsterdam',
            'email' => 'contact@yourcompany.com',
            'phone' => '1234567645'
        ]);

        $shipment->setReceiver([
            'name1' => 'Joh Doe',         
            'name2' => null,       
            'street' => 'Street',       
            'houseNo' => '12',    
            'zipCode' => '1234AB',     
            'city' => 'Amsterdam',        
            'country' => 'NL',           
            'contact' => null,        
            'phone' => null,                 
            'email' => null,             
            'comment' => null 
        ]);

        $shipment->addParcel([
            'weight' => 3000, // In gram
            'height' => 10, // In centimeters
            'width' => 10,
            'length' => 10
        ]);
        
        $shipment->addParcel([
            'weight' => 5000, // In gram
            'height' => 20, // In centimeters
            'width' => 30,
            'length' => 20
        ]);

        $shipment->submit();

        $trackinglinks = $shipment->getParcelResponses();

        header('Content-Type: application/pdf');
        echo $shipment->getLabels();

	
	}catch(Exception $e){
		echo $e->getMessage();		
	}



