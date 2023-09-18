<?php

    // Account Manager Class (Signin/Register/Logout)
    // Last Updated (4/16/23) -> Logan Ferkey

    class account 
    {
        // Settings for the account class
        // ==================================================================================================
        // !!!IMPORTANT!!! MAKE SURE -> Your users table has at minimum these columns
        // id, username, password, email, role (WITH THOSE EXACT NAMES) otherwise it wont work :(
        // ==================================================================================================
        const TABLE_NAME   = "sz_users";      // The name of your users table
        // TODO: Make password salt mandatory
        const ENCRYPTION   = PASSWORD_BCRYPT; // The encryption method of the password hash, recommended to leave this to default/bcrypt
        // ==================================================================================================

        // These are what are passed into the GET parameters on error, you can change them here if you'd like
        // Also displayed so you can see what they are when you add styled messages on failure
        // ==================================================================================================
        // You can also change the GET paramater for errors/success messages, by default it is account
        // This is deprecated with MVC -----
        const DEBUG_PARAM     = 'account'; // Used on functions for errors that don't belong to either register, login, logout but all of them (i.e userExists())
        // ==================================================================================================
        const QUERY_ERROR       = 'There was an error adding you to the database';         // If a query fails when adding/checking database
        const USER_EXISTS_ERROR = 'A user already exists with that name or email';  // If a user already exists when checking on register (either username or email)
        const REGISTER_SUCCESS  = 'Register successful';    // If the user was successfully registered
        const REGISTER_ERROR    = 'There was an error registering your account, it might not be your fault!';      // If the user wasn't able to be entered into the database
        const CREDENTIALS_ERROR = 'Invalid credentials'; // On login, invalid credentials were used
        // ==================================================================================================
        // Below registerUser(), loginUser(), and logoutUser() are the only functions you should need on your pages!
        // ==================================================================================================

        /**
         * Registers a user in the database if they don't already exist
         * @param string $email The user's email, must be unique
         * @param string $username The user's username, must be unique
         * @param string $password The user's password
         * @param string $returnUrl Where they will be redirected upon register or failure, make sure you look at this file path compared to the one you want
         * @param string $successUrl Where the user should be redirected on successful registration and login
         * @return string|void If they are successfully registered, logs them in and redirects or returns the error message
         */
        public static function registerUser(string $email, string $username, string $password) 
        {
            if (!self::userAlreadyExists($email, $username)) {
                $hashed = self::hashPassword($password);
                // If the user doesn't exist, register them (user is the default role!)
                if (db::prepared('INSERT INTO '.self::TABLE_NAME.' (username, password, email, roles) VALUES (?, ?, ?, ?)', [$username, $hashed, $email, "user"])) {

                        // Try to log them in! If it fail it redirects to returnUrl with login error
                        return self::loginUser($username, $password);
                }
                else {
                    return self::REGISTER_ERROR;
                }
            }
            else {
                return self::USER_EXISTS_ERROR;
            }
        }

        /**
         * Attempts to log the user in
         * @param string $username The user's username
         * @param string $password The user's password
         * @param string $returnUrl Where to redirect to on failure (i.e ../login.php)
         * @param string $successUrl Where to redirect on successful login (i.e ../index.php)
         * @param void Redirects to either returnUrl on failure with error or successUrl on successful login
         */
        public static function loginUser(string $username, string $password)
        {
            $user = self::checkUserLogin($username, $password);
            if ($user != false) {
                // If the user login checks out and we get a user back
                if (session_id() == "") {
                    session_start();
                }
                $_SESSION["fa_userid"]   = $user["id"];
                $_SESSION["fa_username"] = $user["username"];
                $_SESSION["fa_password"] = $user["password"];
                $_SESSION["fa_roles"]     = $user["roles"];
                // It's important to close it here because the auth file automatically starts another session
                session_write_close();
                // Redirect on successful login
                return true;
            }
            else {
                // If credentials failed to login
                return self::CREDENTIALS_ERROR;
            }
        }

        /**
         * Destroys all user data from session logging the user out
         * @return void Doesn't return anything, just logs the user out
         */
        public static function logout()
        {
            if (session_id() == "") {
                // If there is no session active (unlikely!)
                session_start();
            }
            session_unset();
            session_destroy();
        }

        // ==================================================================================================
        // Helper Functions!
        // ==================================================================================================

        /**
         * Checks against the database to see if a user already has that email or username
         * @param string $email The email to check against
         * @param string $username The username to check against
         * @param string $returnUrl Where you are redirected to on failure
         * @return true|false Returns true if it email/username is taken, otherwise false
         */
        public static function userAlreadyExists(string $email, string $username)
        {
            $users = db::prepared("SELECT id FROM ".self::TABLE_NAME." WHERE email = ? OR username = ?", [$email, $username]);
            if (!$users) {
                // If the query fails somehow, assume the user exists ?
                return true;
            }
            else {
                // If the query went through, check to make sure the rows are 0
                if (db::rows($users) > 0) {
                    // If user(s) are returned, user definitely exists!
                    return true;
                }
                else {
                    // No user exists!
                    return false;
                }
            }
        }

        /**
         * Checks whether the user's username and password match against the database
         * @param string $username The user's username
         * @param string $password The user's password
         * @return mixed|false If the user's login is correct, returns the user with those credentials otherwise false
         */
        public static function checkUserLogin(string $username, string $password)
        {
            $user = db::prepared("SELECT id, username, password, roles FROM ".self::TABLE_NAME." WHERE username = ?", [$username]);
            if (db::rows($user) == 0) {
                // If no users were found
                return false;
            }
            else {
                // Pull the row so we can use the column information
                $user = db::pull($user);
                // If a user exists with the passed in username and password their credentials matched
                if (password_verify($password, $user["password"])) {
                    // If the passwords matched, return the user!
                    return $user;
                }
                else {
                    // The passwords didn't match
                    return false;
                }
            }
        }

        /**
         * Generates a specific length, random salt for user passwords
         * @param int $length How long you want the salt to be
         * @return string Returns the specified salt at length
         */
        public static function generateSalt(int $length) {
            return random_bytes($length);
        }

        /**
         * Hashes the given string(password)
         * @param string $password The string you want to hash
         * @return string|false Returns the hashed string or false on failure
         */
        public static function hashPassword(string $password) {
            // TODO: Add functionality for salt, or make salt required
            return password_hash($password, self::ENCRYPTION);
        }
    }