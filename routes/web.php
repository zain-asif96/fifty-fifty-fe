<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\ErrorsController;
use App\Http\Controllers\OppositeSenderController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonerisPaymentController;

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
/*tesing moneris*/
Route::post('/moneris',[MonerisPaymentController::class,'payment'])->name('moneris.payment');
Route::get('/', [DashboardController::class, 'welcome'])->name('welcome');
Route::get('/services', [DashboardController::class, 'services'])->name('services.page');
Route::get('/not-supported', [ErrorsController::class, 'notSupported'])->name('not.supported.page');

// Privacy page:
Route::get('/privacy', [PrivacyController::class, 'privacy'])->name('privacy.page');
Route::get('/terms', [PrivacyController::class, 'terms'])->name('terms.page');


Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// User data (authentication of user) - public routes
Route::get('/user-info', [UsersController::class, 'userInfoPage'])->name('user.info.page');
Route::get('/verify-contacts', [VerificationController::class, 'verifyUserPage'])->name('verify.user.page');


Route::middleware('auth')->group(function () {
    // Transaction steps: 1-info
    Route::get('/transaction-info', [TransactionController::class, 'transactionInfoPage'])->name('transaction.info.page');

    // 2-receiver
    Route::get('/receiver-info', [ReceiverController::class, 'receiverInfoPage'])->name('receiver.info.page');

    // 3-checkout
    Route::get('/checkout', [CheckoutController::class, 'checkoutPage'])->name('checkout.page');

    // Card authorized:
    Route::get('/card-authorized', [CheckoutController::class, 'cardAuthorized'])->name('card.authorized.page');
    // thankyou message when the information is added
    // A ROUTE FOR THANKYOU MESSAGE IN CASE THE USER SENDS DIRECTLY WITHOUT POST
    Route::get('/transaction-completed', [CheckoutController::class, 'transactionCompleted'])->name('transaction.completed.page');

});


Route::prefix('api')->group(function () {
    // User information - public
    Route::post('/validate-info', [UsersController::class, 'validateUserInfo'])->name('validate.user.info');

    // verification - public
    Route::post('/verify-user', [VerificationController::class, 'verifyUser'])->name('verify.user');
    Route::post('/resend-email-code', [VerificationController::class, 'resendEmailCode'])->name('resend.email.user');

    // Payments:
    Route::post('/collect-payment-info', [PaymentsController::class, 'collectPaymentInformation'])->name('collect.payment.information');

    // Receiver information:
    Route::post('/{user}/receiver', [ReceiverController::class, 'store'])->name('store.receiver');
    Route::put('/receiver/{receiver}', [ReceiverController::class, 'update'])->name('update.receiver');

    // Currency Conversion:
    Route::post('/convert-currency', [CurrencyController::class, 'convertCurrency'])->name('convert.currency');

    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts.list');

    // Transactions: Confirm payment has been received:
    Route::post('/confirm-payment-to-receiver', [TransactionController::class, 'confirmPaymentToReceiver'])
        ->name('confirm.payment.to.receiver');

    // Banks:
    Route::get('/banks/{country}', [BankController::class, 'getListOfBanksByCountry'])->name('banks.list');

    Route::get('/get-international-banks', [UsersController::class, 'getInternationalBanks'])->name('get.international.banks');

});

// Transactions:
Route::get('/tt', [TransactionController::class, 'trackTransactionPage'])->name('track.transaction');


// Available posts:
Route::get('/available-posts', [PostController::class, 'postsPage'])->name('available.posts.page');

// Opposite sender routes:
Route::get('/handle-transaction', [OppositeSenderController::class, 'handleTransactionPage'])->name('opposite.sender.user.info');
Route::post('/upload-payment-proof', [OppositeSenderController::class, 'uploadPaymentProof'])->name('upload.payment.proof');
Route::post('/upload-payment-proof-direct', [OppositeSenderController::class, 'uploadPaymentProofForDirectTransaction'])->name('upload.payment.proof.direct');

require __DIR__ . '/admin.php';

require __DIR__ . '/auth.php';

