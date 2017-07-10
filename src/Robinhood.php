<?php

namespace Andrewbo\Robinhood;

use Andrewbo\Robinhood\Entities\Account;

class Robinhood extends Api {

	/**
	 * Robinhood constructor.
	 *
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($username, $password)
	{
		parent::__construct();
		return $this->login($username, $password);
	}

	/**
	 * @param string $username
	 * @param string $password
	 *
	 * @return bool
	 */
	private function login($username, $password)
	{
		return $this->makeRequest(self::ENDPOINT_AUTH, [
			'username' => (string) $username,
			'password' => (string) $password,
		]);
	}

	/**
	 * Return all User accounts
	 *
	 * @return array[Account]
	 */
	public function getAccounts()
	{
		$return = [];
		$accounts = $this->makeRequest(self::ENDPOINT_ACCOUNTS);
		foreach ($accounts as $account) {
			$return[] = new Account($account);
		}

		return $return;
	}

	/**
	 * Return specific User account
	 *
	 * @param string $account_url
	 *
	 * @return Account
	 */
	public function getAccount($account_url) {
		return new Account(
			$this->makeRequest($account_url)
		);
	}



}