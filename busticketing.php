/*
	Holla: DeetechApps [at] Gmail dot Com
	Twitter  @Devdeekey
*/

<?php
include ('lib/nusoap.php');
ini_set("display errors",0);
$phone_number=$_GET['MSISDN'];
$session_id=$_GET['SESSION_ID'];
$service_code=$_GET['SERVICE_CODE'];
$ussd_string=$_GET['USSD_STRING'];
$phone=$phone_number;
//set default level to zero
$level=0;
$ussd_string=str_replace("#","*",$ussd_string);
$ussd_string_exploded=explode("*",$ussd_string);
$ussd_exploded2=array_shift($ussd_string_exploded);

$phone=$phone_number;

//get level id from ussd_reply
$level=count($ussd_string_exploded);


if($level==0)
{
display_menu();
}

if($level>0)
{
	switch($ussd_string_exploded[0])
	{
	case 1: registerCustomer
		($ussd_string_exploded,$phone);
		break;
	case 2:	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
		$response=$client->call('viewtrips');
		print_r($response);
		break;
	case 3:	booktrip($ussd_string_exploded,$phone);
		break;
	case 4: changedestination
		($ussd_string_exploded,$phone);
		break;
	}	
}
//display menu function
function display_menu()
{
$ussd_text=("1.View Bus Schedule\n2.Book Trip\n3.Change Trip\n4. Cancel Trip");
ussd_proceed($ussd_text);

}

function registerCustomer($details,$phone)
{

	if (count($details)==1)
	{
	$ussd_text="Please enter your Name and ID number separated by commas";
	ussd_proceed($ussd_text);
	}

	if(count($details)==2)
	{
	$data=explode(",",$details[1]);
	$name=$data[0];
	$id=$data[1];
	$param=array('ID'=>$id,'Name'=>$name,'Phone_Number'=>$phone);
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('registerCustomer',$param);
	$error=$client->getError();
		if($error)
		{
		echo "error".$error;
		//print_r($client->response());
		print_r($client->getDebug());
		die();
		}
	print_r($response);
	}

}

//book trip function
function booktrip($details,$phone)
{

	if (count($details)==1)
	{
	$ussd_text="Please enter your Name,ID number and route separated by commas";
	ussd_proceed($ussd_text);
	}

	if(count($details)==2)
	{
	$data=explode(",",$details[1]);
	$customer_id=$data[0];
	$route=$data[1];
	$param=array('customer_Id'=>$customer_id,'route'=>$route);
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('booktrip',$param);
	$error=$client->getError();
		if($error)
		{
		echo "error".$error;
		//print_r($client->response());
		print_r($client->getDebug());
		die();
		}
	print_r($response);
	}

}

function changedestination($details,$phone)
{
	if(count($details)==1)
	{
	$ussd_text="please input your ID number and the new route separated by commas";
	ussd_proceed($ussd_text);
	}
	if(count($details==2))
	{
	$change=explode(",",$details[1]);
	$param=array('Customer_id'=>$change[0],'route'=>$change[1]);
	$client=new nusoap_client('http://127.0.0.1/bus/serverside.php');
	$response=$client->call('changedestination',$param);
	$error=$client->getError();
		if($error)
		{
		echo "error\n".$error;
		print_r($client->response());
		print_r($client->getDebug());
		die();
		}
	print_r($response);
	}
}
//ussd proceed function
function ussd_proceed($ussd_text)
{
echo nl2br($ussd_text);
exit(0);
}

//ussd stop function
function ussd_stop($ussd_text)
{
echo nl2br("END $ussd_text");
exit(0);
}

?>

