<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version(['v1','v2'], [], function ($api) {
    /** accounts
     * list accounts + balances, transfers, deposit, withdrawal etc
    //*/
    $api->get('accounts/', '\btrade\Http\Controllers\Accounts@getAccountsAction');  // get all accounts

    $api->get('account/{id}', 'btrade\Http\Controllers\Accounts@getAccountAction'); // get specific account
    $api->post('account/', 'btrade\Http\Controllers\Accounts@posttAccountAction');
    $api->patch('account/{id}', 'btrade\Http\Controllers\Accounts@patchAccountAction');
    $api->delete('account/{id}', 'btrade\Http\Controllers\Accounts@deleteAccountAction');

    /**
     * markets
     * list of instruments, prices etc
    //*/

    $api->get('markemarketsts/', 'btrade\Http\Controllers\Markets@getMarketsAction');

    $api->get('market/{id}', 'btrade\Http\Controllers\Markets@getMarketAction');
    $api->post('market/', 'btrade\Http\Controllers\Markets@postMarketAction\'');
    $api->patch('market/{id}', 'btrade\Http\Controllers\Markets@patchMarketAction\'');
    $api->delete('market/{id}', 'btrade\Http\Controllers\Markets@deleteMarketAction\'');
    //*/

    /**
     * positions
     * new/open/close/pending/cancel
    //*/

    $api->get('positions/', 'btrade\Http\Controllers\Positions@getPositionsAction');

    $api->get('position/{id}', 'btrade\Http\Controllers\Positions@getPositionAction');
    $api->post('position/', 'btrade\Http\Controllers\Positions@postPositionAction');
    $api->patch('position/{id}', 'btrade\Http\Controllers\Positions@patchPositionAction');
    $api->delete('position/{id}', 'btrade\Http\Controllers\Positions@deletePositionAction');
    //*/

    /**
     * transactions
     * deposits, withdrawls etc.
    //*/

    $api->get('transaction/', 'btrade\Http\Controllers\Transactions@getTransactionsAction');
    $api->get('transaction/{id}', 'btrade\Http\Controllers\Transactions@getTransactionAction');
    //*/

});

#Route::middleware('auth:api')->get('/user', function (Request $request) {
#    return $request->user();
#});
