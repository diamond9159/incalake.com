<?php
//require_once '../assets/resources/google-api-test/vendor/autoload.php';
require_once '../assets/resources/google-api-php-client-2.2.1/vendor/autoload.php';

function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Calendario-reservas');
    //$client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
    $client->addScope("https://www.googleapis.com/auth/calendar");
    $client->addScope("https://www.googleapis.com/auth/calendar.events");
    $client->setAuthConfig('client_secret.json');
    $client->setAccessType('offline');
    //$client->setPrompt('select_account consent');
    
    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        echo("si");
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }else{
        echo("no");
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
             echo("no1111");
            // Request authorization from the user.
            //$authUrl = $client->createAuthUrl();
            //printf("Open the following link in your browser:\n%s\n", $authUrl);
            //print 'Enter verification code: ';
            $authCode = '4/qQHVauocSIeqLw7HsV1tVfp5LsrX01jxraW2Xrac_ejatxxc-uJRvmU';

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

$event2 = new Google_Service_Calendar_Event(array(
      'summary' => 'Event Two',
      'location' => 'Some Location',
      'description' => 'Google API Test Event',
      'start' => array(
        'dateTime' => '2019-08-25T10:00:00-07:00'   
      ),
      'end' => array(
        'dateTime' => '2019-08-26T10:25:00-07:00'
      ),  
      'reminders' => array(
        'useDefault' => FALSE,
        'overrides' => array(
          array('method' => 'email', 'minutes' => 24 * 60),
          array('method' => 'popup', 'minutes' => 10),
        ),
      ),
    ));


$calendarId = 'reservas@incalake.com';
$resultado = $service->events->insert($calendarId, $event2);

?>