<?php 
// anti ddos script using php 

// define a few things
$IPmaxNumber = 10;

// get the IP address
$clientIP = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : 
            ($_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : 
            ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 
            $_SERVER['REMOTE_ADDR']));

// get the currently logged in IP addresses
$IPs = file_get_contents('loggedIP.txt');

// check if the current IP address is logged in
if (strstr($IPs, $clientIP)) {
    // split the file content by comma
    $ips = explode(',', $IPs);

    // if IP reaches number limit, deny access
    if (count($ips) > $IPmaxNumber) {
        header("HTTP/1.0 403 Forbidden");
        exit;
    }
    // add the current IP to the file content
    array_push($ips, $clientIP);
    // convert the file content to string and save it
    file_put_contents('loggedIP.txt', implode(",", $ips));
}