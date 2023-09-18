<?php

class Access {
    public static function hasAccess($userRoles, $allowed) {
        if ($userRoles != null && isset($userRoles)) {
            if (in_array("!suspended", $allowed) && User != null) {
                // If they're suspended and the page doesn't allow suspended users
                // Return false
                if (User->suspended == 1) { return false; }
            }
            // Check permissions on user roles based on controller and view
            foreach($allowed as $reqRole) {
                // Loop through each required role and each user role, if any are equal, allow access
                foreach($userRoles as $userRole) { if ($userRole === $reqRole) { return true; } }
            }
            return false;
        }
    }
}