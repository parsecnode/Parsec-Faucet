<?php
ini_set('max_execution_time', 20);
require_once 'classes/jsonRPCClient.php';
require_once 'classes/recaptcha.php';
require_once 'config.php';

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $faucetTitle; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="images/favicon.ico">
  <link rel="icon" type="image/icon" href="images/favicon.ico" >

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">

  <script>var isAdBlockActive=true;</script>
  <script src="js/advertisement.js"></script>
  <script>
  if (isAdBlockActive) { 
    window.location = "./adblocker.php"
  }
  </script>

  <script>
  <!-- PLACE GOOGLE ANALYTICS HERE -->
  </script>
  
</head>

<body>
	<div class="container">
		<div id="login-form">
			<h3><a href="./"><img src="<?php echo $logo; ?>" height="256"></a><br /><br /> <?php echo $faucetSubtitle; ?></h3>
			<fieldset>
				<!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
				
				<!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
				<br />
				<?php                  
					$parsec = new jsonRPCClient($jsonrpc_server);
					$balance = $parsec->getbalance();
					$balanceDisponible = $balance['available_balance'];
					$lockedBalance = $balance['locked_amount'];
					//$dividirEntre = 1000000000000;	// moved to config.php
					$totalPARS =  ($balanceDisponible+$lockedBalance)/$dividirEntre;

					$recaptcha = new Recaptcha($keys);
					//Available Balance
					$balanceDisponibleFaucet = number_format(round($balanceDisponible/$dividirEntre,12),12,'.', '');
				?>
				<form action="request.php" method="POST">
				<?php 
					if(isset($_GET['msg'])){
						$mensaje = $_GET['msg']; 
						if($mensaje == "captcha"){
				?>
						<div  id="alert" class="alert alert-error radius">
							Invalid Captcha, enter correct.
						</div>
				<?php 
						} else 
						if($mensaje == "wallet"){ 
				?>
							<div id="alert" class="alert alert-error radius">
							  Enter the correct Parsec wallet address 
							</div>
				<?php 
						}else 
						if($mensaje == "success"){ 
				?>
							<div class="alert alert-success radius">
							You Won <?php echo $_GET['amount']; ?> pars.<br/><br/>
							You will receive <?php echo $_GET['amount']-($transactionFee/$dividirEntre); ?> PARS. (Network Commission) <?php echo $transactionFee/$dividirEntre ?>)<br/>
							<a target="_blank" href="http://explorer.parsecnodes.com/?hash=<?php echo $_GET['txid']; ?>#blockchain_transaction">Check in the blockchain</a>
							</div>
				<?php } else 
						if($mensaje == "paymentID"){ 
				?>
							<div id="alert" class="alert alert-error radius">
							  Check your payment ID. <br>It must consist of 64 characters without special characters.
							</div>
				<?php } else 
						if($mensaje == "notYet"){ 
				?>
						<div id="alert" class="alert alert-warning radius">
						  Parsec (PARS) are issued every 12 hours. Come back later.
						</div>
				<?php } 
					} 
				?>
				<div class="alert alert-info radius">
				BALANCE: <?php echo $balanceDisponibleFaucet ?> PARS.<br>
				<?php
					$link = mysqli_connect($hostDB, $userDB, $passwordDB, $database);

					$query = "SELECT SUM(payout_amount) FROM `payouts`;";

					$result = mysqli_query($link, $query);
					$dato = mysqli_fetch_array($result);

					$query2 = "SELECT COUNT(*) FROM `payouts`;";

					$result2 = mysqli_query($link, $query2);
					$dato2 = mysqli_fetch_array($result2);

					mysqli_close($link);
				?>
				Handed out: <?php echo $dato[0]/$dividirEntre; ?> PARS. for <?php echo $dato2[0];?> VIP(s).
            </div>

            <?php 
				if($balanceDisponibleFaucet<1.0){ 
			?>
            <div class="alert alert-warning radius">
             The tap is empty or the balance is less than the win. <br> Come back later, &ndash; maybe someone will donate us a few parsec.
			</div>
			<?php 
				} elseif (!$link) {
					// $link = mysqli_connect($hostDB, $userDB, $passwordDB, $database);

					die('Connection error ' . mysql_error());
				}  else {  
			?>

           <input type="text" name="wallet" required placeholder="Parsec Address">

           <input type="text" name="paymentid" placeholder="Payment ID (Not necessary)" >
           <br/>
		   
           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
		   
           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
           
		   <br/>
           <?php 
				echo $recaptcha->render();     
           ?>

           <center><input type="submit" value="Get Free Parsec!"></center>
           <br>
           
		   <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
           
           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
           
		   <?php 
				} 
		   ?>
           
		   <br>
		     
		   <?php /*
			   <div class="table-responsive">
				<table class="table table-bordered table-condensed">
				  <thead>
					<tr>
					  <th><h6><b>Cleared Sites</b><br> <small>Sites that have their wallets allowed to request more than 1 time but only with a different payment id.</small></h6></th>
					</tr>
				  </thead>
				  <tbody>
					<?php foreach ($clearedAddresses as $key => $item) {
					  echo "<tr>
					  <th>".$key."</th>
					  </tr>";

					}?>
				  </tbody>
				</table>
			  </div>*/
		   ?>

          <div class="table-responsive">
            <h6><b>Last 5 replenishments</b></h6>
            <table class="table table-bordered table-condensed">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					$deposits = ($parsec->get_transfers());

					$transfers = array_reverse(($deposits["transfers"]),true);
					$contador = 0;
					foreach($transfers as $deposit){
					  if($deposit["output"] == ""){
						if($contador < 6){
						  $time = $deposit["time"];
						  echo "<tr>";
						  echo "<th>".gmdate("Y-m-d H:i:s", $time)."</th>";
						  echo "<th>".round($deposit["amount"]/$dividirEntre,8)."</th>";
						  echo "</tr>";
						  $contador++;
						}
					  }
					}
                ?>
              </tbody>
            </table>
          </div>
          <p style="font-size:10px;">Donate Parsec to support this tap. <br>Address: <?php echo $faucetAddress; ?><br>&#169; 2022 Faucet by <a href="https://github.com/parsecnode/Parsec-Faucet" target="_blank">Lightyear</a><br/></p></center>
          <footer class="clearfix">
          </footer>
        </form>

      </fieldset>
    </div> <!-- end login-form -->
  </div>


  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <?php if(isset($_GET['msg'])) { ?>
  <script>
  setTimeout( function(){ 
    $( "#alert" ).fadeOut(3000, function() {
    });
  }  , 10000 );
  </script>
  <?php } ?>

</body>
</html>
