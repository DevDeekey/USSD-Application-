/*
	Holla: DeetechApps [at] Gmail dot Com
	Twitter  @Devdeekey
*/
<?php
require_once('lib/nusoap.php');
$choice=$_GET['choice'];

if($choice==1)
{
$param=array('ID'=>"26718443",'Name' =>"Josephat Mwathi",'Phone_Number' =>"0724589264");
$client=new nusoap_client('http://127.0.0.1/bus/serverside.php?wsdl','wsdl');
$response= $client->call('registerCustomer',$param);
}

if($choice==2)
{
$client=new nusoap_client('http://127.0.0.1/bus/serverside.php?wsdl','wsdl');
$response= $client->call('viewtrips');
}

if($choice==3)
{
$param=array('cust_Id' =>"3",'trip_Id' =>"8");
$client=new nusoap_client('http://127.0.0.1/bus/serverside.php?wsdl','wsdl');
$response= $client->call('booktrip',$param);
}

if($choice==4)
{
$param=array('trip_Id' =>"2",'cust_Id'=>"2");
$client=new nusoap_client('http://127.0.0.1/bus/serverside.php?wsdl','wsdl');
$response= $client->call('changedestination',$param);
}

echo"Result:<br/>";
print_r($response);
?>
