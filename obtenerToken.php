<?php

// define('OAUTH_CONSUMER_KEY','e681275a373fd27a4ba922a520804084cc4ef8da1c3aea7c79cfaacddb20727d');
// define('OAUTH_CONSUMER_SECRET','a6916f5900c037fb30137e7dd8db8775a532d6a355cf1b1bd1df5998dbb18e28');


// try {
//     $oauth = new OAuth(OAUTH_CONSUMER_KEY,OAUTH_CONSUMER_SECRET,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);

   
// $arrayResp = $oauth->getRequestToken("https://test-info_auto.gestion.online/oauth/token");

// } catch(OAuthException $E) {
// print_r($E);
// echo "Response: ". $E->lastResponse . "\n";
// }



$provider = new GenericProvider ([
    'clientId'                 => 'e681275a373fd27a4ba922a520804084cc4ef8da1c3aea7c79cfaacddb20727d' ,     // El ID de cliente que le asignó el proveedor 
   'clientSecret'             => 'a6916f5900c037fb30137e7dd8db8775a532d6a355cf1b1bd1df5998dbb18e28' ,    // La contraseña del cliente asignado por el proveedor 
   'urlAccessToken'           => 'https://test-info_auto.gestion.online/oauth/token'
]);

$accessToken=$provider->getAccessToken( 'autorización_código' , ['código' => $GET ['código']]);


?>

