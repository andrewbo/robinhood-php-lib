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
	 * Places an order in RH.
	 *
	 * @param array $args
	 * @return array
	 */
	private function _placeOrder($args)
	{
		return $this->makeRequest(self::ENDPOINT_ORDERS, [
			'account' 		=> (string) $args['account_url'],
			'instrument' 	=> (string) $args['instrument_url'],
			'price'			=> (float) $args['bid_price'],
			'quantity'		=> (int) $args['quantity'],
			'side'			=> (string) $args['transaction'],
			'symbol'		=> (string) $args['symbol'],
			'time_in_force'	=> (string) ( isset($args['time']) ? $args['time'] : 'gfd' ),
			'trigger'		=> (string) ( isset($args['trigger']) ? $args['trigger'] : 'immediate' ),
			'type'			=> (string) ( isset($args['type']) ? $args['type'] : 'market' )
			]);
	}


	/**
	 * Place a BUY order in RH.
	 *
	 * @param array $args
	 * @return array
	 */
	public function placeBuyOrder($args)
	{
		$args['transaction'] = 'buy';
		return $this->_placeOrder($args);
	}


	/**
	 * Place a SELL order in RH.
	 *
	 * @param array $args
	 * @return array
	 */
	public function placeSellOrder($args)
	{
		$args['transaction'] = 'sell';
		return $this->_placeOrder($args);
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


	/**
	 * Executes a Robinhood API request by taking either the endpoint slug
	 * or a fully constructed $uri.
	 *
	 * @param string $uri
	 * @return array
	 */
	public function makeApiRequest($uri) {
		return $this->makeRequest($uri);
	}



}