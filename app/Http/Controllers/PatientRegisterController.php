<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\patientRegister;
use App\messageHistory;
use App\Classes\HL7\Segments\Net_HL7_Segments_MSH;
use App\Classes\HL7\Segments\Net_HL7_Segments_MSH1;
use App\Classes\HL7\Net_HL7_Message;
use App\Classes\HL7\Net_HL7_Segment;
//use Net\HL7\Connection.php;
//use Net\HL7\Socket.php;
//File::requireOnce(Net/HL7/Segments/MSH.php);
//File::requireOnce("Net/HL7/Message.php");
//File::requireOnce("Net/HL7/Connection.php");
//File::requireOnce("Net/HL7/Socket.php");
require public_path().'\Net\HL7\Segments\MSH.php';
//require public_path().'\Net\HL7\Segments\MSH.php';
require public_path().'\Net\HL7\Message.php';
//require public__path().'\Net\HL7\Message.php';
//require_once "Net/HL7/Segments/MSH.php";
//require_once "Net/HL7/Message.php";
//require_once "Net/HL7/Connection.php";
//require_once "Net/HL7/Socket.php";


class PatientRegisterController extends Controller
{
    //
    public function count()
    {
        $msgs = patientRegister::all();

        return view('patientRegistrations', compact('msgs'));
    }
    public function generateA01()
    {
        $msgs = patientRegister::all();
        $length = count($msgs);
        
        $i=0;
        
        //echo"<xmp>".$xml->saveXML()."</xmp>";

        foreach ($msgs as $msg){
            $this->test($msg);  
    }
        return view('patientRegistrations', compact('msgs'));
    }

    public function generateAA01($id)
    {
        $host    = "127.0.0.1";
        $port    = 5000;

         $msg = patientRegister::findOrFail($id);
         $name=$msg->Name;
         $nic=$msg->NIC;
         $village=$msg->village;
         $dob=$msg->DOB;
         $gender=$msg->Gender;
         $contactNumber=$msg->contactNumber;
         $civilStatus=$msg->civilStatus;
         $gender=$gender[0]; 
         $name = str_replace(' ', '^', $name);
         /*
         $xml=new \DOMDocument("1.0");
         $xml->formatOutput="true";
         $xml->formatOutput="true";
         $patients=$xml->createElement("patientInformation");
         $xml->appendChild($patients);
         $NIC=$xml->createElement("NIC",$msg->NIC);
         $patients->appendChild($NIC);
         $Name=$xml->createElement("Name",$msg->Name);
         $patients->appendChild($Name);
         $village=$xml->createElement("village",$msg->village);
         $patients->appendChild($village);
         $Gender=$xml->createElement("Gender",$msg->Gender);
         $patients->appendChild($Gender);
         $xml->save("hl7Messages/A01/message".$msg->NIC.".xml");
         //$msg->delete();
          $xml_str ="hl7Messages/A01/message".$msg->NIC.".xml";
          $xmltest=simplexml_load_file("hl7Messages/A01/message".$msg->NIC.".xml");//reading the xml file
          $tst[]="sanga";
          $test="onella";
         $url = "http://wamis.co.nf/html/xmlfile.php";

      */
        //////////////////////////////////////////////////////commented above
        $msg  = new Net_HL7_Message();
        $msg->addSegment(new Net_HL7_Segments_MSH1());
        $t='hellow';
        $seg1 = new Net_HL7_Segment("PID");
        $seg2 = new Net_HL7_Segment("NKI");
        $seg3 = new Net_HL7_Segment("NK2");

        $seg1->setField(1, $nic);
        $seg1->setField(5, $name);
        $seg1->setField(7, $dob);
        $seg1->setField(8, $gender);
        $seg1->setField(11, $village);
        $seg1->setField(13, $contactNumber);
        $seg1->setField(16, $civilStatus);
        $seg1->setField(27, "_");

        
$msg->addSegment($seg1);
$msg->addSegment($seg2);
$msg->addSegment($seg3);


$msgs1=$msg->toString(true);
 $url = "http://localhost/tcp1.php?message={$id}";
//$post_data = array('xml' => $msgs1);
       $arr1 = str_split($msgs1);
        $stream_options = array(
        'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded' . "\r\n",
        'content' =>  http_build_query($arr1)));

        $context  = stream_context_create($stream_options);
        $response = file_get_contents($url, null, $context);

//testing status wethor message ecived or not
        $status = patientRegister::findOrFail($id);
        $msgStatus=$status->status;
        if($msgStatus=="recieved"){
             $status->delete();
        }
        else
        {
            return redirect('/patient')->withErrors(['Server Not Accepting', 'Server Not Accepting']);
        }
      
      $pt = new messageHistory;// object from model mesaage history team
      $myDate =time();// date nd time
      $pt->type="A04";
      //$pt=date();
      //Auth::user()->name;
      $pt->message=$msgs1;
      $pt->save();
         $msgs = patientRegister::all();
        return redirect('/patient')->withErrors(['Successfully sent', 'Server Not Accepting']);
        //return view('patientRegistrations', compact('msgs','arr1'));
    }

    public function test($msg){
        $xml=new \DOMDocument("1.0");
        $xml->formatOutput="true";
        $xml->formatOutput="true";
        $patients=$xml->createElement("patientInformation");
         $xml->appendChild($patients);
         $NIC=$xml->createElement("NIC",$msg->NIC);
         $patients->appendChild($NIC);
         $Name=$xml->createElement("Name",$msg->Name);
         $patients->appendChild($Name);
         $village=$xml->createElement("village",$msg->village);
         $patients->appendChild($village);
         $Gender=$xml->createElement("village",$msg->Gender);
         $patients->appendChild($Gender);
         $xml->save("hl7Messages/A01/message".$msg->NIC.".xml");
    }
          
            
}
