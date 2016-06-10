<?php

Route::group(['middleware' => 'web'], function () {

    //Test Routes
    Route::get('/twilio-test', 'TwilioTestController@index');
    Route::get('/test', 'TestController@index');
    Route::get('/notification', 'NotificationController@index');

    Route::get('/', 'HomeController@index');
    Route::get('pages/{code}','Pages\PagesController@pages');

    # Registration/Login routes     
    
    //User 
    Route::get('user/register', 'User\RegistrationController@register');
    Route::post('user/register', 'User\RegistrationController@postRegister');

    Route::get('login', 'User\SessionsController@login');
    Route::post('login', 'User\SessionsController@postLogin');
    Route::get('user/logout', 'User\SessionsController@logout');

    Route::get('user/forget_password', 'User\ResetPasswordController@forget_password');
    Route::post('user/forget_password', 'User\ResetPasswordController@forget_password_post');
    Route::get('user/reset_password/{id}/{code}', 'User\ResetPasswordController@reset_password');
    Route::post('user/reset_password', 'User\ResetPasswordController@reset_password_post');
       
    // Boat owner
    Route::get('owner/register', 'Owner\RegistrationController@register');
    Route::post('owner/register', 'Owner\RegistrationController@postRegister');

    // Shipping Agency
    Route::get('/corporate/register', 'Company\RegistrationController@register');
    Route::post('/corporate/register', 'Company\RegistrationController@postRegister');

    Route::get('register/verify','User\ActivationController@activate');

    # End Registration/Login routes   

    # Publicly Available Pages

    Route::get('owners/profile/{id}', 'Owner\OwnerController@show');
    
    Route::get('captains/profile/{id}', 'Captain\CaptainController@show');
    
    Route::get('boats/list', 'Boat\BoatController@index');
    Route::get('boats/list/search-result', 'Boat\BoatController@searchResult');
    Route::post('boats/list/search-result', 'Boat\BoatController@searchResult');
    Route::get('boats/profile/{id}/{start?}/{destination?}', 'Boat\BoatController@show');

    Route::post('boats/book/', 'Boat\BoatController@unauthorized');

    Route::get('trip_invoice/{id}','Invoice\InvoiceController@trip_invoice');

    Route::get('/ajax_anchorage',function()
    {

        $zone = \Illuminate\Support\Facades\Input::get('zone');
        $anchorage = \App\BaseAnchorage::where('type','=',$zone)->get();

        return Response::json($anchorage);
    });


    # Admin Routes
    Route::group(['middleware' => ['auth', 'admin']], function()
    {
        #dashboard
        Route::get('/admin/dashboard', ['as' => 'admin_dashboard', 'uses' => 'Admin\DashboardController@index']);
        Route::get('/admin/dashboard/profile','Admin\DashboardController@profile');
        Route::get('/admin/dashboard/edit','Admin\DashboardController@edit');
        Route::post('/admin/dashboard/edit/{id}','Admin\DashboardController@post_edit');

        #boat owners
        Route::get('/admin/boat-owners/pendingList','Admin\BoatOwnerController@pendingList');
        Route::get('/admin/boat-owners/status/{type}/{id}','Admin\BoatOwnerController@status');
        Route::resource('/admin/boat-owners', 'Admin\BoatOwnerController');

        #boats
        Route::resource('/admin/boats', 'Admin\BoatController');

        #bookings
        Route::get('/admin/bookings', 'Admin\BookingController@index');
        
        #boat captains
        Route::resource('/admin/boat-captains', 'Admin\BoatCaptainController');

        #boat captains
        Route::resource('/admin/boat-coordinators', 'Admin\BoatCoordinatorController');
        
        #boat captains
        Route::get('/admin/shipping-companies/pendingList','Admin\ShippingCompaniesController@pendingList');
        Route::get('/admin/shipping-companies/status/{type}/{id}','Admin\ShippingCompaniesController@status');
        Route::resource('/admin/shipping-companies', 'Admin\ShippingCompaniesController');
        
        #users
        Route::resource('/admin/users', 'Admin\UserController');

        #users
        Route::resource('/admin/admins', 'Admin\AdminController');

        #csr
        Route::resource('/admin/csr', 'Admin\CSRController');

        #pages
        Route::resource('/admin/pages', 'Admin\PagesController');

        #users & roles
        Route::resource('/admin/users-and-roles', 'Admin\UsersAndRolesController');
        Route::get('/admin/users-and-roles/create_user_role/{user_id}', 'Admin\UsersAndRolesController@create_user_role');

        Route::get('/admin/reports/owner_reports', 'Admin\ReportController@owner_reports');
        Route::post('/admin/reports/owner_reports_post', 'Admin\ReportController@owner_reports_post');
        Route::get('/admin/dashboard/owner_reports/trips/{owner_id}','Admin\ReportController@owner_trips_report');
        Route::post('/admin/dashboard/owner_reports_post/{owner_id}', 'Admin\ReportController@owner_trips_report_post');
        Route::post('/admin/dashboard/owner_reports/download_xlxs/{owner_id}','Admin\ReportController@owner_trips_report_download_xlxs');

        Route::get('/admin/reports/company_reports', 'Admin\ReportController@company_reports');
        Route::post('/admin/reports/company_reports_post', 'Admin\ReportController@company_reports_post');
        Route::get('/admin/dashboard/company_reports/trips/{company_id}','Admin\ReportController@company_trips_report');
        Route::post('/admin/dashboard/company_reports_post/{company_id}', 'Admin\ReportController@company_trips_report_post');
        Route::post('/admin/dashboard/company_reports/download_xlxs/{company_id}','Admin\ReportController@company_trips_report_download_xlxs');

        Route::get('/admin/reports/user_reports', 'Admin\ReportController@user_reports');
        Route::post('/admin/reports/user_reports_post', 'Admin\ReportController@user_reports_post');
        Route::get('/admin/dashboard/user_reports/trips/{user_id}','Admin\ReportController@user_trips_report');
        Route::post('/admin/dashboard/user_reports_post/{user_id}', 'Admin\ReportController@user_trips_report_post');
        Route::post('/admin/dashboard/user_reports/download_xlxs/{user_id}','Admin\ReportController@user_trips_report_download_xlxs');

        #logout
        //Route::get('/admin/logout', ['uses' => 'Admin\LoginController@logout']); 
    });

     # User Routes
    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('/user/dashboard', ['uses' => 'User\ProfileController@index']);        
        Route::get('/user/dashboard/profile/edit', ['uses' => 'User\ProfileController@edit']);
        Route::post('/user/dashboard/profile/edit', ['uses' => 'User\ProfileController@update']);

        Route::get('/user/dashboard/company', ['uses' => 'User\CompanyController@index']);
        Route::get('/user/dashboard/company/remove', ['uses' => 'User\CompanyController@remove']);
        Route::get('/user/dashboard/company/delete/{id}', ['uses' => 'User\CompanyController@delete']);
        Route::get('/user/dashboard/company/connect/{id}', ['uses' => 'User\CompanyController@connect']);
        Route::get('/user/dashboard/my_bookings', ['uses' => 'User\BookingController@my_booking']);
        Route::get('/user/dashboard/my_trips', ['uses' => 'User\TripController@my_trips']);
        
        Route::get('user/dashboard/my-advance-bookings', ['uses' => 'User\AdvanceBookingController@myBookings']);
        Route::get('/user/dashboard/advance-booking', ['uses' => 'User\AdvanceBookingController@index']);
        Route::post('user/dashboard/advance-booking', ['uses' => 'User\AdvanceBookingController@store']);
        Route::get('user/dashboard/advance-booking/resent/{id}', ['uses' => 'User\AdvanceBookingController@resent']);

        Route::post('boats/book/{id}', 'Boat\BoatController@book');
        Route::post('boats/book/', 'Boat\BoatController@post_book');

        Route::get('user/dashboard/report', ['uses' => 'User\ReportController@report']);
        Route::post('user/dashboard/report_post', ['uses' => 'User\ReportController@report_post']);
        Route::post('user/dashboard/report/download_pdf/', ['uses' => 'User\ReportController@download_pdf']);
        Route::post('user/dashboard/report/download_xlxs', ['uses' => 'User\ReportController@download_xlxs']);

        Route::get('trip_invoice/download/{trip_id}','Invoice\InvoiceController@download');
    });

    # Owner Routes
    Route::group(['middleware' => ['auth', 'owner']], function()
    {
        Route::get('/owner/dashboard', ['uses' => 'Owner\ProfileController@index']);        
        Route::get('/owner/dashboard/profile/edit', ['uses' => 'Owner\ProfileController@edit']);
        Route::post('/owner/dashboard/profile/edit', ['uses' => 'Owner\ProfileController@update']);
       
        Route::get('/owner/dashboard/boats', ['uses' => 'Owner\BoatController@index']);
        Route::get('/owner/dashboard/boats/add', ['uses' => 'Owner\BoatController@add']);
        Route::post('/owner/dashboard/boats/add', ['uses' => 'Owner\BoatController@store']);        
        Route::post('/owner/dashboard/boats/{id}', ['uses' => 'Owner\BoatController@update']);
        Route::get('/owner/dashboard/boats/{id}/edit', ['uses' => 'Owner\BoatController@edit']);
        Route::get('/owner/dashboard/boats/{id}/delete', ['uses' => 'Owner\BoatController@delete']);

        Route::get('/owner/dashboard/captains', ['uses' => 'Owner\CaptainController@index']);
        Route::get('/owner/dashboard/captains/add', ['uses' => 'Owner\CaptainController@create']);
        Route::post('/owner/dashboard/captains/add', ['uses' => 'Owner\CaptainController@store']);
        Route::get('/owner/dashboard/captains/{id}/edit', ['uses' => 'Owner\CaptainController@edit']);
        Route::post('/owner/dashboard/captains/{id}/edit', ['uses' => 'Owner\CaptainController@update']);
        Route::get('/owner/dashboard/captains/{id}/delete', ['uses' => 'Owner\CaptainController@delete']);
        Route::get('/owner/dashboard/captains/promote', ['uses' => 'Owner\CaptainController@promote']);

        Route::get('/owner/dashboard/coordinators', ['uses' => 'Owner\CoordinatorController@index']);
        Route::get('/owner/dashboard/coordinators/add', ['uses' => 'Owner\CoordinatorController@create']);
        Route::post('/owner/dashboard/coordinators/add', ['uses' => 'Owner\CoordinatorController@store']);
        Route::get('/owner/dashboard/coordinators/{id}/edit', ['uses' => 'Owner\CoordinatorController@edit']);
        Route::post('/owner/dashboard/coordinators/{id}/edit', ['uses' => 'Owner\CoordinatorController@update']);
        Route::get('/owner/dashboard/coordinators/{id}/delete', ['uses' => 'Owner\CoordinatorController@delete']);
        Route::get('/owner/dashboard/coordinators/promote', ['uses' => 'Owner\CoordinatorController@promote']);
        Route::post('/owner/dashboard/coordinators/promote_post', ['uses' => 'Owner\CoordinatorController@promote_post']);

        Route::get('/owner/dashboard/contracts','Owner\ContractController@contract');
        Route::get('/owner/dashboard/contracts/addContracts','Owner\ContractController@addContracts');
        Route::post('/owner/dashboard/contracts/addContracts','Owner\ContractController@postAddContracts');

        Route::get('/owner/dashboard/catalogs','Owner\CatalogController@index');
        Route::get('/owner/dashboard/catalogs/create','Owner\CatalogController@create');
        Route::get('/owner/dashboard/catalogs/show/{catalog_id}','Owner\CatalogController@show');
        Route::get('/owner/dashboard/catalogs/edit/{catalog_id}','Owner\CatalogController@edit');
        Route::post('/owner/dashboard/catalogs/edit/{catalog_id}','Owner\CatalogController@update');
        Route::get('/owner/dashboard/catalogs/activate/{catalog_id}','Owner\CatalogController@activate');
        Route::get('/owner/dashboard/catalogs/remove/{id}','Owner\CatalogController@destroy');

        Route::get('owner/dashboard/my_bookings', ['uses' => 'Owner\BookingController@myBookings']);

        Route::get('owner/dashboard/report/trips', ['uses' => 'Owner\ReportController@report']);
        Route::post('owner/dashboard/report_post', ['uses' => 'Owner\ReportController@report_post']);
        Route::post('owner/dashboard/report/download_xlxs', ['uses' => 'Owner\ReportController@download_xlxs']);

        Route::get('owner/dashboard/report/collections', ['uses' => 'Owner\ReportController@collections']);
        Route::post('owner/dashboard/report/post_collections', ['uses' => 'Owner\ReportController@post_collections']);
        Route::post('owner/dashboard/report/collections/download_xlxs', ['uses' => 'Owner\ReportController@download_collections_xlxs']);

        Route::get('owner/dashboard/report/billing_statements', ['uses' => 'Owner\ReportController@billing_statements']);
        Route::post('owner/dashboard/report/post_billing_statements', ['uses' => 'Owner\ReportController@post_billing_statements']);
        Route::post('owner/dashboard/report/billing_statements/download_xlxs', ['uses' => 'Owner\ReportController@download_billing_statements_xlxs']);
    });

    # Coordinator Routes
    Route::group(['middleware' => ['auth', 'coordinator']], function()
    {
        Route::get('/coordinator/dashboard', ['uses' => 'Coordinator\ProfileController@index']);        
        Route::get('/coordinator/dashboard/boats', ['uses' => 'Coordinator\BoatController@index']);
        Route::get('/coordinator/dashboard/boats/map', ['uses' => 'Coordinator\BoatController@map']);
        Route::get('/coordinator/dashboard/books/{id}', ['uses' => 'Coordinator\BoatController@book']);
        Route::post('/coordinator/dashboard/post_book', ['uses' => 'Coordinator\BoatController@post_book']);
        Route::post('/coordinator/dashboard/post_book_create', ['uses' => 'Coordinator\BoatController@post_book_create']);
        Route::get('/coordinator/dashboard/book/{user_id}/{boat_id}', ['uses' => 'Coordinator\BoatController@book_boat']);
        Route::post('/coordinator/dashboard/post_book_boat', ['uses' => 'Coordinator\BoatController@post_book_boat']);

        Route::get('coordinator/dashboard/my-advance-bookings', ['uses' => 'Coordinator\AdvanceBookingController@myBookings']);
        Route::get('coordinator/dashboard/my-advance-bookings/book/{id}', ['uses' => 'Coordinator\AdvanceBookingController@book']);
        Route::post('coordinator/dashboard/my-advance-bookings/postBook', ['uses' => 'Coordinator\AdvanceBookingController@postBook']);
        Route::get('coordinator/dashboard/approve/{id}', ['uses' => 'Coordinator\AdvanceBookingController@approve']);

        Route::get('coordinator/dashboard/trips', ['uses' => 'Coordinator\TripController@trips']);
        Route::post('coordinator/dashboard/trips_post', ['uses' => 'Coordinator\TripController@trips_post']);
    });

    # Shipping Agency Routes
    Route::group(['middleware' => ['auth', 'company']], function()
    {
        Route::get('/company/dashboard', ['uses' => 'Company\ProfileController@index']);
        Route::get('/company/dashboard/profile/edit', ['uses' => 'Company\ProfileController@edit']);
        Route::post('/company/dashboard/profile/update', ['uses' => 'Company\ProfileController@update']);

        Route::get('/company/dashboard/contracts','Company\ContractController@contract');
        Route::get('/company/dashboard/contracts/activate/{id}','Company\ContractController@activate');

        Route::get('/company/dashboard/catalogs','Company\CatalogController@index');        
        Route::get('/company/dashboard/catalogs/create','Company\CatalogController@create');
        Route::get('/company/dashboard/catalogs/change_principle/{owner_id}/{catalogs_parent_id}','Company\CatalogController@change_principle');
        Route::post('/company/dashboard/catalogs/change_principle/{catalogs_parent_id}','Company\CatalogController@change_principle_post');
        Route::post('/company/dashboard/catalogs','Company\CatalogController@store');
        Route::get('/company/dashboard/catalogs/remove_principle/{catalogs_parent_id}/{principle_id}','Company\CatalogController@remove_principle');
        Route::get('/company/dashboard/catalogs/edit/{catalog_id}/','Company\CatalogController@edit');
        Route::post('/company/dashboard/catalogs/{catalog_id}/','Company\CatalogController@update');
        Route::get('/company/dashboard/catalogs/remove/{catalog_id}/','Company\CatalogController@destroy');

        Route::get('/company/dashboard/my_employee', ['uses' => 'Company\EmployeeController@index']);
        Route::post('/company/dashboard/my_employee/delete/{id}', ['uses' => 'Company\EmployeeController@delete']);
        Route::get('/company/dashboard/connect_employee', ['uses' => 'Company\EmployeeController@connect_employee']);
        Route::post('/company/dashboard/connect_employee', ['uses' => 'Company\EmployeeController@post_connect_employee']);

        Route::get('/company/dashboard/approve_list', ['uses' => 'Company\EmployeeController@pendingApproval']);
        Route::get('/company/dashboard/approve/{id}', ['uses' => 'Company\EmployeeController@approve']);
        Route::get('/company/dashboard/approve_delete/{id}', ['uses' => 'Company\EmployeeController@approve_delete']);
        Route::get('/company/dashboard/remove_list', ['uses' => 'Company\EmployeeController@removeList']);
        Route::get('/company/dashboard/remove/{id}', ['uses' => 'Company\EmployeeController@remove']);

        Route::resource('/company/dashboard/my_principals', 'Company\PrincipalController');
        
        Route::get('company/dashboard/my-advance-bookings', ['uses' => 'Company\AdvanceBookingController@myBookings']);
        Route::get('company/dashboard/advance-booking', ['uses' => 'Company\AdvanceBookingController@index']);
        Route::post('company/dashboard/advance-booking', ['uses' => 'Company\AdvanceBookingController@store']);
        Route::get('company/dashboard/advance-booking/resent/{id}', ['uses' => 'Company\AdvanceBookingController@resent']);

        Route::get('company/dashboard/report', ['uses' => 'Company\ReportController@report']);
        Route::post('company/dashboard/report_post', ['uses' => 'Company\ReportController@report_post']);
        Route::post('company/dashboard/report/download_xlxs', ['uses' => 'Company\ReportController@download_xlxs']);

        Route::get('company/dashboard/billing_statements', ['uses' => 'Company\ReportController@billing_statements']);
        Route::post('company/dashboard/billing_statements_post', ['uses' => 'Company\ReportController@billing_statements_post']);
        Route::post('company/dashboard/billing_statements/download_xlxs', ['uses' => 'Company\ReportController@download_billing_statements_xlxs']);
    });
    
    //CSR Routes
    Route::group(['middleware' => ['auth', 'csr']], function()
    {
        Route::get('/csr/dashboard', ['uses' => 'CSR\ProfileController@index']);

        Route::get('/csr/dashboard/users', ['uses' => 'CSR\UsersController@index']);
        Route::get('/csr/dashboard/boats/{user_id}', ['uses' => 'CSR\BoatController@index']);
        Route::post('/csr/dashboard/post_book_create', ['uses' => 'CSR\BoatController@post_book_create']);
        Route::get('/csr/dashboard/book/{user_id}/{boat_id}', ['uses' => 'CSR\BoatController@book_boat']);
        Route::post('/csr/dashboard/post_book_boat', ['uses' => 'CSR\BoatController@post_book_boat']);
        Route::post('/csr/dashboard/post_book', ['uses' => 'CSR\BoatController@post_book']);
        Route::get('/csr/dashboard/booking_details/{booking_id}', ['uses' => 'CSR\BoatController@booking_details']);

        Route::get('/csr/dashboard/trips', ['uses' => 'CSR\TripController@trips']);

        Route::get('/csr/dashboard/catalogs/{id}','CSR\CatalogController@catalogs');
        Route::get('/csr/dashboard/catalogs/{boat_type}/{trip_type}/{zone}/{owner_id}/{company_id?}','CSR\CatalogController@manage_catalogs');
        Route::get('/csr/dashboard/catalogs/downloadExcel/{catalog_id}/{zone}/','CSR\CatalogController@downloadExcel');
    });

});


