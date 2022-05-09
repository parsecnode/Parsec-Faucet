<?php
/*
Faucet Originally by Ratnet - Made in México - 2015

Donations to Lightyear Personal Wallet for Developing:

Changes for PARS by Parsec Node 2022, Lightyear

Parsec Dev team donation wallet:
PARSkAmcBG8ZWqgfCu65fddB1yxzbTpGF6wzyLBsTUmoJUd1WmB8Bgj9h9LGbmVQEEEYAFHVJCWCVBEeEfsbK5ay6tSDmDup7i

*/

$faucetTitle      = "Parsec Faucet";
$faucetSubtitle   = "Every 12 hours you can get free Parsec (PARS)";
$logo             = "images/parsec.png";

// Address for RPC client
$jsonrpc_server = 'http://127.0.0.1:8070/json_rpc';

//Faucet address for donations
$faucetAddress    = "PARSkH3DLhkLLhtVWPBRkfXMVJdHFKPfr4kZLxenw4soT1NnCAtwLVEb61NQsHSFr7CHRUBQRW9UpTbphdEAaA926dwnyozsbh";

// Transaction for 1 fee and divided to convert atomic currency units to PARS
$transactionFee   = 100000000;
$dividirEntre     = 1000000000000;

//Reward time in hours
$rewardEvery      = "12";

//Max reward and min reward as decimals, e.g. Min = 10.0 & Max = 20.0
$minReward        = "0.1";
$maxReward        = "1";

//Database connection
$hostDB           = "127.0.0.1";
$database         = "faucetdb";
$userDB           = "parsecfaucet";
$passwordDB       = "9@rs3cfaucet54";

//Recaptcha Keys. You can get yours here: https://www.google.com/recaptcha/
$keys             = array(
		'site_key' => '6LfXEs0fAAAAAB3Ib6-hicPPaPk-kNsgByUPd7wx',
		'secret_key' => '6LfXEs0fAAAAALvz06wm0WdCTUfInFftRENNDBkp'
);

//Addresses that can request more than one time but with a different payment ID.
$clearedAddresses = array( 
/*
*/ );
?>
