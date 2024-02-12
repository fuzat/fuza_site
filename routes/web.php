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


Route::group(['prefix' => \LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function() {
    Route::auth();
    Route::get('login/admin', 'Auth\LoginController@showLoginForm')->name('admin-login');
    Route::get('admin/forgot-pw', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin-forgot-pw');

    Route::get('/ajax/applications/get-company-location', 'CareerController@getCompanyLocation')->name('ajax.applications.get-company-location');
    Route::get('/ajax/posts/get-posts-by-menu', 'PostController@getPostsByMenu')->name('ajax.posts.get-posts-by-menu');

    #  NONE AUTHERIZATION
    Route::group(['as' => 'front.'], function () {
        Route::get('/', 'App\Http\Controllers\IndexController@home')->name('/');
        Route::get('/home', 'App\Http\Controllers\IndexController@home')->name('home');
        Route::get('/search', 'App\Http\Controllers\IndexController@search')->name('search');
        Route::get('/global-presence', 'GlobalPresenceController@index')->name('global-presence');

        // About
        Route::get('/about-us/{slug}-{hash_key}.html', 'AboutUsController@index')->name('about-us')->where(['slug' => '[A-Za-z-0-9]+']);

        // Our Business
        Route::get('/our-business/all-sectors', 'BusinessController@index')->name('our-business.index');
        Route::get('/our-business/{slug}-{hash_key}.html', 'BusinessController@show')->name('our-business.show')->where(['slug' => '[A-Za-z-0-9]+']);

        // Career
        Route::get('/jobs/all', 'CareerController@index')->name('jobs.index');
        Route::get('/jobs/{slug}-{hash_key}.html', 'CareerController@show')->name('jobs.show')->where(['slug' => '[A-Za-z-0-9]+']);
        Route::get('/ajax/jobs/get-job', 'CareerController@ajaxGetJob')->name('ajax.jobs.get-job');
        Route::get('/applications/join-talent-community', 'CareerController@getJoinTalentCommunity')->name('applicants.show-join-talent-community');
        Route::post('/applications/join-talent-community', 'CareerController@postJoinTalentCommunity')->name('applicants.send-join-talent-community');

        // Contact
        Route::get('/contact', 'ContactController@index')->name('contact');
        Route::post('/contact', 'ContactController@store')->name('contact.store');

        // News
        Route::get('/news', 'NewsController@index')->name('news.index');
        Route::get('/news/{slug}-{hash_key}.html', 'NewsController@show')->name('news.show')->where(['slug' => '[A-Za-z-0-9]+']);

        // Post
        Route::get('/post/{hash_key}', 'PostController@index')->name('post.index');
    });

//    # AUTHERIZATION
    Route::group(['middleware' => ['auth']], function() {
        /*
        |--------------------------------------------------------------------------
        | Admin Routes
        |--------------------------------------------------------------------------
        */
        Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
            /*** Home / Dashboard ***/
            Route::get('/', 'IndexController@dashboard')->name('dashboard');
//
//        /*** User ***/
//        Route::get('/users', 'UserController@index')->name('users.index')->middleware('permission:admin.users.index');
//        Route::get('/users/create', 'UserController@create')->name('users.create')->middleware('permission:admin.users.create');
//        Route::post('/users', 'UserController@store')->name('users.store')->middleware('permission:admin.users.create');
//        Route::get('/users/profile', 'UserController@show')->name('users.show')->middleware('permission:admin.*');
//        Route::post('/users/profile', 'UserController@updateProfile')->name('users.profile')->middleware('permission:admin.*');
//        Route::get('/users/{id}/edit', 'UserController@edit')->name('users.edit')->middleware('permission:admin.users.edit');
//        Route::match(['put', 'patch'], '/users/{id}', 'UserController@update')->name('users.update')->middleware('permission:admin.users.edit');
//        Route::post('/ajax/users/change-status', 'UserController@changeStatus')->name('ajax.users.change-status')->middleware('permission:admin.users.edit');
//        Route::post('/users-reset-password/{id}', 'UserController@resetPassword')->name('users.reset-password')->middleware('permission:admin.users.edit');
//
//        /*** Role ***/
//        Route::get('/roles', 'RoleController@index')->name('roles.index')->middleware('permission:admin.roles.index');
//        Route::get('/roles/create', 'RoleController@create')->name('roles.create')->middleware('permission:admin.roles.create');
//        Route::post('/roles', 'RoleController@store')->name('roles.store')->middleware('permission:admin.roles.create');
//        Route::get('/roles/{id}', 'RoleController@show')->name('roles.show')->middleware('permission:admin.roles.show');
//        Route::get('/roles/{id}/edit', 'RoleController@edit')->name('roles.edit')->middleware('permission:admin.roles.edit');
//        Route::match(['put', 'patch'], '/roles/{id}', 'RoleController@update')->name('roles.update')->middleware('permission:admin.roles.edit');
//        Route::post('/roles-permissions/{id}', 'RoleController@changePermission')->name('roles.permissions.change')->middleware('permission:admin.roles.edit');
//        Route::post('/roles-copy/{id}', 'RoleController@copyRole')->name('roles.copy')->middleware('permission:admin.roles.edit');

            /*** Industry ***/
            Route::get('/industries', 'IndustryController@index')->name('industries.index');
            Route::get('/industries/create', 'IndustryController@create')->name('industries.create');
            Route::post('/industries', 'IndustryController@store')->name('industries.store');
            Route::get('/industries/{id}/edit', 'IndustryController@edit')->name('industries.edit');
            Route::match(['put', 'patch'], '/industries/{id}', 'IndustryController@update')->name('industries.update');
            Route::delete('/industries/{id}', 'IndustryController@destroy')->name('industries.destroy');
            Route::post('/ajax/industries/change-status', 'IndustryController@changeStatus')->name('ajax.industries.change-status');

            /*** Career - Ngành nghề ***/
            Route::get('/businesses', 'BusinessController@index')->name('businesses.index');
            Route::get('/businesses/create', 'BusinessController@create')->name('businesses.create');
            Route::post('/businesses', 'BusinessController@store')->name('businesses.store');
            Route::get('/businesses/{id}', 'BusinessController@show')->name('businesses.show');
            Route::get('/businesses/{id}/edit', 'BusinessController@edit')->name('businesses.edit');
            Route::match(['put', 'patch'], '/businesses/{id}', 'BusinessController@update')->name('businesses.update');
            Route::delete('/businesses/{id}', 'BusinessController@destroy')->name('businesses.destroy');
            Route::post('/ajax/businesses/change-status', 'BusinessController@changeStatus')->name('ajax.businesses.change-status');

            /*** Category ***/
            Route::get('/categories', 'CategoryController@index')->name('categories.index');
            Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
            Route::post('/categories', 'CategoryController@store')->name('categories.store');
            Route::get('/categories/{id}/edit', 'CategoryController@edit')->name('categories.edit');
            Route::match(['put', 'patch'], '/categories/{id}', 'CategoryController@update')->name('categories.update');
            Route::post('/ajax/categories/change-status', 'CategoryController@changeStatus')->name('ajax.categories.change-status');

            /*** Location - Địa điểm tuyển dụng ***/
            Route::get('/locations', 'LocationController@index')->name('locations.index');
            Route::get('/locations/create', 'LocationController@create')->name('locations.create');
            Route::post('/locations', 'LocationController@store')->name('locations.store');
            Route::get('/locations/{id}/edit', 'LocationController@edit')->name('locations.edit');
            Route::match(['put', 'patch'], '/locations/{id}', 'LocationController@update')->name('locations.update');
            Route::delete('/locations/{id}', 'LocationController@destroy')->name('locations.destroy');
            Route::post('/ajax/locations/change-status', 'LocationController@changeStatus')->name('ajax.locations.change-status');

            /*** Banner ***/
            Route::get('/banners', 'BannerController@index')->name('banners.index');
            Route::get('/banners/create', 'BannerController@create')->name('banners.create');
            Route::get('/banners/{id}/edit', 'BannerController@edit')->name('banners.edit');
            Route::match(['put', 'patch'], '/banners/{id}', 'BannerController@update')->name('banners.update');
            Route::delete('/banners/{id}', 'BannerController@destroy')->name('banners.destroy');
            Route::post('/banners', 'BannerController@store')->name('banners.store');
            Route::post('/ajax/banners/change-status', 'BannerController@changeStatus')->name('ajax.banners.change-status');

            /*** Benefit ***/
            Route::get('/milestones', 'MilestoneController@index')->name('milestones.index');
            Route::get('/milestones/create', 'MilestoneController@create')->name('milestones.create');
            Route::post('/milestones', 'MilestoneController@store')->name('milestones.store');
            Route::get('/milestones/{id}/edit', 'MilestoneController@edit')->name('milestones.edit');
            Route::match(['put', 'patch'], '/milestones/{id}', 'MilestoneController@update')->name('milestones.update');
            Route::delete('/milestones/{id}', 'MilestoneController@destroy')->name('milestones.destroy');
            Route::post('/ajax/milestones/change-status', 'MilestoneController@changeStatus')->name('ajax.milestones.change-status');

            /*** Job ***/
            Route::get('/jobs', 'JobController@index')->name('jobs.index');
            Route::get('/jobs/create', 'JobController@create')->name('jobs.create');
            Route::post('/jobs', 'JobController@store')->name('jobs.store');
            Route::get('/jobs/{id}', 'JobController@show')->name('jobs.show');
            Route::get('/jobs/{id}/edit', 'JobController@edit')->name('jobs.edit');
            Route::match(['put', 'patch'], '/jobs/{id}', 'JobController@update')->name('jobs.update');
            Route::delete('/jobs/{id}', 'JobController@destroy')->name('jobs.destroy');
            Route::post('/ajax/jobs/change-status', 'JobController@changeStatus')->name('ajax.jobs.change-status');

            /*** Applicant ***/
            Route::get('/groups', 'GroupController@index')->name('groups.index');
            Route::get('/groups/create', 'GroupController@create')->name('groups.create');
            Route::post('/groups', 'GroupController@store')->name('groups.store');
            Route::get('/groups/{id}/edit', 'GroupController@edit')->name('groups.edit');
            Route::match(['put', 'patch'], '/groups/{id}', 'GroupController@update')->name('groups.update');
            Route::delete('/groups/{id}', 'GroupController@destroy')->name('groups.destroy');
            Route::post('/ajax/groups/change-status', 'GroupController@changeStatus')->name('ajax.groups.change-status');

            /*** News - Tin tức ***/
            Route::get('/news', 'NewsController@index')->name('news.index');
            Route::get('/news/create', 'NewsController@create')->name('news.create');
            Route::post('/news', 'NewsController@store')->name('news.store');
            Route::get('//news/{id}', 'NewsController@show')->name('news.show');
            Route::get('/news/{id}/edit', 'NewsController@edit')->name('news.edit');
            Route::match(['put', 'patch'], '/news/{id}', 'NewsController@update')->name('news.update');
            Route::delete('/news/{id}', 'NewsController@destroy')->name('news.destroy');
            Route::post('/ajax/news/change-status', 'NewsController@changeStatus')->name('ajax.news.change-status');

            /*** Position ***/
            Route::get('/positions', 'PositionController@index')->name('positions.index');
            Route::get('/positions/create', 'PositionController@create')->name('positions.create');
            Route::post('/positions', 'PositionController@store')->name('positions.store');
            Route::get('/positions/{id}/edit', 'PositionController@edit')->name('positions.edit');
            Route::match(['put', 'patch'], '/positions/{id}', 'PositionController@update')->name('positions.update');
            Route::delete('/positions/{id}', 'PositionController@destroy')->name('positions.destroy');
            Route::post('/ajax/positions/change-status', 'PositionController@changeStatus')->name('ajax.positions.change-status');

            /*** Menu ***/
            Route::get('/menus', 'MenuController@index')->name('menus.index');
            Route::get('/menus/create', 'MenuController@create')->name('menus.create');
            Route::post('/menus', 'MenuController@store')->name('menus.store');
            Route::get('/menus/{id}/edit', 'MenuController@edit')->name('menus.edit');
            Route::match(['put', 'patch'], '/menus/{id}', 'MenuController@update')->name('menus.update');
            Route::post('/ajax/menus/change-status', 'MenuController@changeStatus')->name('ajax.menus.change-status');
            Route::get('/menus/sorting', 'MenuController@sorting')->name('menus.sorting');
            Route::post('/ajax/menus/sorting', 'MenuController@storeSorting')->name('ajax.menus.sorting');

            /*** Post ***/
            Route::get('/posts', 'PostController@index')->name('posts.index');
            Route::get('/posts/create', 'PostController@create')->name('posts.create');
            Route::post('/posts', 'PostController@store')->name('posts.store');
            Route::get('/posts/{id}/edit', 'PostController@edit')->name('posts.edit');
            Route::match(['put', 'patch'], '/posts/{id}', 'PostController@update')->name('posts.update');
            Route::delete('/posts/{id}', 'PostController@destroy')->name('posts.destroy');
            Route::post('/ajax/posts/change-status', 'PostController@changeStatus')->name('ajax.posts.change-status');
            Route::post('/ajax/posts/upload-file', 'PostController@uploadFile')->name('ajax.posts.upload-file');

            /*** Core Value ***/
            Route::get('/core-values', 'CoreValueController@index')->name('core-values.index');
            Route::get('/core-values/create', 'CoreValueController@create')->name('core-values.create');
            Route::post('/core-values', 'CoreValueController@store')->name('core-values.store');
            Route::get('/core-values/{id}/edit', 'CoreValueController@edit')->name('core-values.edit');
            Route::match(['put', 'patch'], '/core-values/{id}', 'CoreValueController@update')->name('core-values.update');
            Route::delete('/core-values/{id}', 'CoreValueController@destroy')->name('core-values.destroy');
            Route::post('/ajax/core-values/change-status', 'CoreValueController@changeStatus')->name('ajax.core-values.change-status');

            /*** Carousel ***/
            Route::get('/carousels', 'CarouselController@index')->name('carousels.index');
            Route::get('/carousels/create', 'CarouselController@create')->name('carousels.create');
            Route::post('/carousels', 'CarouselController@store')->name('carousels.store');
            Route::get('/carousels/{id}/edit', 'CarouselController@edit')->name('carousels.edit');
            Route::match(['put', 'patch'], '/carousels/{id}', 'CarouselController@update')->name('carousels.update');
            Route::delete('/carousels/{id}', 'CarouselController@destroy')->name('carousels.destroy');
            Route::post('/ajax/carousels/change-status', 'CarouselController@changeStatus')->name('ajax.carousels.change-status');

            /*** Partner ***/
            Route::get('/partners', 'PartnerController@index')->name('partners.index');
            Route::get('/partners/create', 'PartnerController@create')->name('partners.create');
            Route::get('/partners/{id}/edit', 'PartnerController@edit')->name('partners.edit');
            Route::post('/partners', 'PartnerController@store')->name('partners.store');
            Route::match(['put', 'patch'], '/partners/{id}', 'PartnerController@update')->name('partners.update');
            Route::post('/ajax/partners/change-status', 'PartnerController@changeStatus')->name('ajax.partners.change-status');
            Route::delete('/partners/{id}', 'PartnerController@destroy')->name('partners.destroy');

            /*** Global Presence ***/
            Route::get('/global-presence', 'GlobalPresenceController@index')->name('global-presence.index');
            Route::get('/global-presence/create', 'GlobalPresenceController@create')->name('global-presence.create');
            Route::post('/global-presence', 'GlobalPresenceController@store')->name('global-presence.store');
            Route::get('/global-presence/{id}/edit', 'GlobalPresenceController@edit')->name('global-presence.edit');
            Route::match(['put', 'patch'], '/global-presence/{id}', 'GlobalPresenceController@update')->name('global-presence.update');
            Route::delete('/global-presence/{id}', 'GlobalPresenceController@destroy')->name('global-presence.destroy');
            Route::post('/ajax/global-presence/change-status', 'GlobalPresenceController@changeStatus')->name('ajax.global-presence.change-status');

            /*** Contact ***/
            Route::get('/contacts', 'ContactController@index')->name('contacts.index');
            Route::delete('/contacts/{id}', 'ContactController@destroy')->name('contacts.destroy');
            Route::post('/ajax/contacts/change-status', 'ContactController@changeStatus')->name('ajax.contacts.change-status');

            /*** Application ***/
            Route::get('/applications', 'ApplicationController@index')->name('applications.index');
            Route::delete('/applications/{id}', 'ApplicationController@destroy')->name('applications.destroy');
            Route::post('/ajax/applications/change-status', 'ApplicationController@changeStatus')->name('ajax.applications.change-status');

            /*** Setting ***/
            Route::get('/settings', 'SettingController@edit')->name('settings.edit');
            Route::match(['put', 'patch'], '/settings', 'SettingController@update')->name('settings.update');

//        /*** Notification - Thông báo ***/
//        Route::get('/notifications', 'NotificationController@index')->name('notifications.index')->middleware('permission:admin.notifications.index');
//        Route::post('/ajax/notifications/change-status', 'NotificationController@changeStatus')->name('ajax.notifications.change-status')->middleware('permission:admin.notifications.edit');

            /*** Board Of Directors ***/
            Route::get('/board-directors', 'BoardDirectorController@index')->name('board-directors.index');
            Route::get('/board-directors/create', 'BoardDirectorController@create')->name('board-directors.create');
            Route::post('/board-directors', 'BoardDirectorController@store')->name('board-directors.store');
            Route::get('/board-directors/{id}/edit', 'BoardDirectorController@edit')->name('board-directors.edit');
            Route::match(['put', 'patch'], '/board-directors/{id}', 'BoardDirectorController@update')->name('board-directors.update');
            Route::delete('/board-directors/{id}', 'BoardDirectorController@destroy')->name('board-directors.destroy');
            Route::post('/ajax/board-directors/change-status', 'BoardDirectorController@changeStatus')->name('ajax.board-directors.change-status');

            /*** Company ***/
            Route::get('/companies', 'CompanyController@index')->name('companies.index');
            Route::get('/companies/create', 'CompanyController@create')->name('companies.create');
            Route::post('/companies', 'CompanyController@store')->name('companies.store');
            Route::get('/companies/{id}/edit', 'CompanyController@edit')->name('companies.edit');
            Route::match(['put', 'patch'], '/companies/{id}', 'CompanyController@update')->name('companies.update');
            Route::delete('/companies/{id}', 'CompanyController@destroy')->name('companies.destroy');
            Route::post('/ajax/companies/change-status', 'CompanyController@changeStatus')->name('ajax.companies.change-status');

            /*** Vision - Mission ***/
            Route::get('/vision-mission', 'VisionMissionController@index')->name('vision-mission.index');
            Route::get('/vision-mission/create', 'VisionMissionController@create')->name('vision-mission.create');
            Route::post('/vision-mission', 'VisionMissionController@store')->name('vision-mission.store');
            Route::get('/vision-mission/{id}/edit', 'VisionMissionController@edit')->name('vision-mission.edit');
            Route::match(['put', 'patch'], '/vision-mission/{id}', 'VisionMissionController@update')->name('vision-mission.update');
            Route::delete('/vision-mission/{id}', 'VisionMissionController@destroy')->name('vision-mission.destroy');
            Route::post('/ajax/vision-mission/change-status', 'VisionMissionController@changeStatus')->name('ajax.vision-mission.change-status');

            /*** Job Type ***/
            Route::get('/job-types', 'JobTypeController@index')->name('job-types.index');
            Route::get('/job-types/create', 'JobTypeController@create')->name('job-types.create');
            Route::post('/job-types', 'JobTypeController@store')->name('job-types.store');
            Route::get('/job-types/{id}/edit', 'JobTypeController@edit')->name('job-types.edit');
            Route::match(['put', 'patch'], '/job-types/{id}', 'JobTypeController@update')->name('job-types.update');
            Route::delete('/job-types/{id}', 'JobTypeController@destroy')->name('job-types.destroy');
            Route::post('/ajax/job-types/change-status', 'JobTypeController@changeStatus')->name('ajax.job-types.change-status');

            /*** Job Level ***/
            Route::get('/job-levels', 'JobLevelController@index')->name('job-levels.index');
            Route::get('/job-levels/create', 'JobLevelController@create')->name('job-levels.create');
            Route::post('/job-levels', 'JobLevelController@store')->name('job-levels.store');
            Route::get('/job-levels/{id}/edit', 'JobLevelController@edit')->name('job-levels.edit');
            Route::match(['put', 'patch'], '/job-levels/{id}', 'JobLevelController@update')->name('job-levels.update');
            Route::delete('/job-levels/{id}', 'JobLevelController@destroy')->name('job-levels.destroy');
            Route::post('/ajax/job-levels/change-status', 'JobLevelController@changeStatus')->name('ajax.job-levels.change-status');

            /*** Language ***/
            Route::get('/languages', 'LanguageController@index')->name('languages.index');
            Route::post('/ajax/languages/change-status', 'LanguageController@changeStatus')->name('ajax.languages.change-status');
        });
    });
});
