<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicationsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/about-us', 'aboutUs')->name('about');
        Route::get('/contact-us', 'contactUs')->name('contact');
        Route::post('/contact-us', 'contactUsSubmit')->name('contact-us');
    });

Route::controller(VerificationController::class)
    ->prefix('verification')
    ->name('verification.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');

        Route::get('/resend', 'resend')->name('resend');
        Route::post('/resend', 'resendPost')->name('resendPost');

});


Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::controller(ProfileController::class)
            ->name('profile.')
            ->group(function () {
                Route::get('/profile', 'edit')->name('edit');
                Route::patch('/profile', 'update')->name('update');
                Route::delete('/profile', 'destroy')->name('destroy');
            });

        Route::controller(DashboardController::class)
            ->name('dashboard.')
            ->prefix('dashboard')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getOffers', 'getOffers')->name('getOffers');
                Route::get('/getRatings', 'getRatings')->name('getRatings');
                Route::get('/orderNow/{id}', 'orderNow')->name('orderNow');
                Route::post('/rateOrder', 'rateOrder')->name('rateOrder');
                Route::post('/ask', 'ask')->name('ask')->middleware('throttle:60,1');
            });

        Route::controller(NotificationsController::class)
            ->name('notifications.')
            ->prefix('notifications')
            ->group(function () {
                Route::get('/getAuthUserId', 'getAuthUserId')->name('getAuthUserId');
                Route::get('/getNotifications', 'getNotifications')->name('getNotifications');
                Route::post('/sendNotification', 'sendNotification')->name('sendNotification');
                Route::post('/MarkAsRead/{id}', 'MarkAsRead')->name('MarkAsRead');
                Route::post('/MarkAllAsRead', 'MarkAllAsRead')->name('MarkAllAsRead');
            });

        Route::controller(MedicationsController::class)
            ->name('medications.')
            ->prefix('medications')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/store', 'store')->name('store');
                Route::post('/update', 'update')->name('update');
                Route::post('/delete', 'delete')->name('delete');
            });

        Route::controller(OffersController::class)
            ->name('offers.')
            ->prefix('offers')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getOffers', 'getOffers')->name('getOffers');
                Route::post('/store', 'store')->name('store');
                Route::post('/update', 'update')->name('update');
                Route::get('/delete/{id}', 'delete')->name('delete');
                Route::get('/offer/newId', 'getNewId')->name('newId');
                Route::get('/getOfferMedications/{id}', 'getOfferMedications')->name('getOfferMedications');
                Route::get('/getMedications/{offerId}', 'getMedications')->name('getMedications');
                Route::get('/getMedicationsForUpdate/{offerId}/{offerMedicationId}', 'getMedicationsForUpdate')->name('getMedicationsForUpdate');
                Route::post('/offer/save_medications', 'saveMedications')->name('saveMedications');
                Route::post('/offer/update_medications', 'updateMedications')->name('updateMedications');
                Route::post('/offer/delete_medications/{id}', 'deleteOfferMedication')->name('deleteOfferMedication');
            });

        Route::controller(OrdersController::class)
            ->name('orders.')
            ->prefix('orders')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/show/{id}', 'show')->name('show');
                Route::get('/getOrders', 'getOrders')->name('getOrders');
                Route::get('/cancel/{id}', 'cancelOrder')->name('cancel');
                Route::get('/complete/{id}', 'completeOrder')->name('complete');
                Route::get('/delete/{id}', 'deleteOrder')->name('delete');
            });

        Route::controller(RatingsController::class)
            ->name('ratings.')
            ->prefix('ratings')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/getRatings', 'getRatings')->name('getRatings');
                Route::get('/delete/{id}', 'deleteRating')->name('delete');
            });
    });

require __DIR__.'/auth.php';
