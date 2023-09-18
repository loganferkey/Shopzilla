<?php
/**
 * Logan Ferkey's Logger
 * Last Updated (3/20/23)
 * A logger class that automatically catches database errors when paired with my PDO class,
 * with support for info/warning error messages to the database as well
 */
class logger {

    // Logging error lvl's
    private $infoLvl = 1;
    private $warningLvl = 3;
    private $errorLvl = 5;

    // Database information in order to send logs to the table.
    private $dbConnection;

    /**
     * @param PDO $dbConnection Requires a PDO database connection to submit logs to a database
     */
    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Writes a log to the database including the message, level of error, file trace, and the line of the error
     * @param string $eMsg The full error message passed into the database
     * @param int $eLvl The error level of the database, 1 = info, 3 = warning, 5 = error
     * @param string $fTrace The file trace of the error, i.e the file it happened in
     * @param int $fLine The line where the error happened
     */
    private function writeLog(string $eMsg, int $eLvl, string $fTrace, int $fLine) {
        try {
            $qresults = $this->dbConnection->prepare(
                "INSERT INTO logging (errorlevel, errormessage, stacktrace, line)
                    VALUES(:errorlevel, :errormessage, :stacktrace, :line)"
            )->execute(['errorlevel' => $eLvl, 'errormessage' => $eMsg, 'stacktrace' => $fTrace, 'line' => $fLine]);
        }
        catch (PDOException $ex) {
            echo 'Logger failed to enter into database.';
        }
    }

    /**
     * Writes an info log to the database, usually for success or non error warnings
     * @param string $passedMsg The message you want to log inside the database, could be a success message or something similar
     */
    public function info(string $passedMsg) {
        $trace = debug_backtrace();
        $this->writeLog($passedMsg, $this->infoLvl, $trace[0]['file'], $trace[0]['line']);
    }

    /**
     * Writes an warning log into the database, usually for non-critical errors
     * @param string $passedMsg The message you want to log inside the database
     */
    public function warning(string $passedMsg) {
        $trace = debug_backtrace();
        $this->writeLog($passedMsg, $this->warningLvl, $trace[0]['file'], $trace[0]['line']);
    }

    /**
     * Writes an warning log into the database, used for critical or database errors aside from automatically caught ones
     * @param string $passedMsg The message you want to log inside the database
     */
    public function error(string $passedMsg) {
        $trace = debug_backtrace();
        $this->writeLog($passedMsg, $this->errorLvl, $trace[0]['file'], $trace[0]['line']);
    }
}