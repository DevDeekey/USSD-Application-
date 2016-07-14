<?php
include ('lib/nusoap.php');

$sender = $_GET['sender'] ;
$msg = $_GET['message'] ;
if(empty($msg))
{
	$response="You have not entered any text";
	print_r ($response);
}

if($msg=="info")
{

	$response = "To view bus schedule sms the word 'view'.\n To Book a trip sms the word 'book' followed by your name, ID number and route separated by commas.\nTo change destination, sms the word 'change'  followed by your ID number and new route.";
	echo  nl2br($response);
}
/*
if($msg=="register")
{
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('registerCustomer');
	print_r ($response);
}
*/
if($msg=="view")
{
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('viewtrips');
	print_r ($response);
}
/*
if($msg=="book")
{
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('booktrip');
	print_r ($response);
}

if($msg=="change")
{
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('changedestination');
	print_r ($response);
}

*/

echo getResponse($msg,$sender);

function getResponse($msg,$sender)
{
	$smsresults=explode("#",$msg);
	
	if ($smsresults [0]=="register")
	{
	$param=array('ID'=>$smsresults [1],'Name' =>$smsresults [2],'Phone_Number' =>$sender);
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('registerCustomer',$param);
	$error=$client->getError();
		if($error)
		{
		echo "error".$error;
		print_r($client->response());
		print_r($client->getDebug());
		die();
		}
	print_r($response);
	}
	/*
	else if ($smsresults [0]=="view")
	{
	$param=array('trip_Id'=>$smsresults[1],'route'=>$smsresults[2],'departure_time'=>$smsresults[3],'arrival_time'=>$smsresults[4],'cost'=>$smsresults[3]);
	$client=new nusoap_client('http://127.0.0.1/bus/serveside.php');
	$response=$client->call('viewtrips',$param);
	$error=$client->getError();
		if($error)
		{
		echo "error".$error;
		print_r($client->response());
		print_r($client->getDebug());
		die();
		}
	print_r($response);
	}*/
	
	
	else if ($smsresults [0]=="book")
	{
	$param=array('cust_Id' =>$smsresults[1],'trip_Id' =>$smsresults[2]);
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('booktrip',$param);
	$error=$client->getError();
		if($error)
		{
		echo "error".$error;
		print_r($client->response());
		print_r($client->getDebug());
		die();
		}
	print_r($response);
	}

	else if($smsresults[0]=="change")
	{

	$param=array('customer_id'=>$smsresults[1],'route'=>$smsresults[2]);
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('changedestination',$param);
	$error=$client->getError();
		if($error)
		{
		echo "error".$error;
		print_r($client->response());
		print_r($client->getDebug());
		die();
		}
	print_r($response);
	}	
}
?>

