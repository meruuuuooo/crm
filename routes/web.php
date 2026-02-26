<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crm\CompanyController;
use App\Http\Controllers\Crm\ContactController;
use App\Http\Controllers\Crm\DealController;
use App\Http\Controllers\Crm\LeadController;
use App\Http\Controllers\Crm\CampaignController;
use App\Http\Controllers\Crm\ProjectController;
use App\Http\Controllers\Crm\TaskController;
use App\Http\Controllers\Crm\ProposalController;
use App\Http\Controllers\Crm\ContractController;
use App\Http\Controllers\Crm\EstimationController;
use App\Http\Controllers\Crm\InvoiceController;
use App\Http\Controllers\Crm\ActivityController;
use App\Http\Controllers\Crm\PipelineController;
use App\Http\Controllers\Crm\ReportController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // CRM Module Routes
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::resource('companies',   CompanyController::class);
        Route::resource('contacts',    ContactController::class);
        Route::resource('deals',       DealController::class);
        Route::resource('leads',       LeadController::class);
        Route::resource('campaigns',   CampaignController::class);
        Route::resource('projects',    ProjectController::class);
        Route::resource('tasks',       TaskController::class);
        Route::resource('proposals',   ProposalController::class);
        Route::resource('contracts',   ContractController::class);
        Route::resource('estimations', EstimationController::class);
        Route::resource('invoices',    InvoiceController::class);
        Route::resource('activities',  ActivityController::class);
        Route::resource('pipelines',   PipelineController::class);
        Route::get('reports',          [ReportController::class, 'index'])->name('reports.index');
    });
});

require __DIR__.'/settings.php';
