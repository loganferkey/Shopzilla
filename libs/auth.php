<?php

    // Authorization/Authentication Class for Users
    // Last Updated (4/16/23) -> Logan Ferkey
    // I use fa_????? in session keys to avoid conflicting with other websites when testing

    class auth
    {
        const LOGGED_IN = true;

        /**
         * Checks the current session for any user data and returns a user variable with information if it exists
         */
        public static function checkForUser()
        {
            // Create the current user and set it to null, to make it easier to use on pages
            // A simple if ($user == null) {} check is all it takes to see if they're logged in (preferably use the auth::authorize to check logged in as well as role required)
            $u = null;
            $GLOBALS['user'] = null;

            if (session_id() == "") {
                session_start();
            }
            // Grab the current user from the session if they are logged in
            if (isset($_SESSION["fa_userid"]) && isset($_SESSION["fa_username"]))
            {
                // If they're set make sure they're not null, if they aren't, set the user to them
                if ($_SESSION["fa_userid"] != null && $_SESSION["fa_username"] != null)
                {
                    // Set the user information 
                    $u["userid"]   = $_SESSION["fa_userid"];
                    $u["username"] = $_SESSION["fa_username"];
                    $u["roles"]     = $_SESSION["fa_roles"] ?? null;
                }
            }
            // Return either null on not logged in or the correct user
            // Reference the user by doing USER['userid'], USER['username'], USER['role']
            $GLOBALS['user'] = $u == null ? null : User::findById($u['userid']);
            define('User', $GLOBALS['user']);
            return $GLOBALS['user'];
        }

        /**
         * Pass in the current user, whether they're logged in or not and get their role (or lack there of)
         * @param mixed $user The variable that holds the current user's information (probably $user)
         * @param string $role Role you want to check
         * @return true|false Returns true if that is their role, otherwise false
         */
        public static function isInRole(mixed $userRoles, string $role)
        {
            // Guard clauses are better
            if (!isset($userRoles) || $userRoles == null) { return false; }
            if (in_array(strtolower($role), $userRoles)) {
                // If the role exists in the users role, return true
                return true;
            }
            return false;
        }
    }

    // Start the session and return the user or lack there of
    // Important to remember it's held under $user
    $user = auth::checkForUser();