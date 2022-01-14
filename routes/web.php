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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', 'PageController@welcome')->name('welcome');
Route::get('reset', 'PageController@resetPasswordPage')->name('reset.credentials');
Route::post('reset', 'PageController@resetPassword')->name('reset.credentials');
Route::get('start', 'PageController@xamppStart')->name('start.xampp');

Auth::routes();

/**
 * -------------------------
 * User Routes Start here
 * -------------------------
 */
Route::group([
    'prefix' => '/',
], function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('profile', 'HomeController@profile')->name('user.profile');
    Route::get('password', 'HomeController@passwordPage')->name('user.password');
    Route::post('password', 'HomeController@changePassword')->name('user.password');
    Route::get('logout', 'HomeController@logout')->name('user.logout');


    /**
     * ---------------------------
     * All shared functions here
     * --------------------------
     */
    Route::group([
        'prefix' => 'shared',
    ], function () {
        // items
        Route::group([
            'prefix' => 'item'
        ], function () {
            Route::get('/', 'HomeController@pricePage')->name('pricing');
            Route::post('/', 'HomeController@pricing')->name('pricing');
            Route::get('view/prices', 'HomeController@viewPrices')->name('prices');
            Route::get('price/{id}', 'HomeController@editPrice')->name('edit.price');
            Route::post('update/price', 'HomeController@updatePricing')->name('update.price');
        });

        // suppliers
        Route::group([
            'prefix' => 'supplier'
        ], function () {
            Route::get('/', 'HomeController@newSupplierPage')->name('new.supplier');
            Route::post('/', 'HomeController@addSupplier')->name('new.supplier');
            Route::get('assign', 'HomeController@assignSupplierPage')->name('assign.supplier');
            Route::post('assign', 'HomeController@assignSupplier')->name('assign.supplier');
            Route::get('view', 'HomeController@viewSupplier')->name('view.supplier');
            Route::get('items/{id}', 'HomeController@viewSupplierItems')->name('view.supplier.items');
            Route::get('edit/{id}', 'HomeController@editSupplier')->name('edit.supplier');
            Route::post('update', 'HomeController@updateSupplier')->name('update.supplier');
            Route::get('remove/{id}', 'HomeController@removeSupplier')->name('remove.supplier');
            Route::get('cleared/arrears', 'HomeController@supplierClearedArrears')->name('cleared.supplier.arrears');
            Route::get('pending/arrears', 'HomeController@supplierPendingArrears')->name('pending.supplier.arrears');
            Route::get('arrears/{id}', 'HomeController@arrearsPaymentPage')->name('arrears.payment');
            Route::post('pay/arrear', 'HomeController@payArrears')->name('pay.arrear');
            Route::get('view/arrear/payment/{id}', 'HomeController@viewArrearPayment')->name('view.arrear.payment');
        });

        // new stock taking
        Route::group([
            'prefix' => 'stock'
        ], function () {
            Route::get('/', 'HomeController@stockPage')->name('new.stock');
            Route::post('/', 'HomeController@stock')->name('new.stock');
            Route::get('select/item', 'HomeController@stockItemPage')->name('select.item.page');
            Route::get('item', 'HomeController@stockItem')->name('select.item');
            Route::get('view', 'HomeController@viewStock')->name('view.stock');
            Route::get('past/{id}', 'HomeController@markStockAsPast')->name('past.stock');
            Route::get('view/past', 'HomeController@viewPastSock')->name('view.past.stock');
        });

        // sales
        Route::group([
            'prefix' => 'sales'
        ], function () {
            Route::get('/', 'HomeController@sales')->name('sales');
            Route::post('sell', 'HomeController@sell')->name('sell');
            Route::get('view/cart', 'HomeController@viewCart')->name('view.cart');
            Route::post('update/cart', 'HomeController@updateCart')->name('update.cart');
            Route::get('clear/cart', 'HomeController@clearCart')->name('clear.cart');
            Route::get('delete/item/cart/{id}', 'HomeController@deleteItemCart')->name('delete.item.cart');
            Route::post('complete/purchase', 'HomeController@completePurchase')->name('complete.purchase');
            Route::post('complete/credit', 'HomeController@creditPurchase')->name('credit.purchase');
            Route::get('print/purchase/{NO}', 'HomeController@printPurchase')->name('print.purchase');
            Route::get('print/purchase/tax/{NO}', 'HomeController@printPurchaseWithTax')->name('print.purchase.with.tax');
        });

        // get sells
        Route::group([
            'prefix' => 'sells'
        ], function () {
            Route::get('today', 'HomeController@todaySells')->name('today.sells');
            Route::get('all', 'HomeController@allSells')->name('all.sells');
        });

        // get purchases
        Route::group([
            'prefix' => 'purchase'
        ], function () {
            Route::get('today', 'HomeController@todayPurchases')->name('today.purchases');
            Route::get('all', 'HomeController@allPurchases')->name('all.purchases');
            Route::get('items/{id}', 'HomeController@purchaseItems')->name('purchase.items');
            Route::get('receipt/{NO}', 'HomeController@purchaseReceipt')->name('purchase.receipt');
        });

        // credit payments
        Route::group([
            'prefix' => 'credit'
        ], function () {
            Route::get('cleared', 'HomeController@clearedCredits')->name('cleared.credit.purchases');
            Route::get('pending', 'HomeController@pendingCredits')->name('pending.credit.purchases');
            Route::get('purchases', 'HomeController@allCreditPurchases')->name('all.credit.purchases');
            Route::get('purchases/payment/{id}', 'HomeController@creditPurchasePayment')->name('credit.purchase.payment');
            Route::post('pay/purchase', 'HomeController@payCreditPurchase')->name('pay.credit.purchase');
            Route::get('payments/statements/{id}', 'HomeController@creditPaymentStatements')->name('credit.payment.statements');
        });

        //  Add users
        Route::group([
            'prefix' => 'user'
        ], function () {
            Route::get('/', 'HomeController@addUserPage')->name('add.user');
            Route::post('/', 'HomeController@addUser')->name('add.user');
            Route::get('view/system', 'HomeController@viewUsers')->name('view.user');
            Route::post('block', 'HomeController@blockUser')->name('block.user');
        });

        //  get reports
        Route::group([
            'prefix' => 'report'
        ], function () {
            Route::get('/', 'HomeController@generateReportPage')->name('generate.report');
            Route::post('/', 'HomeController@generateReport')->name('generate.report');
        });
    });
    /**
     * ------------------------
     * End of shared functions
     * ------------------------
     */

    /**
     * ------------------------
     * start of notifications
     * routes for user
     * -------------------------
     */
    Route::group([
        'prefix' => 'mailbox',
    ], function () {
        Route::get('view', [
            'uses' => 'HomeController@latestMailBox',
            'as' => 'user.latest.mailbox',
        ]);
        Route::get('read/{id}', [
            'uses' => 'HomeController@readMailBox',
            'as' => 'user.read.mailbox',
        ]);
        Route::post('delete/single', [
            'uses' => 'HomeController@deleteSingleMail',
            'as' => 'user.delete.single.mailbox',
        ]);
        Route::get('all', [
            'uses' => 'HomeController@allMailBox',
            'as' => 'user.all.mailbox',
        ]);
        Route::get('delete/all', [
            'uses' => 'HomeController@deleteAllMails',
            'as' => 'user.delete.all.mailbox',
        ]);
    });
    /**
     * ----------------------------------
     * End of system notifications routes
     * ----------------------------------
     */
});
/**
 * -------------------------
 * End Of User Routes Start here
 * -------------------------
 */

