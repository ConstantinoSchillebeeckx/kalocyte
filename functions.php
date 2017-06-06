<?php

function meow() {

    //  Initiate curl
    $ch = curl_init();

    // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set accept type
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

    // Set API key
    $key = "hyYZ2KK1J0JDN0u1BaKtVaIi7Y3w10te";
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('apiKey: ' . $key));

    // Set the url
    $url = "https://community.researchspace.com/api/v1/documents?pageSize=20&orderBy=lastModified%20desc";
    curl_setopt($ch, CURLOPT_URL,$url);

    // Execute
    $result=curl_exec($ch);

    // Closing
    curl_close($ch);

    return $result;


}


?>
