<?php

use Andrewbo\Robinhood\Robinhood;

$robinhood = new Robinhood('username', 'password');

$accounts = $robinhood->getAccounts();

foreach ($accounts as $account) {
	var_dump($account->buying_power);
}