/**
 * ---------------------------------
 * System admin routes start here
 * --------------------------------
 */
Route::group([
    'prefix' => 'sys/admin',
], function () {
    // Admin auth routes
    Route::group([
        'namespace' => 'Auth',
    ], function () {
        // Show the login page
        Route::get('/', 'LoginController@getAdminLoginPage');

        // Process the admin login request
        Route::post('/', [
            'uses' => 'LoginController@authenticateAdmin',
            'as' => 'admin.login',
        ]);
    });

    /**
     * admin functions
     */
    Route::get('/home', [
        'uses' => 'AdminController@adminDashBoard',
        'as' => 'admin.home',
    ]);
    Route::get('/profile', [
        'uses' => 'AdminController@adminProfile',
        'as' => 'admin.profile',
    ]);

    //change password for admin
    Route::get('/password', [
        'uses' => 'AdminController@passwordPage',
        'as' => 'admin.password',
    ]);
    Route::post('/password', [
        'uses' => 'AdminController@changePassword',
        'as' => 'admin.password',
    ]);

    //logout admin
    Route::get('/logout', [
        'uses' => 'AdminController@logout',
        'as' => 'admin.logout',
    ]);


    /**
     * ------------------------
     * start of notifications
     * routes for user
     * -------------------------
     */
    Route::group([
        'prefix' => 'mailbox',
    ], function () {
        Route::get('view', [
            'uses' => 'AdminController@latestMailBox',
            'as' => 'admin.latest.mailbox',
        ]);
        Route::get('read/{id}', [
            'uses' => 'AdminController@readMailBox',
            'as' => 'admin.read.mailbox',
        ]);
        Route::post('delete/single', [
            'uses' => 'AdminController@deleteSingleMail',
            'as' => 'admin.delete.single.mailbox',
        ]);
        Route::get('all', [
            'uses' => 'AdminController@allMailBox',
            'as' => 'admin.all.mailbox',
        ]);
        Route::get('delete/all', [
            'uses' => 'AdminController@deleteAllMails',
            'as' => 'admin.delete.all.mailbox',
        ]);
    });
    /**
     * ----------------------------------
     * End of system notifications routes
     * ----------------------------------
     */
});
/**
 * --------------------------------
 * End of system admin routes
 * -------------------------------
 */
