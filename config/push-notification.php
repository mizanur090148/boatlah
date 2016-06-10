<?php

return array(

    'developmentAndroidCaptain' => array(
        'environment' =>'development',
        'apiKey'      =>'AIzaSyC8iv8fvzSxlbvufR9mjtJV4r8g1RxPcsc',
        'service'     =>'gcm'
    ),
    'productionAndroidCaptain' => array(
        'environment' =>'production',
        'apiKey'      =>'AIzaSyC8iv8fvzSxlbvufR9mjtJV4r8g1RxPcsc',
        'service'     =>'gcm'
    ),
    'developmentAndroidConsumer' => array(
        'environment' =>'development',
        'apiKey'      =>'AIzaSyBo4g_DTwpyUXOH3DuycrFOabq9SiSW1sc',
        'service'     =>'gcm'
    ),
    'productionAndroidConsumer' => array(
        'environment' =>'production',
        'apiKey'      =>'AIzaSyBo4g_DTwpyUXOH3DuycrFOabq9SiSW1sc',
        'service'     =>'gcm'
    ),
    'developmentIosConsumer'     => array(
        'environment' =>'development',
        'certificate' => storage_path('/iOS/BoatlahiOSPushTestCert.pem'),
        'passPhrase'  =>'23456',
        'service'     =>'apns'
    ),
    'productionIosConsumer'     => array(
        'environment' =>'production',
        'certificate' => storage_path('/iOS/BoatlahiOSPushTestCert.pem'),
        'passPhrase'  =>'23456',
        'service'     =>'apns'
    ),

);