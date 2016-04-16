<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VisaAuthenticateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    		
    		$arr_creds = $request->only('user_id', 'password');

    		$time = time();
		$str_url = 'https://sandbox.api.visa.com/visadirect/fundstransfer/v1/pullfundstransactions';
		$str_certificatepath = '/home/alienhax/Documents/emerge2016/keys/cert.pem';
		$str_privatekey = '/home/alienhax/Documents/emerge2016/keys/privateKey.pem';
		$str_userId = $arr_creds['user_id'];
		$str_password = $arr_creds['password'];
		$str_request_body_string = json_encode([
			'systemsTraceAuditNumber' => 300259,
			'retrievalReferenceNumber' => '407509300259',
			'localTransactionDateTime' => '2016-02-12T16:22:13',
			'acquiringBin' => 409999,
			'acquirerCountryCode' => '101',
			'senderPrimaryAccountNumber' => '4957030100009952',
			'senderCardExpiryDate' => '2020-03',
			'senderCurrencyCode' => 'USD',
			'amount' => '110',
			'surcharge' => '2.00',
			'cavv' => '0000010926000071934977253000000000000000',
			'foreignExchangeFeeTransaction' => '10.00',
			'businessApplicationId' => 'AA',
			'merchantCategoryCode' => 6012,
			'cardAcceptor' => [
			'name' => 'Saranya',
			'terminalId' => '365539',
			'idCode' => 'VMT200911026070',
			'address' => [
			'state' => 'CA',
			'county' => '081',
			'country' => 'USA',
			'zipCode' => '94404'
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
		curl_setopt($ch, CURLOPT_SSLCERT, $str_certificatepath);
		curl_setopt($ch, CURLOPT_SSLKEY, $str_privatekey);
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
