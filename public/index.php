<?php

use App\KanbanBoard\Application;
use App\KanbanBoard\Authentication;
use App\KanbanBoard\GithubClient;
use App\Utilities;
use Github\AuthMethod;
use Github\Client as ApiClient;

require __DIR__ . '/../vendor/autoload.php';

Utilities::loadEnv(__DIR__ . '/../.env');

$authenticate = new Authentication(
    Utilities::env('GH_CLIENT_ID'),
    Utilities::env('GH_CLIENT_SECRET'),
    'RS256'
);

$jwt=$authenticate->getJWT();

$client = new GithubClient(
    Utilities::env('GH_TOKEN'),
    $jwt,
    AuthMethod::JWT,
    Utilities::env('GH_ACCOUNT'));

$github = new ApiClient();

$github->authenticate(Utilities::env('GH_TOKEN'), $jwt,AuthMethod::JWT);

$repositories = explode('|', Utilities::env('GH_REPOSITORIES'));

$app = new Application($client, $repositories, ['waiting-for-feedback','paused']);

$board=$app->board();

$app->display('index',$board);