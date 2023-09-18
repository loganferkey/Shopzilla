<?php

// Logan Ferkey's PDO wrapper class
// Updated (3/20/23) --- Singleton Edition
// Made this class a singleton :D
// Added correct @param documentation for all functions

class db {

    // ----- [!!IMPORTANT!!] Take a look at the settings first [!!IMPORTANT!!] ----------------------------------------------------------- >>
    // ----------------------------------------------------------------------------------------------------------------------------------- >>
        /**
         * The relative file path to your database connection ini file, see constructor/getInstance method for more guidance ; 
         * I keep my ini file in the same folder as this file, so I don't have to mess around with file paths
         */
        const INI = 'dbconfig.ini';

        /**
         * Whatever classes you put here will be appended to the <p> tag on error (if you supply an error message), style them in your css file (text-center coming from bootstrap)
         */
        const STYLES = 'text-center text-red-400';

        /**
         * Debug option to display actual PDO error on page, not very client deliverable but good for debugging fast (still logs to database table)
         */
        const DEBUG = false;

        /**
         * The single instance of the class
         */
        private static ?db $instance = null;

        /**
         * The PDO connection used by the class for all queries
         */
        private ?PDO $connection = null;

        /** 
         * To be combined with my logger, I don't think it'll work if you don't use it
         */
        public static ?logger $logger = null;
    // ----------------------------------------------------------------------------------------------------------------------------------- >>
    // ----------------------------------------------------------------------------------------------------------------------------------- >>

