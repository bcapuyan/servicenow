<?php
#version2 code
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes
error_reporting( error_reporting() & ~E_NOTICE );
ini_set('memory_limit', '256M');
include ('config.php');

@mysql_connect($dbServer, $dbUser, $dbPass) or die("Couldn't connect to database server: " . mysql_error());
@mysql_select_db('SNOW') or die("Couldn't connect to database: " . mysql_error());

$file = 'cmdb_ci_update_log.txt';
$sql = "Select sys_id from SNOW.rest_cmdb_ci where sys_updated_on > '2015-12-31 23:59:59' order by sys_updated_on asc";
#$sql = "Select sys_id from SNOW.rest_cmdb_ci where sys_id = '1a76ed2f6f636a0006d78c226e3ee4d3' ";

    $result = mysql_query($sql) or die( mysql_error() );
    if ($result){
        while( $row = mysql_fetch_array($result) ){
            extract($row);

$str = "https://rhiprod.service-now.com/api/now/v1/table/cmdb_ci?sys_id=$sys_id";
echo "$str";
$ch = curl_init ($str);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, application/xmll','Content-Type: application/json, application/xml'));
curl_setopt($ch, CURLOPT_USERPWD, "$snowuser:$snowpassword");
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec ($ch);
echo $output;

$data = json_decode($output, true);
$count = count($data['result']);
$i = '0';
while ($i < $count) {

$asset  = $data['result'][$i]['asset']['value'];
$asset_tag = $data['result'][$i]['asset_tag'];
$assigned = $data['result'][$i]['assigned'];
$assigned_to = $data['result'][$i]['assigned_to'];
$assignment_group = $data['result'][$i]['assignment_group'];
$category = $data['result'][$i]['category'];
$change_control = $data['result'][$i]['change_control'];
$checked_in = $data['result'][$i]['checked_in'];
$checked_out = $data['result'][$i]['checked_out'];
$comments = $data['result'][$i]['comments'];
$correlation_id = $data['result'][$i]['correlation_id'];
$cost = $data['result'][$i]['cost'];
$company = $data['result'][$i]['company'];
$cost_cc = $data['result'][$i]['cost_cc'];
$cost_center = $data['result'][$i]['cost_center'];
$department = $data['result'][$i]['department'];
$dns_domain = $data['result'][$i]['dns_domain'];
$delivery_date = $data['result'][$i]['delivery_date'];
$due = $data['result'][$i]['due'];
$due_in = $data['result'][$i]['due_in'];
$fault_count = $data['result'][$i]['fault_count'];
$gl_account = $data['result'][$i]['gl_account'];
$install_date = $data['result'][$i]['install_date'];
$install_status = $data['result'][$i]['install_status'];
$invoice_number = $data['result'][$i]['invoice_number'];
$ip_address = $data['result'][$i]['ip_address'];
$justification = $data['result'][$i]['justification'];
$last_discovered = $data['result'][$i]['last_discovered'];
$lease_id = $data['result'][$i]['lease_id'];
$location = $data['result'][$i]['location']['value'];
$mac_address = $data['result'][$i]['mac_address'];
$maintenance_schedule = $data['result'][$i]['maintenance_schedule'];
$managed_by = $data['result'][$i]['managed_by'];
$manufacturer = $data['result'][$i]['manufacturer']['value'];
$model_id = $data['result'][$i]['model_id']['value'];
$model_number = $data['result'][$i]['model_number'];
$monitor = $data['result'][$i]['monitor'];
$name = $data['result'][$i]['name'];
$operational_status = $data['result'][$i]['operational_status'];
$order_date = $data['result'][$i]['order_date'];
$owned_by = $data['result'][$i]['owned_by'];
$po_number = $data['result'][$i]['po_number'];
$purchase_date = $data['result'][$i]['purchase_date'];
$schedule = $data['result'][$i]['schedule'];
$serial_number = $data['result'][$i]['serial_number'];
$short_description = $data['result'][$i]['short_description'];
$skip_sync = $data['result'][$i]['skip_sync'];
$start_date = $data['result'][$i]['start_date'];
$subcategory = $data['result'][$i]['subcategory'];
$support_group = $data['result'][$i]['support_group']['value'];
$supported_by = $data['result'][$i]['supported_by'];
$sys_class_name = $data['result'][$i]['sys_class_name'];
$sys_created_by = $data['result'][$i]['sys_created_by'];
$sys_created_on = $data['result'][$i]['sys_created_on'];
$sys_domain = $data['result'][$i]['sys_domain']['value'];
$sys_mod_count = $data['result'][$i]['sys_mod_count'];
$sys_tags = $data['result'][$i]['sys_tags'];
$sys_updated_by = $data['result'][$i]['sys_updated_by'];
$sys_updated_on = $data['result'][$i]['sys_updated_on'];
$u_ad_last_updated = $data['result'][$i]['u_ad_last_updated'];
$u_apac_change_control = $data['result'][$i]['u_apac_change_control'];
$u_auto_route = $data['result'][$i]['u_auto_route'];
$u_data_center = $data['result'][$i]['u_data_center'];
$u_emea_change_control = $data['result'][$i]['u_emea_change_control'];
$u_environment = $data['result'][$i]['u_environment'];
$u_node_id = $data['result'][$i]['u_node_id'];
$u_operational_tier = $data['result'][$i]['u_operational_tier'];
$u_rh_business_units_impacted = $data['result'][$i]['u_rh_business_units_impacted'];
$u_rhi_location = $data['result'][$i]['u_rhi_location'];
$u_sa_change_control = $data['result'][$i]['u_sa_change_control'];
$u_site_id = $data['result'][$i]['u_site_id'];
$u_solarwinds_url = $data['result'][$i]['u_solarwinds_url'];
$u_validators = $data['result'][$i]['u_validators'];
$unverified = $data['result'][$i]['unverified'];
$vendor = $data['result'][$i]['vendor'];
$warranty_expiration = $data['result'][$i]['warranty_expiration'];


$query = "update SNOW.rest_cmdb_ci set asset = '$asset', asset_tag = '$asset_tag', assigned = '$assigned', assigned_to = '$assigned_to', assignment_group = '$assignment_group',
category = '$category', change_control = '$change_control', checked_in = '$checked_in', checked_out = '$checked_out', comments = '$comments', company = '$company', correlation_id = '$correlation_id',
cost = '$cost', cost_cc = '$cost_cc', cost_center = '$cost_center', delivery_date = '$delivery_date', department = '$department', dns_domain = '$dns_domain', due = '$due', due_in = '$due_in',
fault_count = '$fault_count', gl_account = '$gl_account', install_date = '$install_date', install_status = '$install_status', invoice_number = '$invoice_number', ip_address = '$ip_address',
justification = '$justification', last_discovered = '$last_discovered', lease_id = '$lease_id', location = '$location', mac_address = '$mac_address', maintenance_schedule = '$maintenance_schedule',
managed_by = '$managed_by', manufacturer = '$manufacturer', model_id = '$model_id', model_number = '$model_number', monitor = '$monitor', name = '$name', operational_status = '$operational_status',
order_date = '$order_date', owned_by = '$owned_by', po_number = '$po_number', purchase_date = '$purchase_date', schedule = '$schedule', serial_number = '$serial_number', short_description = '$short_description',
skip_sync = '$skip_sync', start_date = '$start_date', subcategory = '$subcategory', support_group = '$support_group', supported_by = '$supported_by', sys_class_name = '$sys_class_name',
sys_created_by = '$sys_created_by', sys_created_on = '$sys_created_on', sys_domain = '$sys_domain', sys_mod_count = '$sys_mod_count', sys_tags = '$sys_tags', sys_updated_by = '$sys_updated_by',
sys_updated_on = '$sys_updated_on', u_ad_last_updated = '$u_ad_last_updated', u_apac_change_control = '$u_apac_change_control', u_auto_route = '$u_auto_route', u_data_center = '$u_data_center',
u_emea_change_control = '$u_emea_change_control', u_environment = '$u_environment', u_node_id = '$u_node_id', u_operational_tier = '$u_operational_tier', u_rh_business_units_impacted = '$u_rh_business_units_impacted',
u_rhi_location = '$u_rhi_location', u_sa_change_control = '$u_sa_change_control', u_site_id = '$u_site_id', u_solarwinds_url = '$u_solarwinds_url', u_validators = '$u_validators', unverified = '$unverified',
vendor = '$vendor', warranty_expiration = '$warranty_expiration'  where sys_id='$sys_id'";
mysql_query($query) or die(mysql_error());
echo "Number $number State $state Closed $closed_at<br>";
$i++;
}

$current = file_get_contents($file);
$current .="$sys_id $sys_created_on $sys_updated_on\n";
file_put_contents($file, $current);

sleep(2);
        }};


                    ?>
