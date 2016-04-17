<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Card;
use App\Contact;

class VisaAuthenticateController extends Controller
{
	//placeholders for privkey/certpath
	private $_str_privatekey = '/home/alienhax/Documents/emerge2016/keys2/cert.pem';
	private $_str_certificatepath = '/home/alienhax/Documents/emerge2016/keys2/key_test2.pem';
	protected $int_uid; 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    		
    		$arr_creds = $request->only('user_id', 'password','uid_from','uid_to','amount');

    		//user & card objects
    		$obj_user_from = User::where('id',$arr_creds['uid_from'])->firstOrFail();
    		$obj_user_to = User::where('id',$arr_creds['uid_to'])->firstOrFail();
    		$obj_card_from = Card::where('uid', $obj_user_from->id)->firstOrFail();
    		$obj_card_to = Card::where('uid',$obj_user_to->id)->firstOrFail();

    		$time = time();
		$str_url = 'https://sandbox.api.visa.com/visadirect/fundstransfer/v1/pullfundstransactions';
		$str_userId = $arr_creds['user_id'];
		$str_password = $arr_creds['password'];
		$str_request_body_string = json_encode([
			'systemsTraceAuditNumber' => 300259,
			'retrievalReferenceNumber' => '407509300259',
			'localTransactionDateTime' => '2016-02-12T16:22:13',
			'acquiringBin' => $obj_card_from->acquiringBin, //409999,
			'acquirerCountryCode' => $obj_card_from->acquirerCountryCode, //'101',
			'senderPrimaryAccountNumber' => $obj_card_from->CardNumber, //'4957030100009952',
			'senderCardExpiryDate' => $obj_card_from->expirationData, //'2020-03',
			'senderCurrencyCode' => $obj_card_from->currencyCode, //'USD',
			'amount' => $arr_creds['amount'],
			'surcharge' => '2.00',
			'cavv' => '0000010926000071934977253000000000000000',
			'foreignExchangeFeeTransaction' => '10.00',
			'businessApplicationId' => 'AA',
			'merchantCategoryCode' => 6012,
			'cardAcceptor' => [
			'name' => $obj_user_to->name, //'Saranya',
			'terminalId' => '365539',
			'idCode' => 'VMT200911026070',
			'address' => [
			'state' => $obj_user_to->state, //'CA',
			//'county' => '081',
			'country' => $obj_user_to->country, //'USA',
			'zipCode' => $obj_user_to->zipcode //'94404'
			]
		],
		'magneticStripeData' => [
		'track1Data' => '1010101010101010101010101010'
		],
		'pointOfServiceData' => [
		'panEntryMode' => '90',
		'posConditionCode' => '0',
		'motoECIIndicator' => '0'
		],
		'pointOfServiceCapability' => [
		'posTerminalType' => '4',
		'posTerminalEntryCapability' => '2'
		],
		'feeProgramIndicator' => '123'
		] );

