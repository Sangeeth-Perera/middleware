<?php

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
