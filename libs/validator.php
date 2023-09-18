<?php
// Validation class, (only naming it v is so it's shorter when I type it a lot of times)
// Last Updated (3/23/2023) -> Logan Ferkey
class v {

    // Static bootstrap color classes
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const ERROR   = 'danger';
    const INFO    = 'info';

    // Premade array of characters that are bad for SQL injection
    // I kind of forgot which keywords/characters are bad so I'll probably update this over time
    // However I don't really need this with PDO, more just to have it in my library
    const SQLINJECTION = ["DROP", "DELETE", "UPDATE", "ALTER", ";", "-"];

    /**
     * Takes an array of variables and returns true if all of them are set and not null
     * @param array $values An array of all values you want to make sure are NOT null and are set
     * @return bool true or false depending on if all values are set and not null
     */
    public static function allValid(array $keys, array $array) 
    {
        try {
            foreach ($keys as $val) 
            {
                if (!isset($array[$val]) || $array[$val] == null) 
                {
                    return false;
                }
            }
            return true;
        }
        catch (Error $ex)
        {
            return false;
        }
    }

    /**
     * Checks a single variable to make sure it's not null and set
     * @param mixed $var Any variable you want to make sure is valid
     * @return mixed Whether or not the variable passed inspection
     */
    public static function notNull(mixed $var, string $name) 
    {
        if (!isset($var) || $var == null) 
        {
            return $name.' has to be filled out';
        }
        return true;
    }

    public static function passed(array $validation)
    {
        foreach($validation as $val)
        {
            if ($val !== true)
            {
                // If any of the validation messages 
                return false;
            }
        }
        // If all validation passed
        return true;
    }

    public static function error(mixed $validation)
    {
        if (!isset($validation))
        {
            return false;
        }
        // Should only be passed a variable which either holds true or an error message
        if ($validation !== true)
        {
            echo $validation;
        }
    }

    /**
     * The main use of this to check the $_POST or $_GET array, it dumps all the values in pretty format wherever you use this
     * @param array $r The key value pair array
     * @return void Doesn't return anything, only echos to the page
     */
    public static function debug(array $r) {
        foreach ($r as $key => $value) {
            echo $key . ' => ' . $value . '<br>';
        }
        echo '<br>';
    }

