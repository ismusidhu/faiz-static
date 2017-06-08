<?php
include('connection.php');
require 'mailgun-php/vendor/autoload.php';
require '../backup/_email_backup.php';
require '../sms/_sms_automation.php';

use Mailgun\Mailgun;
error_reporting(0);

$day = date("D");
if ($day == 'Sat') {
	exit;
}

$sql = mysqli_query($link,"SELECT t.Thali, t.NAME, t.CONTACT, t.Transporter, t.Full_Address, c.Operation,c.id 
						from change_table as c
						inner join thalilist as t on c.Thali = t.Thali
						WHERE c.processed = 0");
$request = array();
$processed_ids = array(); 
echo "<pre>";
while($row = mysqli_fetch_assoc($sql))
{
	$request[$row['Transporter']][$row['Operation']][] = $row;
	$processed[] = $row['id'];
}

foreach ($request as $transporter_name => $thalis) {
	$msgvar .= "<b>".$transporter_name."</b>\n";
	foreach ($thalis as $operation_type => $thali_details) {
		$msgvar .= $operation_type."\n";
		if(in_array($operation_type, array('Start Thali','Start Transport','Update Address','New Thali')))
		{
			foreach ($thali_details as $thaliuser) {
				$msgvar .= 	sprintf("%s - %s - %s - %s - %s\n",$thaliuser['Thali'],$thaliuser['NAME'],$thaliuser['CONTACT'],$thaliuser['Transporter'],$thaliuser['Full_Address']);
			}	
		}
		else if(in_array($operation_type, array('Stop Thali','Stop Transport')))
		{
			foreach ($thali_details as $thaliuser) {
				$msgvar .= 	sprintf("%s\n",$thaliuser['Thali']);
			}
		}
		$msgvar .= 	"\n";
	}
}
mysqli_query($link,"update change_table set processed = 1 where id in (".implode(',', $processed).")");

$result = mysqli_query($link,"SELECT * FROM thalilist WHERE Active='1' ");
$count=mysqli_num_rows($result);

$msgvar .= "\n Count \n $count ";

$myfile = fopen("requestarchive.txt", "a") or die("Unable to open file!");
$txt= date('d/m/Y')."\n".$msgvar."\n";
fwrite($myfile, $txt);
fclose($myfile);

$msgvar = str_replace("\n", "<br>", $msgvar);

$mg = new Mailgun("key-e3d5092ee6f3ace895af4f6a6811e53a");
$domain = "mg.faizstudents.com";

$mg->sendMessage($domain, array('from'    => 'admin@faizstudents.com', 
                                'to'      => 'ummihaider@gmail.com,burhanik72@gmail.com,bscalcuttawala@gmail.com', 
                                'cc'      => 'help@faizstudents.com',   
                                'subject' => 'Start Stop update '.date('d/m/Y'),
                                'html'    => $msgvar));


?>	