/*
  |--------------------------------------------------------------------------
  | Consumer API Routes
  |--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'api'], function () {
    
    #Registration/Login Routes
    Route::post('user/register', 'API\UserController@register');
    Route::post('user/login', 'API\UserController@login');
    Route::post('user/forget-password', 'API\UserController@forgetPassword');

    #Contents
    Route::get('/content/{code}', 'API\ContentController@show');

    #Boat Routes
    Route::get('/boat/all', 'API\BoatController@index');
    Route::get('/boat/zone/{zone_code}', 'API\BoatController@listByZone');
    Route::get('/boat/show/{id}', 'API\BoatController@show');
    Route::post('/boat/search', 'API\BoatController@searchResults');

    #Boat Owner Routes
    Route::get('/owner/show/{id}', 'API\BoatOwnerController@show');

    #Boat Owner Routes
    Route::get('/captain/show/{id}', 'API\BoatCaptainController@show');

    #Base
    Route::get('/base/anchorages/{zone?}', 'API\BaseController@anchorages');

    #Private Routes
    Route::group(['middleware' => 'laravel.auth:api'], function()
    {
        Route::get('/user/profile', 'API\UserController@showProfile');
        Route::put('/user/profile', 'API\UserController@updateProfile');
        Route::put('/user/change-password', 'API\UserController@changePassword');
        Route::post('/user/photo', 'API\UserController@updatePhoto');
        Route::post('/user/boat-cost-calculator', 'API\BookingController@costCalculator');
        Route::post('/user/boat-booking', 'API\BookingController@bookNow');
        Route::get('/user/my-bookings', 'API\BookingController@myBookings');
        Route::get('/user/my-trips', 'API\TripController@myTrips');
        Route::get('/user/trip/{trip_id}', 'API\TripController@getTripDetails');
        Route::post('/user/trip/{trip_id}/pay', 'API\TripController@pay');
        Route::get('user/logout', 'API\UserController@logout');
    });
});


/*
  |--------------------------------------------------------------------------
  | CAPTAIN API Routes
  |--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'captain-api'], function () {
    
    #Login Routes
    Route::post('/captain/login', 'CaptainAPI\LoginController@login');
    

    #Private Routes
    Route::group(['middleware' => 'laravel.auth:api'], function()
    {   
        #my profile
        Route::get('/captain/my-profile', 'CaptainAPI\LoginController@showProfile');

        # Trip
        Route::get('/trips', 'CaptainAPI\TripController@index');
        Route::get('/trip/{trip_id}', 'CaptainAPI\TripController@show');
        Route::post('/trip/{trip_id}/update-status', 'CaptainAPI\TripController@updateStatus');
        Route::get('/trip/{trip_id}/mail-invoice', 'CaptainAPI\TripController@emailInvoice');
        Route::get('/trip/{trip_id}/notify-user', 'CaptainAPI\TripController@notifyUser');
        Route::post('/trip/{trip_id}/money-collected', 'CaptainAPI\TripController@moneyCollected');

        #Boat Status
        Route::get('/boat/{boat_id}', 'CaptainAPI\BoatController@getBoatStatus');
        Route::post('/boat/{boat_id}/update-status', 'CaptainAPI\BoatController@updateBoatStatus');
        Route::post('/boat/{boat_id}/update-location', 'CaptainAPI\BoatController@updateBoatLocation');

        #logout
        Route::post('/captain/logout', 'CaptainAPI\LoginController@logout');
    });
});
