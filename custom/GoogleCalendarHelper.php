<?php
namespace app\custom;
class GoogleCalendarHelper {
    const APPLICATION_NAME = 'Codabr';
    //const CREDENTIALS_PATH = '~/.credentials/script-php-quickstart.json';
    const CREDENTIALS_PATH = __DIR__ . '/credentials/script-php-quickstart.json';
    const CLIENT_SECRET_PATH = __DIR__ . '/client_secret.json';
    const SCRIPT_ID = '1ar12SLE5WMH59-GmhMdqw91GBzaiSOrixFX0jIsXxQ6yZAqVetS-zMZD';
    
    public static function createEvent(array $params) {
        
        $client = self::getClient();
        $service = new \Google_Service_Script($client);
        
        $request = new \Google_Service_Script_ExecutionRequest();
        $request->setFunction('createEvent');
        $request->setParameters($params);
        try {
            // Make the API request.
            $response = $service->scripts->run(self::SCRIPT_ID, $request);

            if ($response->getError()) {
                // The API executed, but the script returned an error.

                // Extract the first (and only) set of error details. The values of this
                // object are the script's 'errorMessage' and 'errorType', and an array of
                // stack trace elements.
                $error = $response->getError()['details'][0];
                printf("Script error message: %s\n", $error['errorMessage']);

                if (array_key_exists('scriptStackTraceElements', $error)) {
                    // There may not be a stacktrace if the script didn't start executing.
                    print "Script error stacktrace:\n";
                    foreach($error['scriptStackTraceElements'] as $trace) {
                        printf("\t%s: %d\n", $trace['function'], $trace['lineNumber']);
                    }
                }
            } else {
                // The structure of the result will depend upon what the Apps Script
                // function returns. Here, the function returns an Apps Script Object
                // with String keys and values, and so the result is treated as a
                // PHP array (folderSet).
                $resp = $response->getResponse();
                return $resp['result'];
            }
        } catch (Exception $e) {
            // The API encountered a problem before the script started executing.
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    
    public static function deleteEventById($eventId) {
        
        $client = self::getClient();
        $service = new \Google_Service_Script($client);
        
        $request = new \Google_Service_Script_ExecutionRequest();
        $request->setFunction('deleteEventById');
        $request->setParameters($eventId);
        try {
            // Make the API request.
            $response = $service->scripts->run(self::SCRIPT_ID, $request);

            if ($response->getError()) {
                // The API executed, but the script returned an error.

                // Extract the first (and only) set of error details. The values of this
                // object are the script's 'errorMessage' and 'errorType', and an array of
                // stack trace elements.
                $error = $response->getError()['details'][0];
                printf("Script error message: %s\n", $error['errorMessage']);

                if (array_key_exists('scriptStackTraceElements', $error)) {
                    // There may not be a stacktrace if the script didn't start executing.
                    print "Script error stacktrace:\n";
                    foreach($error['scriptStackTraceElements'] as $trace) {
                        printf("\t%s: %d\n", $trace['function'], $trace['lineNumber']);
                    }
                }
            } else {
                // The structure of the result will depend upon what the Apps Script
                // function returns. Here, the function returns an Apps Script Object
                // with String keys and values, and so the result is treated as a
                // PHP array (folderSet).
                $resp = $response->getResponse();
                return $resp;
            }
        } catch (Exception $e) {
            // The API encountered a problem before the script started executing.
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    public static function callConsoleMethod($methodName, $params) {
        
        $client = self::getClient();
        $service = new \Google_Service_Script($client);
        
        $request = new \Google_Service_Script_ExecutionRequest();
        $request->setFunction($methodName);
        $request->setParameters($params);
        try {
            // Make the API request.
            $response = $service->scripts->run(self::SCRIPT_ID, $request);

            if ($response->getError()) {
                // The API executed, but the script returned an error.

                // Extract the first (and only) set of error details. The values of this
                // object are the script's 'errorMessage' and 'errorType', and an array of
                // stack trace elements.
                $error = $response->getError()['details'][0];
                printf("Script error message: %s\n", $error['errorMessage']);

                if (array_key_exists('scriptStackTraceElements', $error)) {
                    // There may not be a stacktrace if the script didn't start executing.
                    print "Script error stacktrace:\n";
                    foreach($error['scriptStackTraceElements'] as $trace) {
                        printf("\t%s: %d\n", $trace['function'], $trace['lineNumber']);
                    }
                }
            } else {
                // The structure of the result will depend upon what the Apps Script
                // function returns. Here, the function returns an Apps Script Object
                // with String keys and values, and so the result is treated as a
                // PHP array (folderSet).
                $resp = $response->getResponse();
                return $resp['result'];
            }
        } catch (Exception $e) {
            // The API encountered a problem before the script started executing.
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    
    
    public static function getClient() {
        // If modifying these scopes, delete your previously saved credentials
        // at ~/.credentials/script-php-quickstart.json
        $scopes = implode(' ', array(
          "https://www.google.com/calendar/feeds")
        );
        
        $client = new \Google_Client();
        $client->setApplicationName(self::APPLICATION_NAME);
        $client->setScopes($scopes);
        $client->setAuthConfig(self::CLIENT_SECRET_PATH);
        //$client->setAccessType('offline');

        // Load previously authorized credentials from a file.
        //$credentialsPath = self::expandHomeDirectory(self::CREDENTIALS_PATH);
        $credentialsPath = self::CREDENTIALS_PATH;
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            throw new \Exception('ошибка авторизации');
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
            print_r('-isAccessTokenExpired--');
        }
        return $client;
    }
        /**
     * Expands the home directory alias '~' to the full path.
     * @param string $path the path to expand.
     * @return string the expanded path.
     */
    public static function expandHomeDirectory($path) {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }
}