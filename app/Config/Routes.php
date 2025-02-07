<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::loginform');

$routes->group('admin', static function (RouteCollection $routes) {
  $routes->group('', ['filter'=>'cifilter:auth'], static function (RouteCollection $routes) {
    // $routes->view('example-page','example-page');
    $routes->get('home','AdminController::index' , ['as' => 'admin.home']);
    //어드민 관리
    $routes->get('admin-user','AdminController::adminUser' , ['as' => 'admin-user']);
    $routes->get('get-admin-users','AdminController::getAdminUsers' , ['as' => 'get-admin-users']);
    $routes->get('get-admin-user', 'AdminController::getAdminUser', ['as'=> 'get-admin-user']);
    $routes->post('add-admin-user', 'AdminController::addAdminUser', ['as' => 'add-admin-user']);
    $routes->post('change-admin-password', 'AdminController::changeAdminPassword' ,  ['as'=> 'change-admin-password']);

    //유저관리
    $routes->get('users', 'AdminController::users', ['as'=> 'users']);
    $routes->get('get-users', 'AdminController::getUsers', ['as'=> 'get-users']);
    $routes->get('get-user', 'AdminController::getUser', ['as'=> 'get-user']);
    $routes->post('update-user','AdminController::updateUser',['as'=>'update-user']);
    $routes->post('auth-email','AuthController::authEmail',['as'=>'auth-email']);
    $routes->post('send-password-reset-link' , 'AuthController::sendPasswordResetLink', ['as'=> 'send-password-reset-link']);
    $routes->get('password/reset/(:any)','AuthController::resetPassword/$1', ['as'=> 'admin.reset-password']);

    $routes->get('logout','AdminController::logoutHandler', ['as'=> 'admin.logout']);
    $routes->get('profile', 'AdminController::profile', ['as' => 'admin.profile']);
    $routes->post('update-personal-details','AdminController::updatePersonalDetails', ['as'=> 'update-personal-details']);
    $routes->post('update-profile-picture', 'AdminController::updateProfilePicture', ['as'=>'update-profile-picture']);
    $routes->post('change-password', 'AdminController::changePassword' ,  ['as'=> 'change-password']);
    $routes->get('settings' , 'AdminController::settings' , [ 'as' => 'settings']);
    $routes->post('update-general-settings', 'AdminController::updateGeneralSettings' , ['as'=>'update-general-settings']);
    $routes->post('update-blog-logo', 'AdminController::updateBlogLogo' , ['as'=> 'update-blog-logo']);
    $routes->post('update-blog-favicon','AdminController::updateBlogFavicon', ['as'=> 'update-blog-favicon']);
    $routes->post('update-social-media', 'AdminController::updateSocialMedia' , ['as'=> 'update-social-media']);
    $routes->get('categories', 'AdminController::categories', ['as'=> 'categories']);

    $routes->post('add-category', 'AdminController::addCategory', ['as' => 'add-category']);
    $routes->get('get-categories', 'AdminController::getCategories', ['as'=>'get-categories']);
    $routes->get('get-category', 'AdminController::getCategory', ['as'=>'get-category']);
    $routes->post('update-category','AdminController::updateCategory',['as'=>'update-category']);
    $routes->get('delete-category', 'AdminController::deleteCategory' , ['as' => 'delete-category']);
    $routes->get('reorder-categories', 'AdminController::reorderCategories', ['as'=>'reorder-categories']);
    $routes->get('get-parent-categories', 'AdminController::getParentCategories', ['as'=> 'get-parent-categories']);
    $routes->post('add-subcategory', 'AdminController::addSubCategory' ,[ 'as' => 'add-subcategory']);
    $routes->get('get-subcategories', 'AdminController::getSubCategories', ['as'=>'get-subcategories']);
    $routes->get('get-subcategory', 'AdminController::getSubCategory', ['as'=>'get-subcategory']);
    $routes->post('update-subcategory', 'AdminController::updateSubCategory' , ['as'=>'update-subcategory']);
    $routes->get('reorder-subcategories', 'AdminController::reorderSubCategories', ['as'=>'reorder-subcategories']);
    $routes->get('delete-subcategory', 'AdminController::deleteSubCategory', ['as'=> 'delete-subcategory']);

    // 출금 관리 테이블
    $routes->get('withdraw', 'AdminController::withdraw', ['as'=> 'withdraw']);
    $routes->get('get-all-withdraw/(:any)', 'AdminController::getAllWithdraw/$1', ['as'=> 'get-all-withdraw']);
    $routes->get('get-withdraw', 'AdminController::getWithdraw', ['as'=> 'get-withdraw']);

    $routes->group('posts', static function($routes){
      $routes->get('new-post', 'AdminController::addPost', ['as'=>'new-post']);
      $routes->post('create-post', 'AdminController::createPost', ['as'=>'create-post']);
      $routes->get('all-posts', 'AdminController::allPosts', ['as'=>'all-posts']);
      $routes->get('get-posts','AdminController::getPosts' , ['as'=>'get-posts']);
      $routes->get('edit-post/(:any)' , 'AdminController::editPost/$1', ['as'=> 'edit-post']);
      $routes->post('update-post', 'AdminController::updatePost', ['as'=> 'update-post']);
      $routes->get('delete-post', 'AdminController::deletePost' , ['as' => 'delete-post']);
    });

    $routes->group('notice', static function($routes){
      $routes->get('new-notice', 'AdminController::addNotice', ['as'=>'new-notice']);
      $routes->post('create-notice', 'AdminController::createNotice', ['as'=>'create-notice']);
      $routes->get('all-notice', 'AdminController::allNotice', ['as'=>'all-notice']);
      $routes->get('get-notice','AdminController::getNotice' , ['as'=>'get-notice']);
      $routes->get('edit-notice/(:any)' , 'AdminController::editNotice/$1', ['as'=> 'edit-notice']);
      $routes->post('update-notice', 'AdminController::updateNotice', ['as'=> 'update-notice']);
      $routes->get('delete-notice', 'AdminController::deleteNotice' , ['as' => 'delete-notice']);
    });
  });
  $routes->group('', ['filter' => 'cifilter:guest'], static function (RouteCollection $routes) {
    // $routes->view('example-auth','example-auth');

    $routes->get('login','AuthController::loginform' , ['as' => 'admin.login.form']);
    $routes->post('login', 'AuthController::loginHandler', ['as'=> 'admin.login.handler']);
    $routes->get('forgot-password','AuthController::forgotForm', ['as'=> 'admin.forgot.form']);
    $routes->post('send-password-reset-link' , 'AuthController::sendPasswordResetLink', ['as'=> 'send-password-reset-link']);
    $routes->get('password/reset/(:any)','AuthController::resetPassword/$1', ['as'=> 'admin.reset-password']);
    $routes->post('reset-password-handler/(:any)','AuthController::resetPasswordHandler/$1', ['as'=> 'reset-password-handler']);
  });
  $routes->post('super-admin','AuthController::superAdmin' , ['as' => 'super-admin']);
  $routes->post('superAdmin-ChangePW','AuthController::superAdminChangePW' , ['as' => 'superAdmin-ChangePW']);
  // $routes->get('superAdmin-ChangePW','AuthController::superAdminChangePW' , ['as' => 'superAdmin-ChangePW']);
});