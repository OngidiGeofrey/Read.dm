<?php
<?php
date_default_timezone_set('Africa/Nairobi');

# access token
$consumerKey = 'mUyHRHaTbxQMfWTdwQF3xBPoYZHAPTRq'; 
$consumerSecret = 'l0yGAiLzTBS96oHw'; 

# define the variales
$BusinessShortCode = '174379';
$Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

    //cleanup the phone number and remove unecessary symbols
    $tel=254769414159; //
    //$tel=$_POST['telephone_number'];
    $tel = str_replace("-", "", $tel);
    $tel = str_replace( array(' ', '<', '>', '&', '{', '}', '*', "+", '!', '@', '#', "$", '%', '^', '&'), "", $tel );
	$phoneNumber = "254".substr($tel, -9);

    echo $phoneNumber;


$phoneNumber = $phoneNumber; // This is my phone number, 
$AccountReference = 'KweyuWebsite';
$TransactionDesc = 'Testing';

  $Amount ='2';
//$Amount =$_POST['amount'];
$Timestamp = date('YmdHis');    
$Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);
$credentials=base64_encode($consumerKey.':'.$consumerSecret);


# header for access token
$headers = ['Content-Type:application/json; charset=utf8'];

# M-PESA endpoint urls
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

# callback url
$CallBackURL = 'https://theprimehouse.co.ke/darajaC2B/callBackUrl.php'; 

$ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic '.$credentials]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
$result=json_decode($response);
$token=$result->access_token;
curl_close($ch);

//print_r($token);
# header for stk push
$stkheader = ['Content-Type:application/json','Authorization:Bearer '.$token];

# initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $initiate_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);

$curl_post_data = array(
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'TransactionType' => 'CustomerPayBillOnline',
  'Amount' => $Amount,
  'PartyA' => $BusinessShortCode,
  'PartyB' => $BusinessShortCode,
  'PhoneNumber' =>$phoneNumber ,
  'CallBackURL' => $CallBackURL,
  'AccountReference' => $AccountReference,
  'TransactionDesc' => $TransactionDesc
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);
//print_r($curl_response);

echo $curl_response;
?>
?>
<form class="contact2-form validate-form" action="#" method="post">
   <input type="hidden" name="Check_request_ID" value="<?php echo $curl_Tranfer2_response->Check_request_ID ?>">
   </br></br>
   <button class="contact2-form-btn" style="margin-bottom: 30px;">Confirm Payment is Complete</button>
</form>
