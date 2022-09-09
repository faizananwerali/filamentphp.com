<?php

use App\Http\Controllers;
use App\Models\DocumentationPackage;
use App\Models\DocumentationVersion;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'home')->name('home');

Route::redirect('/discord', 'https://discord.gg/cpqnMTHZja')->name('discord');

Route::prefix('/docs')->group(function () {
    Route::get('/{versionSlug?}/{packageSlug?}/{pageSlug?}', Controllers\DocumentationController::class)->where('pageSlug', '.*')->name('docs');

    Route::redirect('/getting-started', '/docs/admin/getting-started');
    Route::redirect('/resources', '/docs/admin/resources');
    Route::redirect('/pages', '/docs/admin/pages');
    Route::redirect('/dashboard', '/docs/admin/dashboard');
    Route::redirect('/navigation', '/docs/admin/navigation');
    Route::redirect('/theming', '/docs/admin/theming');
    Route::redirect('/plugin-development', '/docs/admin/plugin-development');
});

Route::prefix('/links')->group(function () {
    Route::get('/', Controllers\Links\ListLinksController::class)->name('links');

    Route::name('links.')->group(function () {
        Route::prefix('/{link}')->group(function () {
            Route::get('/', Controllers\Links\ViewLinkController::class)->name('view');
        });
    });
});

Route::name('packages.')->prefix('/packages')->group(function () {
    Route::view('/admin', 'packages.admin')->name('admin');
    Route::view('/forms', 'packages.forms')->name('forms');
    Route::view('/tables', 'packages.tables')->name('tables');
});

Route::prefix('/plugins')->group(function () {
    Route::get('/', Controllers\Plugins\ListPluginsController::class)->name('plugins');

    Route::name('plugins.')->group(function () {
        Route::prefix('/{plugin:slug}')->group(function () {
            Route::get('/', Controllers\Plugins\ViewPluginController::class)->name('view');
        });
    });
});

Route::prefix('/tricks')->group(function () {
    Route::get('/', Controllers\Tricks\ListTricksController::class)->name('tricks');

    Route::name('tricks.')->group(function () {
        Route::prefix('/{trick:slug}')->group(function () {
            Route::get('/', Controllers\Tricks\ViewTrickController::class)->name('view');
        });
    });
});

Route::feeds();

Route::prefix('/blog')->group(function () {
    Route::get('/', Controllers\Blog\ListArticlesController::class)->name('blog');

    Route::name('blog.')->group(function () {
        Route::prefix('/{article:slug}')->group(function () {
            Route::get('/', Controllers\Blog\ViewArticleController::class)->name('article');
        });
    });
});

Route::redirect('/login', '/admin/login')->name('login');
