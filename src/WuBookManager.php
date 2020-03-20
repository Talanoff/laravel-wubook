<?php

/*
 * This file is part of Laravel WuBook.
 *
 * (c) Filippo Galante <filippo.galante@b-ground.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Talanoff\LaravelWubook;

use Arr;
use fXmlRpc\Client;
use fXmlRpc\Parser\NativeParser;
use fXmlRpc\Serializer\NativeSerializer;
use Talanoff\LaravelWubook\Api\WuBookAuth;
use Talanoff\LaravelWubook\Api\WuBookAvailability;
use Talanoff\LaravelWubook\Api\WuBookCancellationPolicies;
use Talanoff\LaravelWubook\Api\WuBookChannelManager;
use Talanoff\LaravelWubook\Api\WuBookCorporateFunctions;
use Talanoff\LaravelWubook\Api\WuBookExtras;
use Talanoff\LaravelWubook\Api\WuBookPrices;
use Talanoff\LaravelWubook\Api\WuBookReservations;
use Talanoff\LaravelWubook\Api\WuBookRestrictions;
use Talanoff\LaravelWubook\Api\WuBookRooms;
use Talanoff\LaravelWubook\Api\WuBookTransactions;
use Talanoff\LaravelWubook\Exceptions\WuBookException;

/**
 * This is the WuBook manager class.
 *
 * @author Filippo Galante <filippo.galante@b-ground.com>
 */
class WuBookManager
{

    /**
     * @var string
     */
    const ENDPOINT = 'https://wired.wubook.net/xrws/';

    /**
     * @var array
     */
    private $config;

    /**
     * @var mixed
     */
    private $cache;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $provider_key;

    /**
     * @var mixed
     */
    private $client;

    /**
     * Create a new WuBook Instance.
     *
     * @param $config
     * @throws WuBookException
     */
    public function __construct($config)
    {
        // Setup credentials
        $this->config = Arr::only($config->get('wubook'), ['username', 'password', 'provider_key', 'lcode']);

        // Credentials check
        if (!array_key_exists('username', $this->config) || !array_key_exists('password', $this->config) || !array_key_exists('provider_key', $this->config) || !array_key_exists('lcode', $this->config)) {
            throw new WuBookException('Credentials are required!');
        }

        if (!array_key_exists('cache_token', $this->config)) {
            $this->config['cache_token'] = false;
        }

        // Utilities
        $this->cache = app()['cache'];
    }

    /**
     * Auth API
     *
     * @return WuBookAuth
     */
    public function auth()
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookAuth($this->config, $this->cache, $client);
    }

    /**
     * Availability API
     *
     * @param string $token
     * @return WuBookAvailability
     */
    public function availability($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookAvailability($this->config, $this->cache, $client, $token);
    }

    /**
     * Cancellation polices API
     *
     * @param string $token
     * @return WuBookCancellationPolicies
     */
    public function cancellation_policies($token = null)
    {
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookCancellationPolicies($this->config, $this->cache, $client, $token);
    }

    /**
     * Channel manager API
     *
     * @param string $token
     * @return WuBookChannelManager
     */
    public function channel_manager($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookChannelManager($this->config, $this->cache, $client, $token);
    }

    /**
     * Corporate function API
     *
     * @param string $token
     * @return WuBookCorporateFunctions
     */
    public function corporate_functions($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookCorporateFunctions($this->config, $this->cache, $client, $token);
    }

    /**
     * Extra functions API
     *
     * @param string $token
     * @return WuBookExtras
     */
    public function extras($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookExtras($this->config, $this->cache, $client, $token);
    }

    /**
     * Prices API
     *
     * @param string $token
     * @return WuBookPrices
     */
    public function prices($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookPrices($this->config, $this->cache, $client, $token);
    }

    /**
     * Reservations API
     *
     * @param string $token
     * @return WuBookReservations
     */
    public function reservations($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookReservations($this->config, $this->cache, $client, $token);
    }

    /**
     * Restrictions API
     *
     * @param string $token
     * @return WuBookRestrictions
     */
    public function restrictions($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookRestrictions($this->config, $this->cache, $client, $token);
    }

    /**
     * Rooms API
     *
     * @param string $token
     * @return WuBookRooms
     */
    public function rooms($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookRooms($this->config, $this->cache, $client, $token);
    }

    /**
     * Transactions API
     *
     * @param string $token
     * @return WuBookTransactions
     */
    public function transactions($token = null)
    {
        // Setup client
        $client = new Client(self::ENDPOINT, null, new NativeParser(), new NativeSerializer());

        return new WuBookTransactions($this->config, $this->cache, $client, $token);
    }

    /**
     * Username getter.
     *
     * @return string
     */
    public function get_username()
    {
        return $this->username;
    }

    /**
     * Password getter.
     *
     * @return string
     */
    public function get_password()
    {
        return $this->password;
    }

    /**
     * Provider key getter.
     *
     * @return string
     */
    public function get_provider_key()
    {
        return $this->provider_key;
    }

    /**
     * @return mixed
     */
    public function get_client()
    {
        return $this->client;
    }
}
