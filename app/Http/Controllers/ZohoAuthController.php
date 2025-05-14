<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\ZohoOAuth;

class ZohoAuthController extends Controller
{
    public function generateAuthUrl()
    {
        $oauth = ZohoOAuth::getClientInstance();
        $url = $oauth->getGrantURL();

        return redirect($url);
    }

    public function callback(Request $request)
    {
        $code = $request->input('code');

        if ($code) {
            $oauth = ZohoOAuth::getClientInstance();
            $oauth->generateAccessToken($code);

            return "Авторизація успішна!";
        }

        return "Помилка авторизації.";
    }

    public function test()
    {
        try {
            $api = app('zoho');
            $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Leads");
            $response = $moduleIns->getRecords();

            dd($response->getData());
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}