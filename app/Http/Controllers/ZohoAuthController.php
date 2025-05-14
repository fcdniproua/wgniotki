<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\ZohoOAuth;

class ZohoAuthController extends Controller
{
    public function auth()
    {
        $config = config('zoho');
        $clientId = env('ZOHO_CLIENT_ID');
        $redirectUri = env('ZOHO_REDIRECT_URI');
        $domain = env('ZOHO_API_DOMAIN');
        $scope = urlencode('ZohoMail.messages.CREATE,ZohoMail.accounts.READ');

        $url = "{$domain}/oauth/v2/auth?scope={$scope}&client_id={$clientId}&response_type=code&access_type=offline&prompt=consent&redirect_uri={$redirectUri}";
        return redirect($url);
    }

    public function callback(Request $request)
    {
        $code = $request->query('code');
        if (! $code) {
            return "Код авторизації не передано.";
        }

        $client = new Client();
        $domain = env('ZOHO_API_DOMAIN');

        $response = $client->post("{$domain}/oauth/v2/token", [
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'client_id'     => env('ZOHO_CLIENT_ID'),
                'client_secret' => env('ZOHO_CLIENT_SECRET'),
                'access_type'=> 'offline',
                'redirect_uri'  => env('ZOHO_REDIRECT_URI'),
                'code'          => $code,
            ],
        ]);

        $data = json_decode((string)$response->getBody(), true);
        var_dump($data);
        if (isset($data['access_token'])) {
            session(['zoho_mail_access_token' => $data['access_token']]);
            session(['zoho_mail_refresh_token' => $data['refresh_token'] ?? null]);

            return "Авторизація успішна!";
        }

        return "Помилка: " . ($data['error'] ?? 'невідома');
    }

    public function sendMail()
    {
        if (! session('zoho_mail_access_token')) {
            return redirect()->route('zoho.mail.auth');
        }

        $token = session('zoho_mail_access_token');
        $client = new Client();

        $res = $client->get('https://mail.zoho.com/api/accounts', [
            'headers' => [
                'Authorization' => "Zoho-oauthtoken {$token}",
            ]
        ]);

        $accounts = json_decode($res->getBody(), true);
        $accountId = $accounts['data'][0]['accountId'] ?? null;

        if (! $accountId) {
            return 'Не вдалося отримати accountId';
        }

        $response = $client->post("https://mail.zoho.com/api/accounts/{$accountId}/messages", [
            'headers' => [
                'Authorization' => "Zoho-oauthtoken {$token}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'fromAddress' => 'your_email@yourdomain.com', // має бути Zoho
                'toAddress' => ['someone@example.com'],
                'subject' => 'Привіт!',
                'content' => 'Це тестовий лист від Zoho API',
            ],
        ]);

        return $response->getBody();
    }
}
