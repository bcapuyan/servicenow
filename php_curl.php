<?php

################################################
#                                              #
# This file will initiate a basic curl request #
#                                              #
################################################

# the config.php file should contain your User name and Password for Service Now
include ('config.php')
  
# Enter your CURL URL below
$str ="";

$ch = curl_init ($str);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, application/xmll','Content-Type: application/json, application/xml'));
curl_setopt($ch, CURLOPT_USERPWD, "$snowuser:$snowpassword");
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec ($ch);

#read the json file contents
$data = json_decode($output, true);
echo $data;

#GET TOTAL COUNT OF RETURNED RESULTS
$count = count($data['result']);
echo "count<br>";
$i = '0'

?>
