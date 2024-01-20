<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Saved</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" align="center">
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        include "../model/sqlserver_connection.php";
        require_once '../api/vendor/autoload.php';
        //Retrieve data from index.php
        $created = date('Y-m-d H:i:s');
        $to = $_POST['country-code'].$_POST['to'];
        $message = $_POST['message'];
        //Create an array for send data by sqlquery
        $params = array($created,$to,$message);
        $sqlquerymessage = 'INSERT INTO dbo.message ("created","to","message") VALUES (?,?,?)';
        $statement = sqlsrv_query($conn,$sqlquerymessage,$params);
        if( $statement === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        //Retrieve the last id from "message" table for to be stored on "sent" table
        $sqlquery_lastid = 'SELECT TOP 1 id FROM dbo.message ORDER BY id DESC';
        $row = sqlsrv_fetch_array(sqlsrv_query($conn,$sqlquery_lastid),SQLSRV_FETCH_ASSOC);

        //Twilio section
        use Twilio\Rest\Client;
        
        // Find your Account SID and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        
        $message = $twilio->messages
                        ->create("$to", // to
                                [
                                    "body" => "$message",
                                    "from" => "+15034616104"
                                ]
                        );
        
        //print($message->sid);
        
        //Insert the field into sent table.
        $sqlquerymessagesent = 'INSERT INTO dbo.sent ("sent","message_id", "twilio_confirmation") VALUES (?,?,?)';
        $params_sent = array($created,$row['id'],$message->sid);
        $statement2 = sqlsrv_query($conn,$sqlquerymessagesent,$params_sent);
        if( $statement2 === false ) {
            die( print_r( sqlsrv_errors(), true));
        }else{
            echo '<div align="center" class="alert alert-success">Message sent successfully!</div>';
        }

        ?>
        <a href="../index.php">Back to start</a>
    </div>    
</body>
</html>