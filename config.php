<?php

$dbhost = "mysql6.000webhost.com";
$dbuser = "a6826187_faucet";
$dbpass = "4uqx45snbz";
$dbname = "a6826187_faucet";
$display_errors = false;
$disable_admin_panel = false;

$connection_options = array(
    'disable_curl' => false,
    'local_cafile' => false,
    'force_ipv4' => false    // cURL only
);

// dsn - Data Source Name
// if you use MySQL, leave it as is
// more information:
// http://php.net/manual/en/pdo.construct.php
$dbdsn = "mysql:host=$dbhost;dbname=$dbname";