    private function __construct()
    {
        // Gather information from the supplied ini file on construction (INI_SCANNER_RAW allows special characters in ini file, passwords for example)
        // Example dbconfig.ini file ->
        // hostname = localhost
        // username = yourusername | root (locally not on server)
        // password = yourpassword (I set both PHPMYADMIN on brent's server and mine to the same so I only have to change username between the two)
        // [!!!] Password /\ cannot be blank otherwise INI reader fails [!!!]
        // database = yourdatabasename
        $ci = parse_ini_file(self::INI, false, INI_SCANNER_RAW);

        // All of the fields in the ini file to be read, make sure you format yours the same or change these fields
        $host = $ci['hostname'];
        $user = $ci['username'];
        $pass = $ci['password'];
        $dbnm = $ci['database'];

        try 
        {
            // Create a dbc in the creation of the object then store it for use later when making queries
            $this->connection = new PDO("mysql:host=$host;dbname=$dbnm", $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (self::$logger == null) 
            {
                self::$logger = new logger($this->connection);
            }
        }
        catch (PDOException $ex) 
        {
            // Break connection and echo the error
            $this->connection = null;
            echo('<p class="'.self::STYLES.'"><u>Database connection failed.</u></p>');
            // Check your config ini file...
        }
    }

    /**
     * Creates or returns the instance of the db class
     */
    private static function getInstance() 
    {
        if (self::$instance == null) 
        {
            // Create the single instance and add configuration...
            // See constructor
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    /**
     * Very basic non prepared query, use this when you don't have any user input in your query, like just pulling data from the database for display
     * @param string $query The query you want to execute, example -> "SELECT * FROM example WHERE id = 1"
     * @param ?string $errormsg (OPTIONAL) If you want error text to be displayed on failure
     * @return mixed|false Returns the query result or null on failure to return
     */
    public static function query(string $query, ?string $errormsg = NULL) 
    {
        $db = self::getInstance();
        try 
        {
            $result = $db->connection->query($query);
            if ($result === false) {
                return null;
            }
            return $result;
        }
        catch (PDOException $ex) 
        {
            if (self::DEBUG == true) 
            {
                echo('<p class="'.self::STYLES.'"><u>'.$ex->getMessage().'</u></p>');
            }
            elseif ($errormsg != NULL) 
            {
                echo('<p class="'.self::STYLES.'"><u>'.$errormsg.'</u></p>');
            }
            else 
            {
                // Silent failure with no error message available to user
                // Useful if you want to display a error message yourself in a more appealing way (vs a <p> tag)
            }
            // No matter what always send over the actual error message from the PDO exception
            self::verifyLogger($db);
            self::$logger->error($ex->getMessage());
            return null;
        }
    }

    /**
     * Executes a prepared query, use this when you are doing queries with user input from fields
     * @param string $preparedQuery The query you want to execute, in the VALUES() section use either question marks or :yourValueNameHere to specify value
     * Like this: "INSERT INTO exampletable(column1, column2, column3) VALUES(?, ?, ?)"
     * Also this: "INSERT INTO exampletable(column1, column2, column3) VALUES(:column1, :column2, :column3)"
     * @param array $data An array of values to put into your query, they fill the slots of your question marks or :yourValueNameHere, here's an example!
     * Like this: [$column1, $column2, $column3] To only be used with ? prepared query statements, order is important, match each column with value in array
     * Also this: ['column1' => $column1, 'column2' => $column2, 'column3' => $column3] To be used only with :data identifiers, array keys are just what you had in the query without the : order doesn't matter as much here
     * @param ?string $errormsg (OPTIONAL) If you want error text to be displayed on failure
     * @return mixed|false Returns the query result or false on error, use the results in the pull() or pullAll() function
     */
    public static function prepared(string $preparedQuery, array $data, ?string $errormsg = NULL) 
    {
        $db = self::getInstance();
        try 
        {
            $stmt = $db->connection->prepare($preparedQuery);
            $stmt->execute($data);
            if ($stmt === false) {
                return null;
            }
            return $stmt;
        }
        catch (PDOException $ex) 
        {
            if (self::DEBUG == true) 
            {
                echo('<p class="'.self::STYLES.'"><u>'.$ex->getMessage().'</u></p>');
            }
            elseif ($errormsg != NULL) 
            {
                echo('<p class="'.self::STYLES.'"><u>'.$errormsg.'</u></p>');
            }
            else 
            {
                // Silent failure with no error message available to user
                // Useful if you want to display a error message yourself in a more appealing way (vs a <p> tag)
            }
            // No matter what always send over the actual error message from the PDO exception
            self::verifyLogger($db);
            self::$logger->error($ex->getMessage());
            return null;
        }
    }

    /**
     * Pulls a row from the results of a query, use it in a while loop!
     * @param mixed $queryresult The result of your query
     * @param ?string $errormsg (OPTIONAL) If you want error text to be displayed on failure
     * @return array|false Returns a single row from a query as an array, or false if none left
     */
    public static function pull(mixed $queryresult, ?string $errormsg = NULL) 
    {
        try 
        {
            if ($queryresult == null) { return null; }
            return $queryresult->fetch();
        }
        catch (PDOException $ex) 
        {
            if (self::DEBUG == true) 
            {
                echo('<p class="'.self::STYLES.'"><u>'.$ex->getMessage().'</u></p>');
            }
            elseif ($errormsg != NULL) 
            {
                echo('<p class="'.self::STYLES.'"><u>'.$errormsg.'</u></p>');
            }
            else 
            {
                // Silent failure with no error message available to user
                // Useful if you want to display a error message yourself in a more appealing way (vs a <p> tag)
            }
            // No matter what always send over the actual error message from the PDO exception
            self::verifyLogger(self::getInstance());
            self::$logger->error($ex->getMessage());
            return null;
        }
    }

    /**
     * Grabs all the remaining rows from a previously executed query
     * @param mixed $queryresult Results from a previously executed query
     * @param ?string $errormsg (OPTIONAL) If you want error text to be displayed on failure
     * @return array|false Returns remaining rows in array format ([0] => row, [1] => row, etc...), or false on failure
     */
    public static function dump(mixed $queryresult, ?string $errormsg = NULL) 
    {
        try 
        {
            if ($queryresult == null) { return null; }
            return $queryresult->fetchAll();
        }
        catch (PDOException $ex) 
        {
            if (self::DEBUG == true) 
            {
                echo('<p class="'.self::STYLES.'"><u>'.$ex->getMessage().'</u></p>');
            }
            elseif ($errormsg != NULL) 
            {
                echo('<p class="'.self::STYLES.'"><u>'.$errormsg.'</u></p>');
            }
            else 
            {
                // Silent failure with no error message available to user
                // Useful if you want to display a error message yourself in a more appealing way (vs a <p> tag)
            }
            // No matter what always send over the actual error message from the PDO exception
            self::verifyLogger(self::getInstance());
            self::$logger->error($ex->getMessage()); 
            return null;
        }
    }

    /**
     * Returns the rows recieved from a query result
     * @param mixed $queryresult The query you executed
     * @return int|false Returns the amount of rows or false on failure
     */
    public static function rows(mixed $queryresult)
    {
        try
        {
            if ($queryresult === null) { return 0; }
            return $queryresult->rowCount();
        }
        catch (PDOException $ex)
        {
            // This doesn't really warrant a logging error, if the queryresult isn't valid, you obviously can't get the rows
            // There is already logging for query result failure
            return 0;
        }
        
    }

    /**
     * REQUIRES this instance of the database to pass connection through
     */
    private static function verifyLogger(db $instance) 
    {
        if (self::$logger === null) 
        {
            self::$logger = new logger($instance->connection);
        }
    }

    /**
     * Destroys the current database connection
     */
    public function close() 
    {
        self::getInstance()->connection = null;
    }

    // Easter egg
    public function __clone() 
    {
        throw new Exception(__CLASS__.": I am a singleton!");
    }

    public function __destruct()
    {
        // Destroy connection on deletion of object
        self::getInstance()->connection = null;
    }
}