<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'PagesController@home');

Route::get('about', 'PagesController@about');

Route::get('banners', 'PagesController@banners');

Route::get('dlb', 'PagesController@dlb');

Route::get('license', 'PagesController@license');

Route::get('terms', 'PagesController@terms');

Route::get('privacy', 'PagesController@privacy');

Route::get('faqs', 'PagesController@faqs');

Route::get('support', 'PagesController@support');

Route::get('join', 'PagesController@join');

Route::get('login', 'PagesController@login');

Route::get('forgot', 'PagesController@forgot');

Route::get('account', 'PagesController@account');

Route::get('logout', 'PagesController@home');

/*
 Routes for Admin
 */
Route::get('admin', array('as' => 'admin', function() {
    // naming the view with as allows us to use {{ URL::route('admin') }} to create links in the admin area.
    return View::make('pages.admin.index');
}));

Route::get('admin/{page}', 'PagesController@showadminpage');

/*
 *  Member
 */
Route::get('members', 'MembersController@index');

/*
 *  Downline Builder
 */
Route::get('builders', 'BuildersController@index');

/*
 *  Mail
 */
Route::get('mails', 'MailsController@index');

/*
 *  Settings
 */
Route::get('settings', 'SettingsController@index');

/*
 *  Banners
 */
Route::get('banners', 'BannersController@index');

/*
 *  Pages - this is the same PagesController used above. - this is for the admin area though.
 */
Route::get('pages', 'PagesController@index');

/*
 *  Products
 */
Route::get('products', 'ProductsController@index');

/*
 *  Transactions
 */
Route::get('transactions', 'TransactionsController@index');

/*
 *  Promotional
 */
Route::get('promotionals', 'PromotionalsController@index');


