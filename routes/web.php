<?php

use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\MikrotikController;
use App\Http\Controllers\ModemController;
use App\Http\Controllers\BrandNameController;
use App\Http\Controllers\SwitcherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StreamingTvController;
use App\Http\Controllers\ModemTypeController;
use App\Http\Controllers\PaymentMethodController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/zone', [ZoneController::class, 'index'])->name('zone.index');
    Route::post('/zone/add', [ZoneController::class, 'add'])->name('zone.add');
    Route::post('/zone/edit', [ZoneController::class, 'edit'])->name('zone.edit');
    Route::post('/zone/remove', [ZoneController::class, 'remove'])->name('zone.remove');
    Route::get('/zone/list', [ZoneController::class, 'list'])->name('zone.list');

    Route::get('/provider', [ProviderController::class, 'index'])->name('provider.index');
    Route::post('/provider/add', [ProviderController::class, 'add'])->name('provider.add');
    Route::post('/provider/edit', [ProviderController::class, 'edit'])->name('provider.edit');
    Route::post('/provider/remove', [ProviderController::class, 'remove'])->name('provider.remove');
    Route::get('/provider/list', [ProviderController::class, 'list'])->name('provider.list');

    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::post('/client/add', [ClientController::class, 'add'])->name('client.add');
    Route::post('/client/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::post('/client/remove', [ClientController::class, 'remove'])->name('client.remove');
    Route::get('/client/list', [ClientController::class, 'list'])->name('client.list');
    Route::get('/client-detail/{clientId}', [ClientController::class, 'detail'])->name('client.detail');
    Route::post('/client/addplan', [ClientController::class, 'addplan'])->name('client.addPlan');
    Route::post('/client/editplan', [ClientController::class, 'editplan'])->name('client.editPlan');
    Route::get('/client/planlist', [ClientController::class, 'planlist'])->name('client.planList');

    Route::get('/streamingtv', [StreamingTvController::class, 'index'])->name('streamingtv.index');
    Route::post('/streamingtv/add', [StreamingTvController::class, 'add'])->name('streamingtv.add');
    Route::post('/streamingtv/edit', [StreamingTvController::class, 'edit'])->name('streamingtv.edit');
    Route::post('/streamingtv/remove', [StreamingTvController::class, 'remove'])->name('streamingtv.remove');
    Route::get('/streamingtv/list', [StreamingTvController::class, 'list'])->name('streamingtv.list');

    Route::get('/streamingtv-detail/{streamingtvId}', [StreamingTvController::class, 'detail'])->name('streamingtv.detail');
    Route::post('/streamingtv/addprofile', [StreamingTvController::class, 'addprofile'])->name('streamingtv.addprofile');
    Route::post('/streamingtv/editprofile', [StreamingTvController::class, 'editprofile'])->name('streamingtv.editprofile');
    Route::post('/streamingtv/removeprofile', [StreamingTvController::class, 'removeprofile'])->name('streamingtv.removeprofile');
    Route::get('/streamingtv/listprofile', [StreamingTvController::class, 'listprofile'])->name('streamingtv.listprofile');

    Route::get('/provider-detail/{providerId}', [ProviderController::class, 'detail'])->name('provider.detail');
    Route::post('/provider/addservice', [ProviderController::class, 'addservice'])->name('provider.addservice');
    Route::post('/provider/editservice', [ProviderController::class, 'editservice'])->name('provider.editservice');
    Route::post('/provider/removeservice', [ProviderController::class, 'removeservice'])->name('provider.removeservice');
    Route::get('/provider/listservice', [ProviderController::class, 'listservice'])->name('provider.listservice');

    Route::resource('/mikrotiks', MikrotikController::class)->names('mikrotiks');

    Route::get('/modemtype', [ModemTypeController::class, 'index'])->name('modemtype.index');
    Route::post('/modemtype/add', [ModemTypeController::class, 'add'])->name('modemtype.add'); 
    Route::post('/modemtype/edit', [ModemTypeController::class, 'edit'])->name('modemtype.edit');
    Route::post('/modemtype/remove', [ModemTypeController::class, 'remove'])->name('modemtype.remove');
    Route::get('/modemtype/list', [ModemTypeController::class, 'list'])->name('modemtype.list');

    Route::resource('/modem', ModemController::class)->names('modem');

    Route::get('/contract', [ContractController::class, 'index'])->name('contract.index');
    Route::get('/contract/list', [ContractController::class, 'list'])->name('contract.list');
    Route::get('/contract/listservice/{providerId}', [ContractController::class, 'listservice'])->name('contract.listservice');
    Route::post('/contract/add', [ContractController::class, 'add'])->name('contract.add');
    Route::post('/contract/edit', [ContractController::class, 'edit'])->name('contract.edit');
    Route::post('/contract/remove/{contractId}', [ContractController::class, 'remove'])->name('contract.remove');
    Route::get('/contract-detail/{contractId}', [ContractController::class, 'detail'])->name('contract.detail');
    Route::post('/contract/addmodem', [ContractController::class, 'addmodem'])->name('contract.addmodem');
    Route::get('/contract/listmodem/{serviceProviderId}', [ContractController::class, 'listmodem'])->name('contract.listmodem');
    Route::post('/contract/removemodem/{modemId}', [ContractController::class, 'removemodem'])->name('contract.removemodem');

    Route::get('/brandname', [BrandNameController::class, 'index'])->name('brandname.index');
    Route::post('/brandname/add', [BrandNameController::class, 'add'])->name('brandname.add'); 
    Route::post('/brandname/edit', [BrandNameController::class, 'edit'])->name('brandname.edit');
    Route::post('/brandname/remove', [BrandNameController::class, 'remove'])->name('brandname.remove');
    Route::get('/brandname/list', [BrandNameController::class, 'list'])->name('brandname.list');

    Route::get('/switcher', [SwitcherController::class, 'index'])->name('switcher.index');
    Route::post('/switcher/add', [SwitcherController::class, 'add'])->name('switcher.add'); 
    Route::post('/switcher/edit', [SwitcherController::class, 'edit'])->name('switcher.edit');
    Route::post('/switcher/remove', [SwitcherController::class, 'remove'])->name('switcher.remove');
    Route::get('/switcher/list', [SwitcherController::class, 'list'])->name('switcher.list');

    Route::get('/paymentmethod', [PaymentMethodController::class, 'index'])->name('paymentmethod.index');
    Route::get('/paymentmethod/list', [PaymentMethodController::class, 'list'])->name('paymentmethod.list');
    Route::post('/paymentmethod/add', [PaymentMethodController::class, 'add'])->name('paymentmethod.add'); 
    Route::post('/paymentmethod/edit', [PaymentMethodController::class, 'edit'])->name('paymentmethod.edit');
    Route::post('/paymentmethod/remove/{paymentMethodId}', [PaymentMethodController::class, 'remove'])->name('paymentmethod.remove');
    
});