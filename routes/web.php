<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PreventBackHistory;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DispatchMaterialController;
use App\Http\Controllers\InfrastructureController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RequestMaterialController;
use App\Http\Controllers\AuditTaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AuditReportController;
use App\Http\Controllers\ReturnMaterialController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\InventoryTrailController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Http\Request;

Route::redirect('/', 'login');

Route::get('/two-factor-challenge', [TwoFactorController::class, 'create'])->name('two-factor.challenge');
Route::post('/two-factor-challenge', [TwoFactorController::class, 'store']);

//? START: PAGES ROUTES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::middleware(["auth", "verified", PreventBackHistory::class])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/category', fn() => Inertia::render('Category'))->name('category');
    Route::get('/user', fn() => Inertia::render('User'))->name('user');
    Route::get('/insight', fn() => Inertia::render('Insight'))->name('insight');
    Route::get('/product', fn() => Inertia::render('Product'))->name('product');
    Route::get('/receipt', fn() => Inertia::render('Receipt'))->name('receipt');
    Route::get('/receipt/history', fn() => Inertia::render('Receipt.History'))->name('receipt-history');
    Route::get('/dispatch', fn() => Inertia::render('Dispatch'))->name('dispatch');
    Route::get('/dispatch/history', fn() => Inertia::render('Dispatch.History'))->name('dispatch-history');
    Route::get('/warehouse', fn() => Inertia::render('Warehouse'))->name('warehouse');
    Route::get('/depot', fn() => Inertia::render('Depot'))->name('depot');
    Route::get('/depot/history', fn() => Inertia::render('Depot.History'))->name('depot-history');
    Route::get('/terminal', fn() => Inertia::render('Terminal'))->name('terminal');
    Route::get('/terminal/history', fn() => Inertia::render('Terminal.History'))->name('terminal-history');
    Route::get('/tasks', action: fn() => Inertia::render('Tasks'))->name('tasks');
    Route::get('/tasks/history', action: fn() => Inertia::render('Tasks.History'))->name('tasks-history');
    Route::get('/reports', fn() => Inertia::render('Reports'))->name('reports');
    Route::get('/reports/history', action: fn() => Inertia::render('Reports.History'))->name('reports-history');
    Route::get('/assignments', fn() => Inertia::render('Assignments'))->name('assignments');
    Route::get('/assignments/history', action: fn() => Inertia::render('Assignments.History'))->name('assignments-history');
    Route::get('/module', fn() => Inertia::render('Module'))->name('module');
    Route::get('/infrastructure', fn() => Inertia::render('Infrastructure'))->name('infrastructure');
    Route::get('/record', fn() => Inertia::render('Record'))->name('record');

    Route::get('/infrastructure/view', function (Request $request) {
        return Inertia::render('Infrastructure.View', [
            'id' => $request->query('id'),
        ]);
    })->name('infrastructure-view');

    Route::get('/assignments/view', function (Request $request) {
        return Inertia::render('Assignments.View', [
            'id' => $request->query('id'),
        ]);
    })->name('assignments-view');

    Route::get('/reports/view', function (Request $request) {
        return Inertia::render('Reports.View', [
            'id' => $request->query('id'),
        ]);
    })->name('reports-view');

    Route::get('/product/view', function (Request $request) {
        return Inertia::render('Product.View', [
            'id' => $request->query('id'),
        ]);
    })->name('product-view');

    Route::get('/return', fn() => Inertia::render('Return'))->name('return');
    Route::get('/return/history', fn() => Inertia::render('Return.History'))->name('return-history');

    Route::get('/logs', fn() => Inertia::render('Logs'))->name('logs');
});

