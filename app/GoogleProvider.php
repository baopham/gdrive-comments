<?php

namespace App;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Two\InvalidStateException;

/**
 * Class GoogleProvider
 * @package App
 */
class GoogleProvider extends \Laravel\Socialite\Two\GoogleProvider
{

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        if ($this->hasInvalidState()) {
            throw new InvalidStateException;
        }

        $tokenInfo = $this->getAccessTokenInfo($this->getCode());

        $user = $this->mapUserToObject($this->getUserByToken(
            $token = $tokenInfo->access_token
        ));

        return $user->setToken($tokenInfo);
    }

    /**
     * @param $code
     * @return object
     */
    public function getAccessTokenInfo($code)
    {
        $postKey = (version_compare(ClientInterface::VERSION, '6') === 1) ? 'form_params' : 'body';

        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            $postKey => $this->getTokenFields($code),
        ]);

        return json_decode($response->getBody());
    }
}
