<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\MobileAPI\TransactionController;
use App\Http\Controllers\TransactionController as WebTransactionController;
use App\Http\Controllers\OppositeSenderController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MobileAPI\VerificationController;
use App\Http\Controllers\ReceiverController;
use App\Http\Middleware\MakeSureSignatureIsValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Transaction:
// step one: submit user info
// Public with token:
Route::middleware(MakeSureSignatureIsValid::class)->group(function () {
// Auth user
    Route::post('/user/info',  [VerificationController::class, 'info'])->name('info');
    Route::post('/user/verify',  [VerificationController::class, 'verify'])->name('verify');

// Countries:
    Route::get('/countries/supported', [CountryController::class, 'supportedCountries'])->name('get.supported.countries');

// Currencies:
    Route::post('/currencies/convert', [CurrencyController::class, 'convertCurrency'])->name('app.convert.currency');
    Route::get('/currencies/popular', [CurrencyController::class, 'popular'])->name('app.convert.currency');

// Posts:
    Route::get('/posts/available', [PostController::class, 'index'])->name('app.get.available.posts');

// Banks:
    Route::get('/banks', [BankController::class, 'index'])->name('banks.list');
});

Route::middleware('auth:sanctum')->group(function () {

    // User
    Route::get('/user', function(Request $request){
        return $request->user();
    });

    // Transaction
    Route::post('/transaction/payment-info', [PaymentsController::class, 'collectPaymentInformationForAPI'])->name('collect.transaction.payment.info');
    Route::post('/transaction/make-payment', [PaymentsController::class, 'makePayment'])->name('make.transaction.payment');

    // Payment:
    Route::post('/transaction/checkout', [CheckoutController::class, 'cardAuthorized'])->name('api.card.authorized');

    // Receivers:
    Route::post('/{user}/receivers', [ReceiverController::class, 'store'])->name('store.receiver');

    // Transaction Actions:
    Route::post('/transaction/upload-payment-proof', [OppositeSenderController::class, 'uploadPaymentProof'])->name('api.upload.payment.proof');
    Route::post('/transaction/upload-payment-proof-direct', [OppositeSenderController::class, 'uploadPaymentProofForDirectTransaction'])->name('api.upload.payment.proof.direct');
    Route::post('/transaction/confirm-payment-received', [WebTransactionController::class, 'confirmPaymentToReceiver'])->name('api.confirm.payment');
});

// Allow transaction page without authentication:
Route::post('/transaction/track', [TransactionController::class, 'track'])->name('api.track.transaction');



