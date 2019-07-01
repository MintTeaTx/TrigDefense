<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('auth')->namespace('Auth')->group(function ()
{

    Route::get('/eve', [
        'as'   => 'auth.eve',
        'uses' => 'LoginController@redirectToProvider',
    ]);
    Route::get('/eve/callback', [
        'as'   => 'auth.eve.callback',
        'uses' => 'LoginController@handleProviderCallback',
    ]);
}
);
Route::prefix('srp')->namespace('SRP')->group(function ()
{

}
);
Route::prefix('fleet')->namespace('Fleet')->group(function ()
{
Route::get('/index',
    [
        'as' => 'fleet.index',
        'uses' => 'FleetController@getFleets'
    ]);

Route::get('/',
    [
        'as' => 'fleet',
        'uses' => 'FleetController@getFleets'
    ]);
    Route::get('/new',
        [
            'as' => 'fleet.add',
            'uses' => 'FleetController@newFleet'
        ]);
    Route::get('/end/{fleetid}',
        [
            'as' => 'fleet.end',
            'uses' => 'FleetController@endFleet'
        ]);
    Route::get('/join/{fleetid}',
        [
            'as' => 'fleet.join',
            'uses' => 'FleetController@joinFleet'
        ]);
    Route::get('/rejoin/{fleetid}',
        [
            'as' => 'fleet.rejoin',
            'uses' => 'FleetController@rejoinFleet'
        ]);
    Route::get('/leave/{fleetid}',
        [
            'as' => 'fleet.leave',
            'uses' => 'FleetController@leaveFleet'
        ]);
    Route::get('/view/{fleetid}',
        [
            'as' => 'fleet.view',
            'uses' => 'FleetController@getFleetView'
        ]);
    Route::get('/view/participants/{fleetid}',
        [
            'as' => 'fleet.participants',
            'uses' => 'FleetController@getFleetView'
        ]);
    Route::post('/view/{id}/saveLoot', [
        'as'   => 'fleet.saveLoot',
        'uses' => 'FleetController@saveLoot',
    ]);
    Route::post('/view/{id}/saveLog', [
        'as'   => 'fleet.saveLog',
        'uses' => 'FleetController@saveFleetLoot',
    ]);
}
);


Route::get('/', [
    'as'   => 'landing',
    'uses' => 'HomeController@index'
]);
Route::get('/home', [
    'as'   => 'home',
    'uses' => 'HomeController@getHome'
]);
Route::get('/doctrine/{id}',[
    'as'   => 'doctrine',
    'uses' => 'DoctrineController@getDoctrineView'
]);
Route::get('/doctrine/get/{id}',[
    'as'   => 'doctrine',
    'uses' => 'DoctrineController@getDoctrineById'
]);
Route::get('/doctrine/fit/{id}',[
    'as'   => 'doctrine.get',
    'uses' => 'DoctrineController@getFittingById'
]);
Route::get('/join',[
    'as'   => 'join',
    'uses' => 'PageController@getJoin'
]);

Route::get('/pages', [
    'as'    => 'pageindex',
    'uses'  => 'PageController@getIndex'
]);
Route::get('/pages/{id}', [
   'as'    => 'pages',
   'uses'  => 'PageController@getPage'
]);
Route::get('/pages/{id}/edit', [
    'as'    => 'pages.edit',
    'uses'  => 'PageController@editPage'
]);
Route::get('/users', [
    'as'    => 'users',
    'uses'  => 'PageController@getUser'
]);
Route::get('/roles', [
    'as'    => 'roles',
    'uses'  => 'PageController@getRoles'
]);
Route::get('/logout', [
    'as'   => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);
Auth::routes(['register' => false]);

Route::post('/doctrine/{id}/savefitting', [
    'as'   => 'doctrine.saveFitting',
    'uses' => 'DoctrineController@saveFitting',
]);
Route::get('/fitting/delete/{id}', [
    'as'   => 'doctrine.deleteFitting',
    'uses' => 'DoctrineController@deleteFitting',
]);
Route::post('/role/add', [
    'as'    => 'role.add',
    'uses'  => 'Auth\RoleController@addRole'
]);
Route::get('/newpage', [
    'as'   => 'page.new',
    'uses' => 'PageController@newPage'
]);
Route::post('/postpage', [
    'as'    => 'page.post',
    'uses'  => 'PageController@postPage'
]);
Route::post('/role/delete', [
    'as'    => 'role.delete',
    'uses'  => 'Auth\RoleController@deleteRole'
]);
Route::post('/role/give/', [
    'as'    => 'role.give',
    'uses'  => 'Auth\RoleController@giveUserRole'
]);
Route::get('/role/give/{user}/{role}', [
    'as'    => 'ajax.role.give',
    'uses'  => 'Auth\RoleController@giveUserRoleAjax'
]);
Route::post('/role/take', [
    'as'    => 'role.take',
    'uses'  => 'Auth\RoleController@takeUserRole'
]);
Route::get('/role/take/{user}/{role}', [
    'as'    => 'ajax.role.take',
    'uses'  => 'Auth\RoleController@takeUserRoleAjax'
]);
Route::get('/roles/get/', [
    'as'   => 'roles.get',
    'uses' => 'Auth\RoleController@getRoles'
]);
Route::get('/users/get/', [
    'as'   => 'users.get',
    'uses' => 'Auth\RoleController@getUsers'
]);

Route::get('/users/get/data', [
    'as'   => 'users.getdata',
    'uses' => 'Auth\RoleController@getUsersData'
]);
Route::get('/roles/user/get/{userid}', [
    'as'   => 'roles.get.userroles',
    'uses' => 'Auth\RoleController@getUserRoles'
]);
Route::get('/roles/get/{userid}', [
    'as'   => 'roles.get.roleusers',
    'uses' => 'Auth\RoleController@getRoleUsers'
]);
