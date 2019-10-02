<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/29
 * Time: 13:55
 */

namespace App\Admin\Controllers;


use Encore\Admin\Controllers\AdminController;
use GuzzleHttp\Client;


class BaseController
{
    /**
     * @param $method
     * @param string $url
     * @param array $json
     * @param array $header
     * @return array
     * 发送请求
     */
    public function sendRequest($method,$url='',array $json=[],array $header=[]){

        $base_params = [
            'base_uri' => env('API_SERVICE_DOMAIN'),
            //'timeout' => 2.0
        ];
        $client = new Client($base_params);

        $token = ['token'=>session('token')];//认证信息
        $header = empty($header) ? $token : array_merge($header,$token);

        $params = ['json'=>$json,'headers'=>$header];
        $response = $client->request($method,$url,$params);
        /*$data = [
            'code'=>$response->getStatusCode(),
            'message'=>$response->getReasonPhrase(),
            'data'=>json_decode($response->getBody()->getContents(),true)
        ];*/

        return json_decode($response->getBody()->getContents(),true);
    }

    public function post($body,$apiStr)
    {
        $client = new Client(['base_uri' => 'http://114.67.231.162/api/']);
        $res = $client->request('POST', $apiStr,
            ['json' => $body,
             'headers' => [
                 'Content-type'=> 'application/json',
                 //                'Cookie'=> 'XDEBUG_SESSION=PHPSTORM',
                 "Accept"=>"application/json"]
            ]);
        $data = $res->getBody()->getContents();

        return $data;
    }

    public function get($apiStr,$header)
    {
        $header =[
        'Content-type'=> 'application/json'
            ];
        $client = new Client(['base_uri' => env('API_SERVICE_DOMAIN')]);
        $res = $client->request('GET', $apiStr,['headers' => $header]);
        $statusCode= $res->getStatusCode();

        $header= $res->getHeader('content-type');

        $data = $res->getBody();

        return $data;
    }


    /**
     * 积分制，[加减积分，并发送万里牛]
     * @param $method
     * @param $url
     * @param $integral
     */
    public function httpByIntegral($method,$url,$integral)
    {
        //$http = $this->sendRequest("GET",'crm/open/customer/querycustom');
        $http = $this->sendRequest($method,$url);
        var_dump($integral);exit;
    }
}