//! END: PAGES ROUTES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// REQUEST ROUTES
Route::middleware(["auth", "verified"])->group(function () {

    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);

        return ['token' => $token->plainTextToken];
    });


    //? START: PRODUCT REQUEST /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('/product/get', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/get/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::patch('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/products/category', [ProductController::class, 'productEachCategory']);
    Route::get('/products/supplier', [ProductController::class, 'productEachSupplier']);
    Route::get('/products/recent/{limit?}', [ProductController::class, 'recentProducts']);
    Route::get('/products/most/{limit?}', [ProductController::class, 'mostExpensiveProducts']);
    Route::get('/products/least/{limit?}', [ProductController::class, 'leastExpensiveProducts']);

    Route::get('/product/stats', [ProductController::class, 'stats'])->name('product.stats');

    //! END: PRODUCT REQUEST ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('/supplier/get', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/category/get', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::patch('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/get/count', [CategoryController::class, 'indexWithProductCount'])->name('category.indexWithProductCount');

    Route::get('/position', [PositionController::class, 'index'])->name('position.index');
    Route::get('/position/get/{id}', [PositionController::class, 'show'])->name('position.show');
    Route::post('/position/create', [PositionController::class, 'store'])->name('position.store');
    Route::delete('/position/delete/{id}', [PositionController::class, 'destroy'])->name('position.destroy');
    Route::patch('/position/update/{id}', [PositionController::class, 'update'])->name('position.update');
    Route::patch('/position/update/permission/{id}', [PositionController::class, 'updatePermission'])->name('position.updatePermission');

    Route::get('/user/get', [UserController::class, 'index'])->name('user.index');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
    Route::patch('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/get/auditor/auto', [UserController::class, 'autoAssignAuditor'])->name('user.autoAssignAuditor');

    Route::get('/inventory/get', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/get/{id}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::post('/inventory/create', [InventoryController::class, 'store'])->name('inventory.store');
    Route::patch('/inventory/update/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/delete/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/inventory/get/warehouse/group', [InventoryController::class, 'indexGrouped'])->name('inventory.indexGrouped');
    Route::get('/inventory/get/warehouse/{id}', [InventoryController::class, 'indexByWarehouse'])->name('inventory.indexByWarehouse');
    Route::patch('/inventory/stock/update/{id}', [InventoryController::class, 'updateInDispatch'])->name('inventory.updateInDispatch');
    Route::post('/inventory/create/bulk', [InventoryController::class, 'storeBulk'])->name('inventory.storeBulk');

    Route::get('/receipt/get', [ReceiptController::class, 'index'])->name('receipt.index');
    Route::get('/receipt/get/{id}', [ReceiptController::class, 'show'])->name('receipt.show');
    Route::post('/receipt/create', [ReceiptController::class, 'store'])->name('receipt.store');
    Route::patch('/receipt/update/{id}', [ReceiptController::class, 'update'])->name('receipt.update');
    Route::delete('/receipt/delete/{id}', [ReceiptController::class, 'destroy'])->name('receipt.destroy');

    Route::get('/infrastructure/get', [InfrastructureController::class, 'index'])->name('infrastructure.index');
    Route::get('/infrastructure/get/{id}', [InfrastructureController::class, 'show'])->name('infrastructure.show');
    Route::post('/infrastructure/create', [InfrastructureController::class, 'store'])->name('infrastructure.store');
    Route::patch('/infrastructure/update/{id}', [InfrastructureController::class, 'update'])->name('infrastructure.update');
    Route::delete('/infrastructure/delete/{id}', [InfrastructureController::class, 'destroy'])->name('infrastructure.destroy');
    Route::get('/infrastructures/get/access', [InfrastructureController::class, 'indexByAccess']);

    Route::get('/request/get', [RequestMaterialController::class, 'index'])->name('request.index');
    Route::get('/request/get/{id}', [RequestMaterialController::class, 'show'])->name('request.show');
    Route::get('/request/get/infrastructure/depot', [RequestMaterialController::class, 'indexDepot'])->name('request.indexDepot');
    Route::get('/request/get/infrastructure/terminal', [RequestMaterialController::class, 'indexTerminal'])->name('request.indexTerminal');
    Route::post('/request/create', [RequestMaterialController::class, 'store'])->name('request.store');
    Route::patch('/request/update/{id}', [RequestMaterialController::class, 'update'])->name('request.update');
    Route::delete('/request/delete/{id}', [RequestMaterialController::class, 'destroy'])->name('request.destroy');

    Route::get('/dispatch/get', [DispatchMaterialController::class, 'index'])->name('dispatch.index');
    Route::get('/dispatch/get/{id}', [DispatchMaterialController::class, 'show'])->name('dispatch.show');
    Route::post('/dispatch/create', [DispatchMaterialController::class, 'store'])->name('dispatch.store');
    Route::patch('/dispatch/update/{id}', [DispatchMaterialController::class, 'update'])->name('dispatch.update');

    Route::post('/dispatch/trail/create/{id}', [DispatchMaterialController::class, 'createDispatchTrail'])->name('dispatch.createDispatchTrail');

    // Route for all dispatch trails
    Route::get('/dispatch/trails/get', [DispatchMaterialController::class, 'getAllDispatches'])->name('dispatch.getAllDispatches');

    // Route for dispatch trails by product ID
    Route::get('/dispatch/trails/get/product/{productId}', [DispatchMaterialController::class, 'getDispatchByProduct']);

    // Route for quantities by product ID
    Route::get('/dispatch/trails/get/product/{productId}/quantities', [DispatchMaterialController::class, 'getQuantitiesByProduct']);

    // Route for quantities by product ID and days range
    Route::get('/dispatch/trails/get/product/{productId}/quantities/days/{days}', [DispatchMaterialController::class, 'getQuantitiesByProductAndDays']);

    Route::get('/audit/task/get', [AuditTaskController::class, 'index'])->name('auditTask.index');
    Route::get('/audit/task/get/{id}', [AuditTaskController::class, 'show'])->name('auditTask.show');
    Route::get('/audit/user/task/get/{id}', [AuditTaskController::class, 'indexByUser'])->name('auditTask.indexByUser');
    Route::post('/audit/task/create', [AuditTaskController::class, 'store'])->name('auditTask.store');
    Route::patch('/audit/task/update/{id}', [AuditTaskController::class, 'update'])->name('auditTask.update');
    Route::delete('/audit/task/delete/{id}', [AuditTaskController::class, 'destroy'])->name('auditTask.destroy');

    Route::get('/audit/report/get', [AuditReportController::class, 'index'])->name('auditReport.index');
    Route::get('/audit/report/get/{id}', [AuditReportController::class, 'show'])->name('auditReport.show');
    Route::get('/audit/report/get/by/task/{id}', [AuditReportController::class, 'showByTask'])->name('auditReport.showByTask');
    //Route::get('/audit/user/report/get/{id}', [AuditReportController::class, 'showUserTasks'])->name('auditReport.showUserTasks');
    Route::post('/audit/report/create', [AuditReportController::class, 'store'])->name('auditReport.store');
    Route::patch('/audit/report/update/{id}', [AuditReportController::class, 'update'])->name('auditReport.update');
    Route::delete('/audit/report/delete/{id}', [AuditReportController::class, 'destroy'])->name('auditReport.destroy');

    Route::get('/return/request/get', [ReturnRequestController::class, 'index'])->name('returnRequest.index');
    Route::get('/return/request/get/{id}', [ReturnRequestController::class, 'show'])->name('returnRequest.show');
    Route::post('/return/request/create', [ReturnRequestController::class, 'store'])->name('returnRequest.store');
    Route::patch('/return/request/update/{id}', [ReturnRequestController::class, 'update'])->name('returnRequest.update');
    Route::delete('/return/request/delete/{id}', [ReturnRequestController::class, 'destroy'])->name('returnRequest.destroy');

    Route::get('/return/get', [ReturnMaterialController::class, 'index'])->name('return.index');
    Route::get('/return/get/{id}', [ReturnMaterialController::class, 'show'])->name('return.show');
    Route::post('/return/create', [ReturnMaterialController::class, 'store'])->name('return.store');
    Route::patch('/return/update/{id}', [ReturnMaterialController::class, 'update'])->name('return.update');
    Route::delete('/return/delete/{id}', [ReturnMaterialController::class, 'destroy'])->name('return.destroy');
    Route::post('/return/create/bulk', [ReturnMaterialController::class, 'storeBulk'])->name('return.storeBulk');

    Route::get('/file/get', [FileController::class, 'index']);
    Route::get('/file/get/{id}', [FileController::class, 'show']);
    Route::post('file/store', [FileController::class, 'store']);
    Route::delete('/file/delete/{id}', [FileController::class, 'destroy']);

    Route::get('/inventory/total/stock', [InventoryController::class, 'totalStock']);
    Route::get('/inventory/out/stock/{limit?}', [InventoryController::class, 'outOfStockProducts']);
    Route::get('/inventory/low/stock/{limit?}', [InventoryController::class, 'lowStockProducts']);
    Route::get('/inventory/out/count', [InventoryController::class, 'outOfStockProductsCount']);
    Route::get('/inventory/low/count', [InventoryController::class, 'lowStockProductsCount']);
    Route::get('/inventory/total/value', [InventoryController::class, 'totalStockValue']);

    Route::get('/average/inventory/{productId}/{days}', [InventoryTrailController::class, 'averageInventory']);
    Route::get('/beginning/inventory/{productId}/{days}', [InventoryTrailController::class, 'getBeginningInventory']);
    Route::get('/purchases/{productId}/{days}', [InventoryTrailController::class, 'getPurchases']);
    Route::get('/ending/inventory/{productId}', [InventoryTrailController::class, 'getEndingInventory']);
    Route::get('/cogs/{productId}/{days}', [InventoryTrailController::class, 'calculateCOGS']);
    Route::get('/inventory/turnover/{productId}/{days}', [InventoryTrailController::class, 'inventoryTurnover']);
    Route::get('/inventory/critical/{productId}', [InventoryTrailController::class, 'getCriticalLevel']);
    Route::get('/inventory/reorder/{productId}', [InventoryTrailController::class, 'getReorderPoint']);
    Route::get('/inventory/stock/{period}/{year?}', [InventoryController::class, 'getStockDataByPeriod'])->where(['period' => 'month|quarter|year', 'year' => '[0-9]{4}']);
    Route::get('/inventory/top/products/{category_id}/{top?}', [InventoryController::class, 'getTopProductsByCategory']);
    Route::get('/inventory/years', [InventoryController::class, 'getAvailableYears']);
    
    Route::get('/audit/get/{model}', [AuditLogController::class, 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
