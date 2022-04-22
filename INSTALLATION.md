# Parsec Faucet

This faucet runs on a Linux environment with PHP and MYSQL, and it was tested on:
1) Ubuntu 15.04 with PHP 5.6.4 and MariaDB 5.5 (original faucet)
2) Debian 9 + PHP 7 + MariaDB (latest version)

Faucet is set to work on the same server with Parsec CLI (simplewallet+parsecd for local blockchain usage or just simplewallet for remote node).

## How to install
First of all you need to create a new database and create this table on it for the faucet to save all requests:

```mysql
CREATE TABLE IF NOT EXISTS `payouts` (
`id` bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `payout_amount` double NOT NULL,
  `payout_address` varchar(100) NOT NULL,
  `payment_id` varchar(75) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
```

After you create database you need to edit config.php with all your custom parameters and also database information.

Now there is two options what to do next:
1. You're wish to use external master node (faucet will pay extra 0.25% fee to that node).

Run **simplewallet** with next command:

```bash
./simplewallet --wallet-file=wallet.bin --pass=password --rpc-bind-port=8070 --rpc-bind-ip=127.0.0.1 --daemon-host=<remote node address or ip> --daemon-port=<remote node port, default is 32616>
```

List of available remote nodes you can pick up [here](http://parsecnodes.com/nodelist.php).

2. You're wish to hold your own node.

First of all you need to run **parsecd** and wait until it will synchronize blockchain. To run daemon use command:
```bash
./parsecd --data-dir=<path to blockchain folder, e.g. /home/user/.parsec> --restricted-rpc --rpc-bind-ip=127.0.0.1, --rpc-bind-port=32616
```

After finished sync run **simplewallet** with command:

```bash
./simplewallet --wallet-file=wallet.bin --pass=password --rpc-bind-port=8070 --rpc-bind-ip=127.0.0.1 --daemon-host=127.0.0.1
```

*Note*: Run this command after you already created a wallet with simplewallet commands.

* wallet.bin needs to be the wallet file name that you enter when you created your wallet.
* password needs to be the password to open your wallet
* rpc-bind-port and rpc-bind-ip can be changed if so, you need to edit index.php and request.php (Please don't edit, as you may end opening the wallet rpc to the public)

To keep parsecd and simplewallet on background you can use screen command or dockerize it (http://docker.com/)

Advertisements can be edited on the index.php they are between this lines for an easy location:

           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->

After all this steps you should be ready to go ;)