		$str_auth = "{$str_userId}:{$str_password}";
		$str_authbytes = utf8_encode($str_auth);
		$str_auth_login = base64_encode($str_authbytes);
		$str_auth_header = "Authorization:Basic {$str_auth_login}";
		echo "<strong>URL:</strong><br>{$str_url}<br><br>";
		$arr_header = (array("Accept: application/json", "Content-Type: application/json", $str_auth_header));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $str_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $arr_header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $str_request_body_string); 
		curl_setopt($ch, CURLOPT_SSLCERT, $this->_str_certificatepath);
		curl_setopt($ch, CURLOPT_SSLKEY, $this->_str_privatekey);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//getting response from server
		$response = curl_exec($ch);
		if(!$response) {
			die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
		}
		echo "<strong>HTTP Status:</strong> <br>".curl_getinfo($ch, CURLINFO_HTTP_CODE)."<br><br>";
		curl_close($ch);
		$json = json_decode($response);
		$json = json_encode($json, JSON_PRETTY_PRINT);
		printf("<pre>%s</pre>", $json);
		exit();  
    }



    public function pushfunds(Request $request)
    {
    		
    		//user_id/password = visa api user_id/password
    		//uid_from/to = ids from users tbl
    		$arr_creds = $request->only('user_id', 'password','uid_from','uid_to','amount');

    		//user & card objects
    		$obj_user_from = User::where('id',$arr_creds['uid_from'])->firstOrFail();
    		$obj_user_to = User::where('id',$arr_creds['uid_to'])->firstOrFail();
    		$obj_card_from = Card::where('uid', $obj_user_from->id)->firstOrFail();
    		$obj_card_to = Card::where('uid',$obj_user_to->id)->firstOrFail();

    		
    		$time = time();
		$str_url = 'https://sandbox.api.visa.com/visadirect/fundstransfer/v1/pushfundstransactions';
		$str_userId = $arr_creds['user_id'];
		$str_password = $arr_creds['password'];

			

		$str_request_body_string = json_encode([
			"acquirerCountryCode" => $obj_card_from->acquirerCountryCode,
			  "acquiringBin" => $obj_card_from->acquiringBin,
			  "amount" => $arr_creds['amount'],
			  "businessApplicationId" => "AA",
			  "cardAcceptor" => array(
			    "address" => array(
			      "country" => $obj_user_to->country,
			      //"county" => $arr_creds['county'],
			      "state" => $obj_user_to->state,
			      "zipCode" => $obj_user_to->zipcode
			    ),
			    "idCode" => "CA-IDCode-77765",
			    "name" => "Visa Inc. USA-Foster City",
			    "terminalId" => "TID-9999"
			  ),
			  "localTransactionDateTime" => "2016-04-17T00:52:10",
			  "merchantCategoryCode" => "6012",
			  "pointOfServiceData" => array(
			    "motoECIIndicator" => "0",
			    "panEntryMode" => "90",
			    "posConditionCode" => "00"
			  ),
			  "recipientName" => $obj_user_to->name,
			  "recipientPrimaryAccountNumber" => $obj_card_to->CardNumber,
			  "retrievalReferenceNumber" => "412770451018", //?
			  "senderAccountNumber" => $obj_card_from->CardNumber,
			  "senderAddress" => $obj_user_from->address1,
			  "senderCity" => $obj_user_from->city,
			  "senderCountryCode" => "124",
			  "senderName" => $obj_user_from->name,
			  "senderReference" => "",
			  "senderStateCode" => $obj_user_from->state,
			  "sourceOfFundsCode" => "05",
			  "systemsTraceAuditNumber" => "451018",
			  "transactionCurrencyCode" => $obj_card_to->currencyCode,
			  "transactionIdentifier" => "381228649430015"
			
		] );

		$str_auth = "{$str_userId}:{$str_password}";
		$str_authbytes = utf8_encode($str_auth);
		$str_auth_login = base64_encode($str_authbytes);
		$str_auth_header = "Authorization:Basic {$str_auth_login}";
		echo "<strong>URL:</strong><br>{$str_url}<br><br>";
		$arr_header = (array("Accept: application/json", "Content-Type: application/json", $str_auth_header));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $str_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $arr_header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $str_request_body_string); 
		curl_setopt($ch, CURLOPT_SSLCERT, $this->_str_certificatepath);
		curl_setopt($ch, CURLOPT_SSLKEY, $this->_str_privatekey);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//getting response from server
		$response = curl_exec($ch);
		if(!$response) {
			die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
		}
		echo "<strong>HTTP Status:</strong> <br>".curl_getinfo($ch, CURLINFO_HTTP_CODE)."<br><br>";
		curl_close($ch);
		$json = json_decode($response);
		$json = json_encode($json, JSON_PRETTY_PRINT);
		printf("<pre>%s</pre>", $json);
		exit();  
    }


    public function dashboard($id)
    {
        //$arr_credentials = $request->only('uid');

        //user & card objects
        $obj_user = User::where('id',$id)->firstOrFail();
        $obj_cards = Card::where('uid', $obj_user->id)->firstOrFail();

        return json_encode(array('user' => $obj_user,'cards' => $obj_cards));        
    }

    public function contacts($id)
    {
        //$arr_credentials = $request->only('uid');

        //user & card objects
		$obj_users = User::select('SELECT U2.* FROM users U1 INNER JOIN contacts C ON U1.id = C.uid INNER JOIN users U2 ON C.cid = U2.id WHERE U1.id = ?',[$id]);
        //$obj_user = User::where('id',$id)->join('','')->firstOrFail();
        //$obj_contacts = Contact::where('uid', $obj_user->id)->firstOrFail();

        return json_encode(array('users' => $obj_users));        
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
