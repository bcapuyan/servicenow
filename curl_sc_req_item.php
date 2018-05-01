<?php
ini_set('max_execution_time', 900000); //300 seconds = 5 minutes
error_reporting( error_reporting() & ~E_NOTICE );
ini_set('memory_limit', '256M');
include ('config.php');

@mysql_connect($dbServer, $dbUser, $dbPass) or die("Couldn't connect to database server: " . mysql_error());
@mysql_select_db($dbName) or die("Couldn't connect to database: " . mysql_error());
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
//$today = "2016-08-24";
echo "$today<br>";

$year = date("Y");
$month = date("m");
//$year = '2017';
//$month = '01';
echo "Month $month Year $year";

$str = "https://rhiprod.service-now.com/api/now/v1/table/sc_req_item?sysparm_query=opened_atBETWEENjavascript%3Ags.dateGenerate('$year-$month-01'%2C'00%3A00%3A00')%40javascript%3Ags.dateGenerate('$year-$month-31'%2C'23%3A59%3A59')";

// backfill
#$str = "https://rhiprod.service-now.com/api/now/v1/table/sc_req_item?sysparm_query=opened_atBETWEENjavascript%3Ags.dateGenerate('$year-$month-16'%2C'00%3A00%3A00')%40javascript%3Ags.dateGenerate('$year-$month-31'%2C'23%3A59%3A59')";

#$str = "https://rhiprod.service-now.com/api/now/v1/table/sc_req_item?sysparm_query=opened_atBETWEENjavascript%3Ags.dateGenerate('$year-$month-01'%2C'00%3A00%3A00')%40javascript%3Ags.dateGenerate('$year-$month-15'%2C'23%3A59%3A59')";


echo $str;
$ch = curl_init ($str);
#curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, application/xmll','Content-Type: application/json, application/xml'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Content-Type: application/json'));
curl_setopt($ch, CURLOPT_USERPWD, "user:pass");
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_POSTFIELDS, "assignment_group=e50639986fb7c1004c682d232e3ee42d");
$output = curl_exec ($ch);
//echo "$output<hr>";

//read the json file contents
     $data = json_decode($output, true);
//echo $data;
// GET TOTAL COUNT OF RETURNED RESULTS
$count = count($data['result']);
//echo "$output<hr>";
 echo "<br> Number of items returned $count<br>";
$i = '0';

while ($i < $count) {
// PARSE OUT MULTI DIMENSIONAL ARRAY ONLY VALUES WE NEED
$impact = $data['result'][$i]['impact'];
$short_description = $data['result'][$i]['short_description'];
$short_description = str_replace("'", "\'", $short_description);
$short_description = htmlentities($short_description);
$sla_start_time = $data['result'][$i]['sla_start_time'];
$assigned_to = $data['result'][$i]['assigned_to']['value'];
$opened_by = $data['result'][$i]['opened_by']['value'];
$opened_at = $data['result'][$i]['opened_at'];
$closed_at = $data['result'][$i]['closed_at'];
$urgency = $data['result'][$i]['urgency'] ;
$assignment_group = $data['result'][$i]['assignment_group']['value'];
$cmdb_ci = $data['result'][$i]['cmdb_ci']['value'];
$task_type = $data['result'][$i]['task_type'];
$number = $data['result'][$i]['number'] ;
$status = $data['result'][$i]['status'];
$state = $data['result'][$i]['state'];
$sla_days = $data['result'][$i]['sla_days'];
$sys_updated_on = $data['result'][$i]['sys_updated_on'] ;
$parent_sys_id = $data['result'][$i]['parent']['value'];
$sys_id = $data['result'][$i]['sys_id'];
$i++;

echo "$number";

#RESOLVE
 $sql = "Select user_name as assigned_to from rest_sys_user where sys_id='$assigned_to'";
    $result = mysql_query($sql) or die( mysql_error() );
    if ($result){
        while( $row = mysql_fetch_array($result) ){
            extract($row);
}};
$sql = "Select name as assignment_group from rest_sys_user_group where sys_id='$assignment_group'";
    $result = mysql_query($sql) or die( mysql_error() );
    if ($result){
        while( $row = mysql_fetch_array($result) ){
            extract($row);
}};

 $sql = "Select name as cmdb_ci from rest_cmdb_ci where sys_id='$cmdb_ci'";
    $result = mysql_query($sql) or die( mysql_error() );
    if ($result){
        while( $row = mysql_fetch_array($result) ){
            extract($row);
}};
 $sql = "Select user_name as opened_by from rest_sys_user where sys_id='$opened_by'";
    $result = mysql_query($sql) or die( mysql_error() );
    if ($result){
        while( $row = mysql_fetch_array($result) ){
            extract($row);
}};

$query = "insert into rest_sc_req_item values ('$number','$short_description','$assigned_to','$opened_by','$opened_at','$closed_at','$urgency','$assignment_group','$cmdb_ci','$task_type','$status','$state','$sla_start_time','$sla_days','$parent','$parent_sys_id','$sys_id') ON DUPLICATE KEY UPDATE assigned_to = '$assigned_to', opened_by = '$opened_by', opened_at = '$opened_at', closed_at = '$closed_at', urgency = '$urgency', assignment_group = '$assignment_group', configuration_item = '$cmdb_ci', task_type = '$task_type', status = '$status', state = '$state', sla_start_time = '$sla_start_time', sla_days = '$sla_days', parent = '$parent', parent_sys_id  = '$parent_sys_id'";
mysql_query($query) or die(mysql_error());

}

?>
