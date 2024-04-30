<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\WorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('fetch-workers', [WorkerController::class, 'fetchWorkers']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register/client', [AuthController::class, 'registerClient']);
    Route::post('register/worker', [AuthController::class, 'registerWorker']);
});

//
Route::group(['middleware' => ['auth:sanctum']], function () {
    // routes that can be viewed by any roles

    // admin only routes
    Route::group(['middleware' => ['authRole:admin']], function () {
        Route::group(['prefix' => 'admin'], function () {
            //
            Route::get('dashboard', [AdminController::class, 'dashboard']);

            // incident types
            Route::group(['prefix' => 'incident-type'], function () {
                Route::get('fetch-all', [AdminController::class, 'fetchAllIncidentTypes']);
                Route::get('list', [AdminController::class, 'listIncidentTypes']);
                Route::post('create', [AdminController::class, 'createIncidentType']);
                Route::post('update', [AdminController::class, 'updateIncidentType']);
                Route::post('deactivate', [AdminController::class, 'deleteIncidentType']);
            });

            // roles
            Route::group(['prefix' => 'role'], function () {
                Route::get('fetch-all', [AdminController::class, 'fetchAllRoles']);
                Route::get('list', [AdminController::class, 'listRoles']);
                Route::post('create', [AdminController::class, 'createRole']);
                Route::post('update', [AdminController::class, 'updateRole']);
                Route::post('deactivate', [AdminController::class, 'deleteRole']);
            });

            // priorities
            Route::group(['prefix' => 'priority'], function () {
                Route::get('fetch-all', [AdminController::class, 'fetchAllPriorities']);
                Route::get('list', [AdminController::class, 'listPriorities']);
                Route::post('create', [AdminController::class, 'createPriority']);
                Route::post('update', [AdminController::class, 'updatePriority']);
                Route::post('deactivate', [AdminController::class, 'deletePriority']);
            });
        });
    });

    // client only routes
    Route::group(['middleware' => ['authRole:client']], function () {
        Route::group(['prefix' => 'client'], function () {
            //
            Route::get('my-incidents', [ClientController::class, 'fetchMyIncidents']);

            // report new incidents
            Route::group(['prefix' => 'incident'], function () {
                Route::post('report', [ClientController::class, 'reportIncident']);
                Route::get('view', [ClientController::class, 'viewSingleIncident']);
            });
        });
    });

    // health client only routes
    Route::group(['middleware' => ['authRole:worker']], function () {
        Route::group(['prefix' => 'health-care-worker'], function () {
            //
            Route::get('my-incidents', [WorkerController::class, 'fetchIncidents']);

            // report new incidents
            Route::group(['prefix' => 'incident'], function () {
                Route::post('log', [WorkerController::class, 'logIncident']);
            });
        });
    });
});
