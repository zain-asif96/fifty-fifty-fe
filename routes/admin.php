<?php
// web admin routes

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ReceiverController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CommissionController;
// app admin routes
use App\Http\Controllers\MobileApp\Admin\AppAdminController;
use App\Http\Controllers\MobileApp\Admin\AppBankController;
use App\Http\Controllers\MobileApp\Admin\AppCountriesController;
use App\Http\Controllers\MobileApp\Admin\AppCurrencyController;
use App\Http\Controllers\MobileApp\Admin\AppPostController;
use App\Http\Controllers\MobileApp\Admin\AppReceiverController;
use App\Http\Controllers\MobileApp\Admin\AppTransactionController;
use App\Http\Controllers\MobileApp\Admin\AppUsersController;
use App\Http\Controllers\MobileApp\Admin\AppCommissionController;


use App\Http\Controllers\UpdateStatusController;
use App\Http\Controllers\AppUpdateStatusController;

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'can:access.admin.panel'])->group(function () {
    // admins
    Route::get('/admin', [AdminController::class, 'adminPanelPage'])->name('admin.panel.page');
    Route::get('/admin/admins', [AdminController::class, 'adminsPage'])->name('admins.page');
    // app admins
    Route::get('/app/admin', [AppAdminController::class, 'appAdminPanelPage'])->name('app.admin.panel.page');
    Route::get('/app/admin/admins', [AppAdminController::class, 'appAdminsPage'])->name('app.admins.page');

    // transactions
    Route::get('/admin/transactions', [TransactionController::class, 'transactionsPage'])->name('transactions.page');
    Route::get('/admin/transactions/payment-intent/{paymentIntent}', [TransactionController::class, 'paymentIntentPage'])->name('payment.intent.page');

    // app transactions
    Route::get('/app/admin/transactions', [AppTransactionController::class, 'transactionsPage'])->name('app.transactions.page');
    Route::get('/app/admin/transactions/payment-intent/{paymentIntent}', [AppTransactionController::class, 'paymentIntentPage'])->name('app.payment.intent.page');

    // Post
    Route::get('/admin/posts', [PostController::class, 'postsPage'])->name('posts.page');
    Route::post('/admin/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::post('/admin/posts/refresh/{post}', [PostController::class, 'refresh'])->name('posts.refresh');
    Route::put('/admin/posts/update/{post}', [PostController::class, 'update'])->name('posts.refresh');
    Route::delete('/admin/posts/delete/{post}', [PostController::class, 'delete'])->name('posts.delete');

    // app Posts
    Route::get('/app/admin/posts', [AppPostController::class, 'postsPage'])->name('app.posts.page');
    Route::post('/app/admin/posts/store', [AppPostController::class, 'store'])->name('app.posts.store');
    Route::post('/app/admin/posts/refresh/{post}', [AppPostController::class, 'refresh'])->name('app.posts.refresh');
    Route::put('/app/admin/posts/update/{post}', [AppPostController::class, 'update'])->name('app.posts.refresh');
    Route::delete('/app/admin/posts/delete/{post}', [AppPostController::class, 'delete'])->name('app.posts.delete');
    // UPDATE ROUTE MISSING

    // banks
    Route::get('/admin/banks', [BankController::class, 'index'])->name('banks.page');
    Route::post('/admin/banks/store', [BankController::class, 'store'])->name('banks.store');
    Route::put('/admin/banks/update/{bank}', [BankController::class, 'update'])->name('banks.update');
    Route::delete('/admin/banks/delete/{bank}', [BankController::class, 'delete'])->name('banks.delete');

    // app banks
    Route::get('/app/admin/banks', [AppBankController::class, 'index'])->name('app.banks.page');
    Route::post('/app/admin/banks/store', [AppBankController::class, 'store'])->name('app.banks.store');
    Route::put('/app/admin/banks/update/{bank}', [AppBankController::class, 'update'])->name('app.banks.update');
    Route::delete('/app/admin/banks/delete/{bank}', [AppBankController::class, 'delete'])->name('app.banks.delete');

    // currencies
    Route::get('/admin/currencies', [CurrencyController::class, 'currenciesPage'])->name('currencies.page');
    Route::post('/admin/currencies/store', [CurrencyController::class, 'store'])->name('currencies.store');
    Route::put('/admin/currencies/update/{currency}', [CurrencyController::class, 'update'])->name('currencies.update');
    Route::delete('/admin/currencies/delete/{currency}', [CurrencyController::class, 'delete'])->name('currencies.delete');
    Route::put('/admin/currencies/update-rates', [CurrencyController::class, 'updateRates'])->name('currencies.update.rates');

    // app currencies
    Route::get('/app/admin/currencies', [AppCurrencyController::class, 'currenciesPage'])->name('app.currencies.page');
    Route::post('/app/admin/currencies/store', [AppCurrencyController::class, 'store'])->name('app.currencies.store');
    Route::put('/app/admin/currencies/update/{currency}', [AppCurrencyController::class, 'update'])->name('app.currencies.update');
    Route::delete('/app/admin/currencies/delete/{currency}', [AppCurrencyController::class, 'delete'])->name('app.currencies.delete');
    Route::put('/app/admin/currencies/update-rates', [AppCurrencyController::class, 'updateRates'])->name('app.currencies.update.rates');

    // countries
    Route::get('/admin/countries', [CountriesController::class, 'countriesPage'])->name('countries.page');
    Route::post('/admin/countries/store', [CountriesController::class, 'store'])->name('countries.store');
    Route::put('/admin/countries/update/{country}', [CountriesController::class, 'update'])->name('countries.update');

    // app countries
    Route::get('/app/admin/countries', [AppCountriesController::class, 'countriesPage'])->name('app.countries.page');
    Route::post('/app/admin/countries/store', [AppCountriesController::class, 'store'])->name('app.countries.store');
    Route::put('/app/admin/countries/update/{country}', [AppCountriesController::class, 'update'])->name('app.countries.update');


    // users
    Route::get('/admin/users', [UsersController::class, 'usersPage'])->name('users.page');
    Route::get('/admin/users/{user}', [UsersController::class, 'singleUserPage'])->name('single.user.page');
    
    //app users
    Route::get('/app/admin/users', [AppUsersController::class, 'usersPage'])->name('app.users.page');
    Route::get('/app/admin/users/{user}', [AppUsersController::class, 'singleUserPage'])->name('app.single.user.page');

    // receivers
    Route::get('/admin/receivers', [ReceiverController::class, 'receiversPage'])->name('receivers.page');
    Route::get('/admin/receivers/{receiver}', [ReceiverController::class, 'singleReceiverPage'])->name('single.receiver.page');

    // app receivers
    Route::get('/app/admin/receivers', [AppReceiverController::class, 'receiversPage'])->name('app.receivers.page');
    Route::get('/app/admin/receivers/{receiver}', [AppReceiverController::class, 'singleReceiverPage'])->name('app.single.receiver.page');

    //web globals
    Route::get('/admin/update-status-time', [UpdateStatusController::class, 'index'])->name('time.page');
    Route::post('/admin/update-status-time', [UpdateStatusController::class, 'store'])->name('update.status.store');
    Route::put('/admin/update-status-time/{updateStatusTime}', [UpdateStatusController::class, 'update'])->name('update.status.update');

    //app globals
    Route::get('/app/admin/update-status-time', [AppUpdateStatusController::class, 'index'])->name('app.time.page');
    Route::post('/app/admin/update-status-time', [AppUpdateStatusController::class, 'store'])->name('app.update.status.store');
    Route::put('/app/admin/update-status-time/{updateStatusTime}', [AppUpdateStatusController::class, 'update'])->name('app.update.status.update');


    // commisions
    Route::get('/admin/commission', [CommissionController::class, 'commissionPage'])->name('commission.page');
    Route::put('/admin/commission/{commission}', [CommissionController::class, 'updateCommission'])->name('commission.update');

    // app commision
    Route::get('/app/admin/commission', [AppCommissionController::class, 'commissionPage'])->name('app.commission.page');
    Route::put('/app/admin/commission/{commission}', [AppCommissionController::class, 'updateCommission'])->name('app.commission.update');

});
