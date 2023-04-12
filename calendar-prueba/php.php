<?php
require_once '../assets/resources/google-api-php-client-2.2.1/vendor/autoload.php';


define('APPLICATION_NAME', 'Calendar');
//define('CREDENTIALS_PATH', 'calendar-php-quickstart.json');
define('CREDENTIALS_PATH', 'token.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR)
));

/*if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}*/

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
//var_dump($client);exit;
$service = new Google_Service_Calendar($client);

$event = new Google_Service_Calendar_Event(array(
  'summary' => 'Vacaciones',
  'location' => 'Puno, Perú',
  'description' => 'Buena oportunidad.',
  'start' => array(
    'dateTime' => '2018-01-15T09:00:00-07:00',
    'timeZone' => 'America/Los_Angeles',
  ),
  'end' => array(
    'dateTime' => '2018-01-20T17:00:00-07:00',
    'timeZone' => 'America/Los_Angeles',
  ),
  'recurrence' => array(
    'RRULE:FREQ=DAILY;COUNT=2'
  ),
  'attendees' => array(
    array('email' => 'froyc@msn.com'),
    array('email' => 'froyquis@yahoo.com'),
  ),
  'reminders' => array(
    'useDefault' => FALSE,
    'overrides' => array(
      array('method' => 'email', 'minutes' => 24 * 60),
      array('method' => 'popup', 'minutes' => 10),
    ),
  ),
));



$event2 = new Google_Service_Calendar_Event(array(
      'summary' => 'Event One',
      'location' => 'Some Location',
      'description' => 'Google API Test Event',
      'start' => array(
        'dateTime' => '2016-11-14T10:00:00-07:00'   
      ),
      'end' => array(
        'dateTime' => '2016-11-14T10:25:00-07:00'
      ),  
      'reminders' => array(
        'useDefault' => FALSE,
        'overrides' => array(
          array('method' => 'email', 'minutes' => 24 * 60),
          array('method' => 'popup', 'minutes' => 10),
        ),
      ),
    ));


$calendarId = 'ifroy.90@gmail.com';
$resultado = $service->events->insert($calendarId, $event2);
//printf('Event created: %s\n', $event->htmlLink);
// Print the next 10 events on the user's calendar.
/*$calendarId = 'ifroy.90@gmail.com';
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);

if (count($results->getItems()) == 0) {
  print "No upcoming events found.\n";
} else {
  print "Upcoming events:\n";
  foreach ($results->getItems() as $event) {
    $start = $event->start->dateTime;
    if (empty($start)) {
      $start = $event->start->date;
    }
    printf("%s (%s)\n", $event->getSummary(), $start);
  }
}*/