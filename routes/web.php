<?php


$router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$router->post('login', 'Auth\LoginController@login');
$router->post('logout', 'Auth\LoginController@logout');

// Registration Routes...
$router->get('register', 'Auth\RegisterController@showRegistrationForm');
$router->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$router->post('password/reset', 'Auth\ResetPasswordController@reset');

$router->get('/', 'HomeController@index');
