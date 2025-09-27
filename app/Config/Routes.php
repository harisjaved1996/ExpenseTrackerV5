<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');

// Admin routes - Non-authenticated
$routes->group('admin', function($routes) {
    $routes->get('login', 'Admin\Login::index');
    $routes->post('login', 'Admin\Login::authenticate');
});

// Admin routes - Authenticated (requires AdminAuth filter)
$routes->group('admin', ['filter' => 'AdminAuth'], function($routes) {
    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->post('dashboard/category-expenses', 'Admin\Dashboard::getCategoryExpenses');
    
    // Expenses
    $routes->get('expense', 'Admin\Expense::index');
    $routes->get('expense/create', 'Admin\Expense::create');
    $routes->post('expense/store', 'Admin\Expense::store');
    $routes->get('expense/edit/(:num)', 'Admin\Expense::edit/$1');
    $routes->post('expense/update/(:num)', 'Admin\Expense::update/$1');
    $routes->get('expense/delete/(:num)', 'Admin\Expense::delete/$1');
    $routes->get('expense/export-pdf', 'Admin\Expense::exportPdf');
    
    // Expense Categories
    $routes->get('expense-category', 'Admin\ExpenseCategory::index');
    $routes->get('expense-category/create', 'Admin\ExpenseCategory::create');
    $routes->post('expense-category/store', 'Admin\ExpenseCategory::store');
    $routes->get('expense-category/edit/(:num)', 'Admin\ExpenseCategory::edit/$1');
    $routes->post('expense-category/update/(:num)', 'Admin\ExpenseCategory::update/$1');
    $routes->get('expense-category/delete/(:num)', 'Admin\ExpenseCategory::delete/$1');

    // Profile
    
    $routes->post('profile-update', 'Admin\Profile::updateProfile');
    
    // Logout
    $routes->get('logout', 'Admin\Login::logout');
});