    /**
     * Simple way to make sure the post request is filled and there are values inside the POST array
     * @return bool True or false if REQUEST_METHOD is post and the post array isn't empty
     */
    public static function posted() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST))
        {
            return true;
        }
        return false;
    }

    // -- Input Validation --
    // ======================

    /**
     * Assumes date format of YYYY-MM-DD <= VERY IMPORTANT
     * @param string $date The date you want to check
     * @param string $minDate The minimum date allowed
     * @param string $maxDate The maximum date allowed
     * @param string $name The name of the input
     */
    public static function valiDate(string $date, string $minDate, string $maxDate, string $name) 
    {
        if (!isset($date) || $date == null) 
        {
            return "$name has to be filled out";
        }
        $dtDate = new DateTime($date);
        $dtMin = new DateTime($minDate);
        $dtMax = new DateTime($maxDate);
        if (!DateTime::createFromFormat("Y-m-d", $date)) 
        {
            // If format doesn't match what is expected return false
            return "$name did not match required format";
        }
        if ($dtDate < $dtMin || $dtDate > $dtMax) 
        {
            // If date is above or below expected date return false
            return "$name was out of bounds";
        }
        // It beat all cases!
        return true;
    }

    public static function validateString(string $string, mixed $min, mixed $max, ?string $regexFormat = null, ?string $errorMessage = null, string $name)
    {
        if (!isset($string) || $string == null)
        {
            return "$name has to be filled out";
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $string))
        {
            return "$name has to be letters and numbers";
        }
        if ($regexFormat != null) 
        {
            if (preg_match($regexFormat, $string))
            {
                // Your specific error message for your regex goes here, can be null and it won't check it
                return $errorMessage;
            }
        }
        if (strlen($string) < $min || strlen($string) > $max) 
        {
            return "$name has to be between $min and $max characters long";
        }
        return true;
    }

    public static function validateNumber(mixed $number, mixed $min, mixed $max, string $name)
    {
        if (!isset($number) || $number == null)
        {
            return "$name has to be filled out";
        }
        if (!is_numeric($number))
        {
            return "$name has to be a number";
        }
        if ($number < $min || $number > $max)
        {
            return "$name has to be between $min and $max";
        }
        return true;
    }

    public static function validateSelect(mixed $value, string $name)
    {
        if (!isset($value) || $value == "" || $value == null)
        {
            return "$name has to be selected";
        }
        return true;
    }

    /**
     * Compares two passed in variables
     * @param mixed $input1 The first variable
     * @param mixed $input2 The second variable
     * @return bool Returns true if they match, otherwise false
     */
    public static function compare(mixed $input1, mixed $input2, string $message, string $nullMessage) 
    {
        if (!isset($input1) || !isset($input2) || $input1 == null || $input2 == null)
        {
            return $nullMessage;
        }
        if ($input1 != $input2)
        {
            return $message;
        }
        return true;
    }

    /**
     * If the function returns false, echos the given error message
     * @param string $function The function you want to call in parenthesis i.e 'validator::valiDate($_POST["birthdate], "1900-12-01", "2023-04-31"), "Date is not within bounds or wrong format")'
     */
    public static function pcall($function)
    {
        $result = $function();
        if ($result != true) 
        {
            // Assuming the result being true if validation succeeds, send the error message from the function on fail
            echo $result;
        }
    }

    /**
     * To ONLY be used with $_POST or $_GET, either echos the value if it was in the array or doesn't echo anything, reusing form inputs on failed submission
     * @param mixed $inputArrayKey The key in the array
     * @param array $array The array you want to use, i.e $_POST or $_GET
     * @return void Doesn't return anything only echos
     */
    public static function reuse(mixed $inputArrayKey, array $array)
    {
        if (!isset($array[$inputArrayKey]) || $array[$inputArrayKey] == null)
        {
            return false;
        }
        echo $array[$inputArrayKey];
    }

    /**
     * Clamps any number between a min and a max and returns either the number, min, or the max depending on bounds
     * @param number $value The value you want to clamp
     * @param number $min The minium number value
     * @param number $max The maximum number value
     * @return mixed Returns the number clamped between min and max
     */
    public static function clamp(mixed $value, mixed $min, mixed $max) 
    {
        return max($min, min($max, $value));
    }

    /**
     * Strips any amount of characters from a string based on past in array, automatically trims the string as well
     * @param string $string The string you want to strip characters from
     * @param ?array $chars The array of characters/strings you want to strip from the string, OR NULL for no strip
     * @return string Returns the stripped string
     */
    public static function strip(string $string, ?array $chars = null) 
    {
        $string = trim($string);
        if ($chars != null) 
        {
            // If $chars array isn't null and characters need to be stripped
            $string = str_ireplace($chars, '', $string);
        }
        return $string;
    }

    /**
     * Returns a formatted string of a number big enough to warrant commas
     * @param float $number The number you want to add commas to
     * @param ?int $decimals If the number has decimals, specify how many decimal points you want to allow
     * @return string Returns a formatted version of the number with commas as a string
     */
    public static function commify(float $number, ?int $decimals = null) 
    {
        if ($number > 999 || $number < -999) 
        {
            return number_format($number, $decimals ?? 0);
        }
        return $number;
    }

    /**
     * Returns a closeable !!BOOTSTRAP!! banner, useful if you want a banner on error or success messages, probably requires popper from bootstrap.js
     * @param string $type The type of banner, use builtin validator::[SUCCESS,WARNING,ERROR,INFO] to change banner color
     * @param string $header The header of the banner
     * @param string $message The message the banner holds
     * @return string Returns the formatted bootstrap banner
     */
    public static function banner(string $type, string $header, string $message) 
    {
        $banner = '<div class="alert alert-dismissible alert-'.$type.'">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <h4 class="alert-heading">'.$header.'</h4>
                        <p class="mb-0">'.$message.'</p>
                    </div>';
        return $banner;
    }
}