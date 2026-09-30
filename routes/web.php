<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('register')
    ->name('registration.')
    ->group(function () {
        Route::get('/', [RegistrationController::class, 'getCreate'])->name('create');
        Route::post('/', [RegistrationController::class, 'postCreate'])->name('store');
        Route::get('/find', [RegistrationController::class, 'getFindBadge'])->name('find');
    });

Route::namespace('App\Http\Controllers\Auth')
    ->name('auth.')
    ->group(function () {

        // Unsecured Routes
        Route::get('/', 'AuthController@getLogin');
        Route::get('/login', 'AuthController@getLogin')->name('login.index');
        Route::post('/login', 'AuthController@postLogin')->name('login');

        Route::get('/forgot/password', 'AuthController@getForgotPassword')->name('forgot.password.index');
        Route::post('/forgot/password', 'AuthController@postForgotPassword')->name('forgot.password');

        Route::get('/password/reset/request/{token}', 'AuthController@getResetPassword')->name('password.reset.request');
        Route::post('/password/reset', 'AuthController@postResetPassword')->name('password.reset');

        // 2 Factor Auth Routes
        Route::prefix('two-factor')
            ->name('two.factor.')
            ->group(function () {
                Route::get('/auth/{token}', 'AuthController@getTwoFactorAuthIndex')->name('index');
                Route::post('/auth/verify', 'AuthController@postVerifyTwoFactorAuth')->name('verify');
            });

        // Secured Routes
        Route::middleware('auth')
            ->group(function () {
                Route::get('/logout', 'AuthController@getLogout')->name('logout');
            });
    });

Route::namespace('App\Http\Controllers\Admin')
    ->name('admin.')
    ->group(function () {

        // Secured Routes
        Route::middleware(['auth', 'employee'])
            ->group(function () {
                Route::prefix('dashboard')
                    ->name('dashboard.')
                    ->group(function () {
                        Route::get('/', 'DashboardController@getIndex')->name('index');
                        Route::get('/navigation', 'DashboardController@getNav')->name('navigation');
                        Route::get('/stats', 'DashboardController@getStats')->name('stats');
                        Route::get('/graph/growth', 'DashboardController@getSalesGraph')->name('graph.growth');
                        Route::get('/graph/engagement', 'DashboardController@getUserGraph')->name('graph.engagement');
                        Route::get('/top-products', 'DashboardController@getTopProducts')->name('top.products');
                        Route::get('/low-stock-products', 'DashboardController@getLowStockProducts')->name('low.stock.products');
                        Route::get('/login/requested', 'DashboardController@getLoginRequested')->name('login.requested');
                        Route::get('/login/request/status', 'DashboardController@getLoginRequestStatus')->name('login.request.status');
                    });

                Route::prefix('profile')
                    ->name('profile.')
                    ->group(function () {
                        Route::get('/', 'ProfileController@getIndex')->name('details');
                        Route::post('/', 'ProfileController@postUpdate')->name('update');
                        Route::post('/change_password', 'ProfileController@postChangePassword')->name('change.password');
                        Route::get('/logout', 'ProfileController@getLogout')->name('logout');
                    });

                Route::prefix('companies')
                    ->name('companies.')
                    ->group(function () {
                        Route::get('/', 'CompanyController@getIndex')->name('index');
                        Route::get('list', 'CompanyController@getList')->name('list');
                        Route::get('create', 'CompanyController@getCreate')->name('create.index');
                        Route::post('create', 'CompanyController@postCreate')->name('create');
                        Route::get('update/{id?}', 'CompanyController@getUpdate')->name('update.index');
                        Route::post('update/{id?}', 'CompanyController@postUpdate')->name('update');
                        Route::get('delete/{id?}', 'CompanyController@getDelete')->name('delete');
                        Route::get('change/status/{id?}', 'CompanyController@getChangeStatus')->name('change.status');
                    });

                Route::prefix('permissions')
                    ->name('permissions.')
                    ->group(function () {

                        Route::get('/', 'PermissionController@getIndex')->name('index');
                        Route::get('list', 'PermissionController@getList')->name('list');
                        
                        Route::get('update/{id}', 'PermissionController@getUpdate')->name('update.index');
                        Route::post('update/{id}', 'PermissionController@postUpdate')->name('update');
                    });

                Route::prefix('roles')
                    ->name('roles.')
                    ->group(function () {
                        Route::get('/', 'RoleController@getIndex')->name('index');
                        Route::get('list', 'RoleController@getList')->name('list');
                        Route::get('create', 'RoleController@getCreate')->name('create.index');
                        Route::post('create', 'RoleController@postCreate')->name('create');
                        Route::get('update/{id?}', 'RoleController@getUpdate')->name('update.index');
                        Route::post('update/{id?}', 'RoleController@postUpdate')->name('update');
                        Route::get('delete/{id?}', 'RoleController@getDelete')->name('delete');
                    });

                Route::prefix('settings')
                    ->name('settings.')
                    ->group(function () {
                        Route::get('/', 'SettingController@getIndex')->name('index');
                        Route::post('update', 'SettingController@postUpdate')->name('update');
                    });

                Route::prefix('users')
                    ->name('users.')
                    ->group(function () {
                        Route::get('/', 'UserController@getIndex')->name('index');
                        Route::get('list', 'UserController@getList')->name('list');
                        Route::get('get-states/{country_id}', 'UserController@getStatesByCountry')->name('get.states');
                        Route::get('get-cities/{state_id}', 'UserController@getCitiesByState')->name('get.cities');
                        Route::get('get-pincodes/{city_id}', 'UserController@getPinCodesByCity')->name('get.pincodes');
                        Route::get('create', 'UserController@getCreate')->name('create.index');
                        Route::post('create', 'UserController@postCreate')->name('create');
                        Route::get('update/{id?}', 'UserController@getUpdate')->name('update.index');
                        Route::post('update/{id?}', 'UserController@postUpdate')->name('update');
                        Route::get('delete/{id?}', 'UserController@getDelete')->name('delete');
                        Route::get('change/status/{id?}', 'UserController@getChangeStatus')->name('change.status');
                        Route::get('view/{id?}', 'UserController@getView')->name('view');
                    });

                Route::prefix('registrations')
                    ->name('registrations.')
                    ->group(function () {
                        Route::get('/', 'RegistrationController@getIndex')->name('index');
                        Route::get('list', 'RegistrationController@getList')->name('list');
                        Route::get('view/{id}', 'RegistrationController@getView')->name('view');
                        Route::get('update/{id}', 'RegistrationController@getUpdate')->name('update.index');
                        Route::post('update/{id}', 'RegistrationController@postUpdate')->name('update');
                        Route::get('delete/{id}', 'RegistrationController@getDelete')->name('delete');
                        Route::get('change/status/{id}', 'RegistrationController@getChangeStatus')->name('change.status');
                    });
            });
    });