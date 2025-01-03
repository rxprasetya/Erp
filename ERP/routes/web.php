<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BomsController;
use App\Http\Controllers\RfqsController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RfqSalesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\ProductionsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Controller::class, 'index'])->name('dashboard');

Route::get('/product', [ProductsController::class, 'index'])->name('product');

Route::get('/product/create-product', [ProductsController::class , 'create'])->name('create-product');

Route::get('/product/update-product/{id}', [ProductsController::class , 'edit'])->name('edit-product');

Route::post('/product/create-product', [ProductsController::class, 'insert'])->name('insert-product');

Route::post('/product/update-product/{id}', [ProductsController::class, 'update'])->name('update-product');

Route::get('/product/delete-product/{id}', [ProductsController::class, 'delete'])->name('delete-product');


Route::get('/material', [MaterialsController::class, 'index'])->name('material');

Route::get('/create-material', [MaterialsController::class, 'create'])->name('create-material');

Route::get('/material/update-material/{id}', [MaterialsController::class , 'edit'])->name('edit-material');

Route::post('/create-material', [MaterialsController::class, 'insert'])->name('insert-material');

Route::post('/material/update-material/{id}', [MaterialsController::class, 'update'])->name('update-material');

Route::get('/material/delete-material/{id}', [MaterialsController::class, 'delete'])->name('delete-material');


Route::get('/vendor', [VendorsController::class, 'index'])->name('vendor');

Route::get('/create-vendor', [VendorsController::class, 'create'])->name('create-vendor');

Route::get('/vendor/update-vendor/{id}', [VendorsController::class , 'edit'])->name('edit-vendor');

Route::post('/create-vendor', [VendorsController::class, 'insert'])->name('insert-vendor');

Route::post('/vendor/update-vendor/{id}', [VendorsController::class, 'update'])->name('update-vendor');

Route::get('/vendor/delete-vendor/{id}', [VendorsController::class, 'delete'])->name('delete-vendor');


Route::get('/rfq', [RfqsController::class, 'index'])->name('rfq');

Route::get('/rfq/create-rfq', [RfqsController::class, 'create'])->name('create-rfq');

Route::get('/rfq/update-rfq', [RfqsController::class , 'edit'])->name('edit-rfq');

Route::get('/rfq/preview-rfq', [RfqsController::class , 'preview'])->name('preview-rfq');

Route::post('/rfq/create-rfq', [RfqsController::class, 'insert'])->name('insert-rfq');

Route::post('/rfq/update-rfq', [RfqsController::class, 'update'])->name('update-rfq');

Route::get('/rfq/delete-rfq', [RfqsController::class, 'delete'])->name('delete-rfq');

Route::post('/rfq/validate-rfq', [RfqsController::class, 'validated'])->name('validate-rfq');

Route::post('/rfq/confirm-rfq', [RfqsController::class, 'confirmed'])->name('confirm-rfq');

Route::get('/rfq/get-cost', [RfqsController::class, 'getCost'])->name('get-cost');


Route::get('/bom', [BomsController::class, 'index'])->name('bom');

Route::get('/bom/create-bom', [BomsController::class, 'create'])->name('create-bom');

Route::get('/bom/update-bom', [BomsController::class, 'edit'])->name('edit-bom');

Route::get('/bom/preview-bom', [BomsController::class , 'preview'])->name('preview-bom');

Route::post('/bom/create-bom', [BomsController::class, 'insert'])->name('insert-bom');

Route::post('/bom/update-bom', [BomsController::class, 'update'])->name('update-bom');

Route::get('/bom/delete-bom', [BomsController::class, 'delete'])->name('delete-bom');


Route::get('/production', [ProductionsController::class, 'index'])->name('production');

Route::get('/production/create-production', [ProductionsController::class, 'create'])->name('create-production');

Route::get('/production/update-production', [ProductionsController::class, 'edit'])->name('edit-production');

Route::get('/production/preview-production', [ProductionsController::class, 'preview'])->name('preview-production');

Route::post('/production/is-available', [ProductionsController::class, 'isAvailable'])->name('is-available');

Route::post('/production/validate-production', [ProductionsController::class, 'validated'])->name('validate-production');

Route::post('/production/confirm-production', [ProductionsController::class, 'confirmed'])->name('confirm-production');

Route::post('/production/get-materials', [ProductionsController::class, 'getMaterials'])->name('get-materials');

Route::post('/production/create-production', [ProductionsController::class, 'insert'])->name('insert-production');

Route::post('/production/update-production', [ProductionsController::class, 'update'])->name('update-production');

Route::get('/production/delete-production', [ProductionsController::class, 'delete'])->name('delete-production');


Route::get('/customer', [CustomersController::class, 'index'])->name('customer');

Route::get('/create-customer', [CustomersController::class, 'create'])->name('create-customer');

Route::get('/customer/update-customer/{id}', [CustomersController::class , 'edit'])->name('edit-customer');

Route::post('/create-customer', [CustomersController::class, 'insert'])->name('insert-customer');

Route::post('/customer/update-customer/{id}', [CustomersController::class, 'update'])->name('update-customer');

Route::get('/customer/delete-customer/{id}', [CustomersController::class, 'delete'])->name('delete-customer');


Route::get('/rfq-sales', [RfqSalesController::class, 'index'])->name('rfq-sales');

Route::get('/rfq-sales/create-rfq-sales', [RfqSalesController::class, 'create'])->name('create-rfq-sales');

Route::get('/rfq-sales/update-rfq-sales', [RfqSalesController::class , 'edit'])->name('edit-rfq-sales');

Route::get('/rfq-sales/preview-rfq-sales', [RfqSalesController::class , 'preview'])->name('preview-rfq-sales');

Route::post('/rfq-sales/create-rfq-sales', [RfqSalesController::class, 'insert'])->name('insert-rfq-sales');

Route::post('/rfq-sales/update-rfq-sales', [RfqSalesController::class, 'update'])->name('update-rfq-sales');

Route::get('/rfq-sales/delete-rfq-sales', [RfqSalesController::class, 'delete'])->name('delete-rfq-sales');

Route::post('/rfq-sales/deliver-rfq-sales', [RfqSalesController::class, 'delivered'])->name('deliver-rfq-sales');

Route::post('/rfq-sales/confirm-rfq-sales', [RfqSalesController::class, 'confirmed'])->name('confirm-rfq-sales');

Route::get('/rfq-sales/get-price', [RfqSalesController::class, 'getPrice'])->name('get-price');