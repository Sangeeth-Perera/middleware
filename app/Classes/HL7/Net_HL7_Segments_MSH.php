<?php

use App\Classes\Net_HL7;
use App\Classes\HL7\Net_HL7_Segment;


namespace App\Classes\HL7;
class Net_HL7_Segments_MSH extends Net_HL7_Segment {

    function __construct($fields = NULL, $hl7Globals = NULL)
    {
        parent::__construct("MSH", $fields);

        // Only fill default fields if no fields array is given
        //
        if (!isset($fields)) {

            if (!is_array($hl7Globals)) {
                $this->setField(1, '|');
                $this->setField(2, '^~\\&');
                $this->setField(7, strftime("%Y%m%d%H%M%S"));

                // Set ID field
                //
                $this->setField(10, $this->getField(7) . rand(10000, 99999));
                $this->setField(12, '2.2');
            }
            else {
                $this->setField(1, $hl7Globals['FIELD_SEPARATOR']);
                $this->setField(2,
                                $hl7Globals['COMPONENT_SEPARATOR'] .
                                $hl7Globals['REPETITION_SEPARATOR'] .
                                $hl7Globals['ESCAPE_CHARACTER'] .
                                $hl7Globals['SUBCOMPONENT_SEPARATOR']
                                );
                $this->setField(7, strftime("%Y%m%d%H%M%S"));

                // Set ID field
                //
                $this->setField(10, $this->getField(7) . rand(10000, 99999));
                $this->setField(12, $hl7Globals['HL7_VERSION']);
            }
        }
    }


    
    function setField($index, $value = '')
    {
        if ($index == 1) {
            if (strlen($value) != 1) {
                return false;
            }
        }

        if ($index == 2) {
            if (strlen($value) != 4) {
                return false;
            }
        }

        return parent::setField($index, $value);
    }

}

?>
