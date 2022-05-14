<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'development',
        'certificate' =>app_path().'/APNs_User_Certificates.pem',
        'passPhrase'  =>'omsairam',//'password',
        'service'     =>'apns'

    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>'yourAPIKey',
        'service'     =>'gcm'
    )

);

