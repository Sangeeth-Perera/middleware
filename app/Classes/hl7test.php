
<?php
require_once "Net/HL7/Segments/MSH.php";
require_once "Net/HL7/Message.php";
require_once "Net/HL7/Connection.php";
require_once "Net/HL7/Socket.php";

$msg  = new Net_HL7_Message();
$msg->addSegment(new Net_HL7_Segments_MSH());

$seg1 = new Net_HL7_Segment("PID");
$seg2 = new Net_HL7_Segment("NKI");
$seg3 = new Net_HL7_Segment("NK2");

$seg1->setField(3, "XXX");
$seg1->setField(1, "sanga");
$seg1->setField(2, "test");
$seg1->setField(2, "female");
$seg1->setField(5, "male");
$seg1->setField(6, "test");
$seg2->setField(3, "XXX");
$seg2->setField(5, "XXX");
$seg2->setField(8, "XXX");

$msg->addSegment($seg1);
$msg->addSegment($seg2);
$msg->addSegment($seg3);
$msg1="hello";
echo "Trying to connect";
//*$socket = new Net_Socket();
//$success = $socket->connect("127.0.0.1",5000);
////////////////////////////////
/*$socket0 = fsockopen("localhost", "5000", $errno, $errstr); 

    $cmd=$_SERVER['QUERY_STRING']; 

    if($socket0) 
{ 
    echo "Connected. <br /><br />"; 

    socket_write($socket0, $msg1, strlen($msg1)) or die("Could not send data to server\n");
// get server response 
     $result = socket_read ($socket0, 1024000) or die("Could not read server response\n");
} */

//////
$host    = "127.0.0.1";
$port    = 5000;


$msgs=$msg->toString(true);

// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die ("Could not connect to server\n");
// send string to server
socket_write($socket, $msgs, strlen($msgs)) or die("Could not send data to server\n");
// get server response
$result = socket_read ($socket, 1024000) or die("Could not read server response\n");
echo "Server  says :".$result;
// close socket
socket_close($socket);
/*
if ($success instanceof PEAR_Error) {
    echo "Error: {$success->getMessage()}";
    exit(-1);
}*/
//////////////////////////////////////////////////////////////////////
         $url = "http://wamis.co.nf/html/xmlfile.php";

        $post_data = array('xml' => $msg);
        $stream_options = array(
        'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded' . "\r\n",
        'content' =>  http_build_query($post_data)));

        $context  = stream_context_create($stream_options);
        $response = file_get_contents($url, null, $context);


//////////////////////////////////////////////////////////////////

/*
$conn = new Net_HL7_Connection($socket);

echo "Sending message\n" . $msg->toString(true);

$resp = $conn->send($msg);

$resp || exit(-1);

echo "Received answer\n" . $resp->toString(true);

$conn->close();
*/
?>