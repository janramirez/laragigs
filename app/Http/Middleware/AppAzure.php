<?php

namespace App\Http\Middleware;


use App\Models\User;
use Microsoft\Graph\Graph;

use Microsoft\Graph\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RootInc\LaravelAzureMiddleware\Azure as Azure;

class AppAzure extends Azure
{
    protected function success(Request $request, $access_token, $refresh_token, $profile)
    {
        $graph = new Graph();
        $graph->setAccessToken($access_token);

        $graph_user = $graph->createRequest("GET", "/me")
                      ->setReturnType(Model\User::class)
                      ->execute();

        $email = strtolower($graph_user->getUserPrincipalName());

        $user = User::updateOrCreate(['email' => $email], [
            'name' => $graph_user->getGivenName() . ' ' . $graph_user->getSurname(),
        ]);

        Auth::login($user, true);

        return parent::success($request, $access_token, $refresh_token, $profile);
    }
}