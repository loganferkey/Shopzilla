<?php

class Validator {

    // Array to hold validated or not inputs, functions checks against this associative array
    public array $inputs = [];

    const NULL_ERROR = "%s must be filled out"; // Message returned if input is null
    // == String Errors == //
    const STR_TYPE_ERROR = "%s must only be letters and numbers";
    const STR_CUST_ERROR = "%s must only contain %s"; // The second value is your regex type, i.e email, username etc.
    const STR_SHORT = "%s must be longer than %s characters";
    const STR_LONG = "%s must be shorter than %s characters";
    // == Number Errors == //
    const NUM_TYPE_ERROR = "%s must be a number";
    const NUM_SHORT = "%s must be bigger than or %s";
    const NUM_LONG = "%s must be less than or %s";
    // == Date Errors == //
    const DATE_TYPE_ERROR = "%s must be a valid date, YYYY-MM-DD";
    const DATE_PAST = "%s must be after or %s";
    const DATE_FUTURE = "%s must be before or %s";

    /**
     * Checks if the request is post
     */
    public static function Posted() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            return true;
        }
        return false;
    }

    public static function Input($name, $array = null) {
        if ($array !== null) {
            // If they want something out of the $_GET array
            return $array[$name];
        }
        return $_POST[$name];
    }

    /**
     * Validates a number between min and max
     * @param string $inputname The name of your input, name="thisname"
     * @param array $array The array you want to grab the value from, i.e $_POST or $_GET
     * @param float $min The minimum number
     * @param float $max The maximum number
     * @return bool Returns true or false and appends the errors or success to inputs array
     */
    public function number($inputname, $array, $min, $max) {
        // Null check
        if (self::_null($inputname, $array)) {
            // Append the result to the inputs array
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::NULL_ERROR, ucfirst($inputname)), 'value' => $array[$inputname]];
            return false;
        }
        $array[$inputname] = trim($array[$inputname]);
        // Number type check
        if (!is_numeric($array[$inputname])) { 
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::NUM_TYPE_ERROR, ucfirst($inputname)), 'value' => $array[$inputname]];
            return false;
        }
        // Min check
        if ($array[$inputname] < $min) {
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::NUM_SHORT, ucfirst($inputname), Validator::Commify($min)), 'value' => $array[$inputname]];
            return false;
        }
        // Max check
        if ($array[$inputname] > $max) {
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::NUM_LONG, ucfirst($inputname), Validator::Commify($max)), 'value' => $array[$inputname]];
            return false;
        }
        // Validation passed
        $this->inputs[$inputname] = ['valid' => true, 'value' => $array[$inputname]];
        return true;
    }

    /**
     * Validates a string
     * @param string $inputname The name of your input in the array
     * @param array $array The $_POST or $_GET array
     * @param int $min The minimum number of characters
     * @param int $max The maximum number of characters
     * @param ?string $regex NULLABLE, if you want to supply custom regex
     * @param ?string $regexError NULLABLE if you don't have regex, the type of string it should be i.e email, username, etc.
     * @return bool Returns true or false and appends the errors or success to inputs array
     */
    public function string($inputname, $array, $min, $max, $regex = null, $regexError = null) {
        if (self::_null($inputname, $array)) {
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::NULL_ERROR, ucfirst($inputname)), 'value' => $array[$inputname]];
            return false;
        }
        $array[$inputname] = trim($array[$inputname]);
        if (strlen($array[$inputname]) < $min) {
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::STR_SHORT, ucfirst($inputname), $min), 'value' => $array[$inputname]];
            return false;
        }
        if (strlen($array[$inputname]) > $max) {
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::STR_LONG, ucfirst($inputname), $max), 'value' => $array[$inputname]];
            return false;
        }
        if ($regex != null) {
            // If custom regex is supplied
            if (!preg_match($regex, $array[$inputname])) {
                $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::STR_CUST_ERROR, ucfirst($inputname), $regexError), 'value' => $array[$inputname]];
                return false;
            }
        } else {
            // Defaults to checking to make sure it's only letters and numbers
            if (!preg_match('/^[a-zA-Z0-9]+$/', $array[$inputname])) {
                $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::STR_TYPE_ERROR, ucfirst($inputname)), 'value' => $array[$inputname]];
                return false;
            }
        }
        $this->inputs[$inputname] = ['valid' => true, 'value' => $array[$inputname]];
        return true;
    }

    /**
     * @return bool Returns true or false and appends the errors or success to inputs array
     */
    public function date($inputname, $array, $minDate, $maxDate) {
        if (self::_null($inputname, $array)) {
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::NULL_ERROR, ucfirst($inputname)), 'value' => $array[$inputname]];
            return false;
        }
        $array[$inputname] = trim($array[$inputname]);
        $dtInput = new DateTime($array[$inputname]);
        $dtMin = new DateTime($minDate);
        $dtMax = new DateTime($maxDate);
        if (!DateTime::createFromFormat("Y-m-d", $array[$inputname]))
        {
            // If format doesn't match what is expected return false
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::DATE_TYPE_ERROR, ucfirst($inputname)), 'value' => $array[$inputname]];
            return false;
        }
        if ($dtInput < $dtMin) 
        {
            // If date is above or below expected date return false
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::DATE_PAST, ucfirst($inputname), $dtMin), 'value' => $array[$inputname]];
            return false;
        }
        if ($dtInput > $dtMax) 
        {
            // If date is above or below expected date return false
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::DATE_FUTURE, ucfirst($inputname), $dtMax), 'value' => $array[$inputname]];
            return false;
        }
        $this->inputs[$inputname] = ['valid' => true, 'value' => $array[$inputname]];
        return true;
    }

    /**
     * @return bool Returns true or false and appends the errors or success to inputs array
     */
    public function select($inputname, $array) {
        if (self::_null($inputname, $array) || $array[$inputname] == "") {
            $this->inputs[$inputname] = ['valid' => false, 'message' => sprintf(self::NULL_ERROR, ucfirst($inputname)), 'value' => $array[$inputname]];
            return false;
        }
        $array[$inputname] = trim($array[$inputname]);
        $this->inputs[$inputname] = ['valid' => true, 'value' => $array[$inputname]];
        return true;
    }

    public static function Set($array, ...$variables) {
        foreach ($variables as $key) {
            if (!isset($array[$key]) || $array[$key] == null) {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns either the variable if it's not null and set otherwise null
     */
    public static function VarSet($array, $key) {
        if (!isset($array[$key]) || $array[$key] == null) {
            return null;
        }
        // Else return false if it passes!
        return $array[$key];
    }

    // This pretty much only works with $_POST values, so be warned!!!
    // For the javascript to work, the name of the input has to be the same as the id of the span or whatever you're using to display the error
    public function validateInputs() {
        $success = true;
        // Loop through inputs array and append the message via javascript or return true;
        foreach ($this->inputs as $key => $value) {
            echo '<script>document.addEventListener(\'DOMContentLoaded\', function() {';
            if ($value['valid'] === false) {
                  $success = false;
                  // Add the error message to the span
                  echo 'let span = document.getElementById(\''.$key.'\');'.
                       'if (span) { span.textContent = `'.$value['message'].'`; }';
            }
            // Re-adds the value back to the input, usually on success you'd redirect
            echo 'let input = document.querySelector(\'[name="'.$key.'"\');'.
                 'if (input) { input.value = `'.$value['value'].'`; }';
            echo '});</script>';
        }
        if ($success === true) {
            // If all validation passed
            return true;
        }
        // Otherwise return false if a input failed validation
        return false;
    }

    public static function ReCheck($key, $val, $defaultChecked = null) {
        if (self::Posted()) {
            if (isset($_POST[$key]) && $_POST[$key] != null && $_POST[$key] != "") {
                if ($_POST[$key] === $val) {
                    return 'checked';
                }
            } else {
                if ($defaultChecked == true) {
                    return 'checked';
                }
            }
        } else {
            if ($defaultChecked == true) {
                return 'checked';
            }
        }
    }
    public static function ReSelect($key, $val, $defaultSelected = null) {
        if (self::Posted()) {
            if (isset($_POST[$key]) && $_POST[$key] != null && $_POST[$key] != "") {
                if ($_POST[$key] === $val) {
                    return 'selected';
                }
            } else {
                if ($defaultSelected == true) {
                    return 'selected';
                }
            }
        } else {
            if ($defaultSelected == true) {
                return 'selected';
            }
        }
    }

    public static function DollarToFloat($dollarFormat) {
        if (!isset($dollarFormat) || $dollarFormat == null || $dollarFormat == "") { return false; }
        $stripped = str_replace(["$", ","], '', $dollarFormat);
        return $stripped;
    }

    public static function Commify($number, $decimals = null) {
        if ($number > 999 || $number < -999) 
        {
            return number_format($number, $decimals ?? 0);
        }
        return $number;
    }

    public static function ReUse($key) {
        if (Validator::Posted()) {
            if (isset($_POST[$key]) && ($_POST[$key] != "" && $_POST[$key] != null)) {
                return $_POST[$key];
            }
        }
    }
    
    /**
     * Null or !isset()
     * @param string $inputname The name of your input in the array
     * @param array $array The $_POST or $_GET array
     * @return bool Either returns true or false depending if variable is set in array
     */
    public static function _null($inputname, $array) {
        if (!isset($array[$inputname]) || $array[$inputname] == null) {
            return true;
        }
        // Else return false if it passes!
        return false;
    }

}


