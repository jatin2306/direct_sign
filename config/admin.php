<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Protected super admin email
    |--------------------------------------------------------------------------
    |
    | This email is reserved for the primary super admin. The user with this
    | email cannot be edited, deactivated, or deleted from the admin panel.
    | New admin users cannot be created with this email. Set in .env as
    | ADMIN_SUPER_EMAIL so it can be changed easily (e.g. per environment).
    |
    */

    'super_email' => env('ADMIN_SUPER_EMAIL', 'admindeal@gmail.com'),

];
