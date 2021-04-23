<?php

namespace App\Http\Services;

class SmsSendService
{
    public function sendSms($phone_number, $verification_code) {
        $stack = \GuzzleHttp\HandlerStack::create();
        $oauth_middleware = new \GuzzleHttp\Subscriber\Oauth\Oauth1([
            'consumer_key'    => 'OCA40ZiGn11IQodZS6QiON09',
            'consumer_secret' => 'DggN8IC3PjyEC3!BD(n(eS^nbrLnlWN^YtSPVJai',
            'token'           => 'ONGYhp9dSEKHWUukIjjdPZTFdhGwCLP0WkTf647urKJxiIq-tla8C0RLssrLxjZr',
            'token_secret'    => ''
        ]);
        $stack->push($oauth_middleware);
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://gatewayapi.com/rest/',
            'handler'  => $stack,
            'auth'     => 'oauth'
        ]);

        $req = [
            'sender'     => 'euroway2go',
            'recipients' => [['msisdn' => (int)$phone_number]],
            'message'    => (string)$verification_code,
        ];
        $client->post('mtsms', ['json' => $req]);
    }
}