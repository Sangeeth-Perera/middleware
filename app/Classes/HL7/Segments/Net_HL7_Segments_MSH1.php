<?php

use App\Classes\Net_HL7;
//use App\Classes\HL7\Net_HL7_Segment;

use App\Classes\HL7\Segments\Net_HL7_Segment;

namespace App\Classes\HL7\Segments;
class Net_HL7_Segment {

    var $_fields;

    
    function __construct($name, $fields = array())
    {
        // Is the name 3 upper case characters?
        //
        if ((!$name) || (strlen($name) != 3) || (strtoupper($name) != $name)) {
            throw new InvalidArgumentException("Name should be 3 characters, uppercase");
        }

        $this->_fields = array();

        $this->_fields[0] = $name;

        if (is_array($fields)) {

            for ($i = 0; $i < count($fields); $i++) {

                $this->setField($i + 1, $fields[$i]);
            }
        }
    }


    /**
     * Set the field specified by index to value, and return some true value
     * if the operation succeeded. Indices start at 1, to stay with the HL7
     * standard. Trying to set the value at index 0 has no effect.  The value
     * may also be a reference to an array (that may itself contain arrays)
     * to support composed fields (and subcomponents).
     *
     * To set a field to the HL7 null value, instead of omitting a field, can
     * be achieved with the _Net_HL7_NULL type, like:
     * <code>
     *   $segment->setField(8, $_Net_HL7_NULL);
     * </code>
     * This will render the field as the double quote ("").
     * If values are not provided at all, the method will just return.
     *
     * @param int Index to set
     * @param mixed Value for field
     * @return boolean
     * @access public
     */
    function setField($index, $value= "")
    {
        if (!($index && $value)) {
            return false;
        }

        // Fill in the blanks...
        for ($i = count($this->_fields); $i < $index; $i++) {
            $this->_fields[$i] = "";
        }

        $this->_fields[$index] = $value;

        return true;
    }


    /**
     * Get the field at index. If the field is a composed field, you might
     * ask for the result to be an array like so:
     * <code>
     * $subfields = $seg->getField(9)
     * </code>
     * otherwise the thing returned will be a reference to an array.
     *
     * @param int Index of field
     * @return mixed The value of the field
     * @access public
     */
    function getField($index)
    {
        return isset($this->_fields[$index]) ? $this->_fields[$index] : null;
    }


    /**
     * Get the number of fields for this segment, not including the name
     *
     * @return int number of fields
     * @access public
     */
    function size()
    {
        return count($this->_fields) - 1;
    }


    /**
     * Get the fields in the specified range, or all if nothing specified. If
     * only the 'from' value is provided, all fields from this index till the
     * end of the segment will be returned.
     *
     * @param int Start range at this index
     * @param int Stop range at this index
     * @return array List of fields
     * @access public
     */
    function getFields($from = 0, $to = 0)
    {
        if (!$to) {
            $to = count($this->_fields);
        }

        return array_slice($this->_fields, $from, $to - $from + 1);
    }


    /**
     * Get the name of the segment. This is basically the value at index 0
     *
     * @return mixed Name of segment
     * @access public
     */
    function getName()
    {
        return $this->_fields[0];
    }
}
class Net_HL7_Segments_MSH1 extends Net_HL7_Segment {

    /**
     * Create an instance of the MSH segment.
     *
     * If an array argument is provided, all fields will be filled
     * from that array. Note that for composed fields and
     * subcomponents, the array may hold subarrays and
     * subsubarrays. If the reference is not given, the MSH segment
     * will be created with the MSH 1,2,7,10 and 12 fields filled in
     * for convenience.
     */
    function __construct($fields = NULL, $hl7Globals = NULL)
    {
        parent::__construct("MSH", $fields);

        // Only fill default fields if no fields array is given
        //
        if (!isset($fields)) {

            if (!is_array($hl7Globals)) {
                $this->setField(1, '|');
                $this->setField(2, '^~\\&');
                $this->setField(3, 'HHIMS');
                $this->setField(4, 'MBF');
                $this->setField(5, 'Centralized');
                $this->setField(6, 'HL7Repo');
                $this->setField(7, strftime("%Y%m%d%H%M%S"));
                $this->setField(9, 'A04');

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


    /**
     * Set the field specified by index to value.
     *
     * Indices start at 1, to stay with the HL7 standard. Trying to
     * set the value at index 0 has no effect. Setting the value on
     * index 1, will effectively change the value of FIELD_SEPARATOR
     * for the message containing this segment, if the value has
     * length 1; setting the field on index 2 will change the values
     * of COMPONENT_SEPARATOR, REPETITION_SEPARATOR, ESCAPE_CHARACTER
     * and SUBCOMPONENT_SEPARATOR for the message, if the string is of
     * length 4.
     *
     * @param int Index of field
     * @param mixed Value
     * @return boolean
     * @access public
     */
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
