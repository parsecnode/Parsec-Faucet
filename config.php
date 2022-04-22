<?php
/*
Faucet Originally by Ratnet - Made in México - 2015

Donations to Lightyear Personal Wallet for Developing:

Changes for PARS by Parsec Node team 2022, Lightyear

Parsec Dev team donation wallet:
Kdev1L9V5ow3cdKNqDpLcFFxZCqu5W2GE9xMKewsB2pUXWxcXvJaUWHcSrHuZw91eYfQFzRtGfTemReSSMN4kE445i6Etb3

*/

$faucetTitle      = "Кран карбованців";
$faucetSubtitle   = "Кожні 12 год. можна отримати безкоштовні карбованці";
$logo             = "images/parsec.png";

// Address for RPC client
$jsonrpc_server = 'http://127.0.0.1:8070/json_rpc';

//Faucet address for donations
$faucetAddress    = "";

// Transaction for 1 fee and divider to convert atomic currency units to PARS
$transactionFee   = 100000000;
$dividirEntre     = 1000000000000;

//Reward time in hours
$rewardEvery      = "12";

//Max reward and min reward as decimals, e.g. Min = 10.0 & Max = 20.0
$minReward        = "0.1";
$maxReward        = "1";

//Database connection
$hostDB           = "127.0.0.1";
$database         = "";
$userDB           = "";
$passwordDB       = "";

//Recaptcha Keys. You can get yours here: https://www.google.com/recaptcha/
$keys             = array(
		'site_key' => '',
		'secret_key' => ''
);

//Addresses that can request more than one time but with a different payment ID.
$clearedAddresses = array( 
/*
*/ );
?>
