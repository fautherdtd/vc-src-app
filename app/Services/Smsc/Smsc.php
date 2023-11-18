<?php

namespace App\Services\Smsc;

use GuzzleHttp\Client;

class Smsc
{

    /**
     * @param $param
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function make($param)
    {
        $client = new Client([
            'base_uri' => 'https://smsc.ru/rest/',
            'timeout'  => 2.0,
        ]);

        $result = $client->post('send/', [
            'json' => [
                'login' => 'Nike050',
                'psw' => 'ugKk5wste6',
                'phones' => $param['phone'],
                'mes' => $param['message'],
                'fmt' => 3
            ]
        ]);
        return json_decode($result->getBody(), JSON_OBJECT_AS_ARRAY);
    }
}
