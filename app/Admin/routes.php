<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');

	$router->resource('hdrscomplaints', ComplaintsController::class);

	$router->resource('area', AreaController::class);

	$router->resource('all_user', AllUserController::class);

	$router->resource('share', ShareController::class);

	$router->resource('video', VideoController::class);

	$router->resource('advert', AdvertController::class);

    $router->resource('manage_all_store', AdminUsersController::class);

    $router->resource('integral', IntegralController::class);

    $router->resource('store_user', HdrsUsersController::class);

    $router->resource('video-group', GroupController::class);

    $router->resource('share_list', ShareController::class);

    $router->get('integral_xh/{id}', 'IntegralXhController@add');

    $router->get('certification', 'CertificationController@certification');

    $router->get('addstore', 'AddstoreController@add');

    $router->get('hdrsclock', 'HdrsClockController@rules');

    $router->get('share_rules', 'HdrsShareRulesController@rules');

});
