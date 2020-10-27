<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace App\Classes\HL7;
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
?>
