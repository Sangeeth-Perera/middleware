<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\patientAdmit;

use App\patientRegister;
use App\messageHistory;
use App\Classes\HL7\Segments\Net_HL7_Segments_MSH;
use App\Classes\HL7\Segments\Net_HL7_Segments_MSH2;
use App\Classes\HL7\Net_HL7_Message;
use App\Classes\HL7\Net_HL7_Segment;

require public_path().'\Net\HL7\Segments\MSH.php';
require public_path().'\Net\HL7\Message.php';



class PatientDischargeController extends Controller
{
    //
    public function count()
    {
        $admitted = patientAdmit::all();

         foreach ($admitted as $msg) 
        {
            $dischargeDate=$msg->dischargeDate;
          if($dischargeDate!=NULL)
          $msgs[]=$msg;
        }


        return view('patientDischarge', compact('msgs'));
    }


    public function generateA03($id)
    {
       $msg = patientAdmit::findOrFail($id);
         $name=$msg->name;
         $nic=$msg->nic;
         $village=$msg->village;
         $dob=$msg->dob;
         $gender=$msg->gender;
         $contactNumber=$msg->contactNumber;
         $civilStatus=$msg->civilStatus;
         $gender=$gender[0]; 
         $name = str_replace(' ', '^', $name);
         //admit information and observation
         $ward=$msg->ward;
         $doctor=$msg->doctor;
         $remarks=$msg->remarks;
         $admissionDate=$msg->admissionDate;
         $dischargeDate=$msg->dischargeDate;
         $dischargeICD_Code=$msg->dischargeICD_Code;
         $dischargeICD_Text=$msg->dischargeICD_Text;
         $dischargeIMMR_Code=$msg->dischargeIMMR_Code;
         $dischargeDoctor=$msg->dischargeDoctor;
         $dischargeOutcome=$msg->dischargeOutcome;
         $dischargeRemarks=$msg->dischargeRemarks;
         $complaint=$msg->complaint;
         $status=$msg->status;
         //encoding
         $complaint = str_replace(' ', '^', $complaint);
         $remarks = str_replace(' ', '^', $remarks);


         
         
        $msg  = new Net_HL7_Message();
        $msg->addSegment(new Net_HL7_Segments_MSH2());
        $t='hellow';
        $seg1 = new Net_HL7_Segment("PID");
        $seg2 = new Net_HL7_Segment("NK1");
        $seg3 = new Net_HL7_Segment("PV1");
        $seg4 = new Net_HL7_Segment("OBX");
        $seg5 = new Net_HL7_Segment("AL1");

        $seg1->setField(1, $nic);
        $seg1->setField(5, $name);
        $seg1->setField(7, $dob);
        $seg1->setField(8, $gender);
        $seg1->setField(11, $village);
        $seg1->setField(13, $contactNumber);
        $seg1->setField(16, $civilStatus);
        //$seg1->setField(27, "_");

        //segment3=PV1
        $seg3->setField(1, rand(1,9999));
        //$seg3->setField(3, $village);
        //$seg3->setField(7, $doctor);
        //$seg3->setField(8, $doctor);
        //$seg3->setField(9, $doctor);
        //$seg3->setField(10, "HHIMS".$ward);
        $seg3->setField(14, "HHIMS");
        $seg3->setField(17, $doctor);
        $seg3->setField(44, $admissionDate);
         $seg3->setField(45, $dischargeDate);

        //segment4=obervation
        $seg4->setField(1, rand(1,9999));
        $seg4->setField(11, $remarks);
        $seg4->setField(14, $admissionDate);
        $seg4->setField(15, $doctor);
        $seg4->setField(16, $doctor);
        //patient allergy information
         $seg5->setField(2, $complaint);
        $seg5->setField(4, $remarks);
        $seg5->setField(6, $admissionDate);
        
        
$msg->addSegment($seg1);
$msg->addSegment($seg2);
$msg->addSegment($seg3);
$msg->addSegment($seg4);
$msg->addSegment($seg5);

$date=time();
$msgs1=$msg->toString(true);
$filename=$date.'logs';
  $myfile = file_put_contents('msgs/A03'.$date.'logs.txt', $msgs1.PHP_EOL , FILE_APPEND | LOCK_EX);
 $url = "http://localhost/client/tcpA03.php?message={$id}&filename={$filename}";
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
        $status = patientAdmit::findOrFail($id);
        $msgStatus=$status->status;
        if($msgStatus=="recieved"){
             $status->delete();
        }
        else
        {
            return redirect('/patient/discharge')->withErrors(['Server Not Accepting', 'Server Not Accepting']);
        }
         $pt = new messageHistory;// object from model mesaage history team
      $myDate =time();// date nd time
      $pt->type="A03";
      //$pt=date();
      //Auth::user()->name;
      $pt->message=$msgs1;
      $pt->save();
         $msgs = patientRegister::all();
        return redirect('/patient/discharge')->withErrors(['Successfully sent', 'Server Not Accepting']);
    }
}


