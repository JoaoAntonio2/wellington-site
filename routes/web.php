<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExpenseTypesController;
use App\Http\Controllers\UniformSimulatorController;

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

Route::post('/set-cookie', [CookieController::class, 'setCookie']);
Route::delete('/set-cookie', [CookieController::class, 'deleteCookie']);

Route::name('auth.')->group(function() {
	Route::get('/entrar', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
	Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function() {
	Route::get('/sair', [LoginController::class, 'logout'])->name('auth.logout');

	Route::name('users.')->group(function() {
		Route::middleware('role:gerencia')->group(function() {
			Route::get('/usuarios', [UsersController::class, 'index'])->name('index');
			Route::post('/usuarios', [UsersController::class, 'store'])->name('store');
			Route::post('/usuarios/{user}/change-role', [UsersController::class, 'changeRole'])->name('changeRole');
			Route::get('/usuarios/{user}/get-change-role-form', [UsersController::class, 'getChangeRoleForm']);
			Route::delete('/usuarios/{user}/deletar', [UsersController::class, 'destroy'])->name('destroy');
		});

		Route::delete('/minha-conta/deletar', [UsersController::class, 'destroyOwnAccount'])->name('destroyOwnAccount');
		Route::get('/minha-conta', [UsersController::class, 'myAccount'])->name('my-account');
		Route::patch('/minha-conta', [UsersController::class, 'patch'])->name('patch');
	});

	Route::name('clients.')->group(function() {
		Route::get('/', [ClientsController::class, 'index'])->name('index');
		Route::get('/cliente/{client}', [ClientsController::class, 'show'])->name('show');
		Route::middleware('role:gerencia,atendimento')->group(function() {
			Route::post('/novo-cliente', [ClientsController::class, 'store'])->name('store');
			Route::patch('/cliente/{client}', [ClientsController::class, 'patch'])->name('patch');
			Route::delete('/cliente/{client}', [ClientsController::class, 'destroy'])->name('destroy');
		});
	});

	Route::name('orders.')->group(function() {
		Route::get('/cliente/{client}/pedido/{order}/pdf-pedido', [OrdersController::class, 'generateOrderPDF'])->name('order-pdf');
		Route::get('/cliente/{client}/pedido/{order}', [OrdersController::class, 'show'])->name('show');
		Route::post('/cliente/{client}/pedido/{order}/file-view', [OrdersController::class, 'showFile'])->name('showFile');

		Route::middleware('role:gerencia,atendimento')->group(function() {
			Route::get('/pedidos', [OrdersController::class, 'index'])->name('index');
			Route::get('/pedidos/relatorio-data-producao', [OrdersController::class, 'generateReportProductionDate'])->name('reportProductionDate');
			Route::get('/pedidos/relatorio', [OrdersController::class, 'generateReport'])->name('report');
			Route::get('/cliente/{client}/novo-pedido', [OrdersController::class, 'create'])->name('create');
			Route::post('/cliente/{client}/novo-pedido', [OrdersController::class, 'store'])->name('store');
			Route::get('/cliente/{client}/pedido/{order}/editar', [OrdersController::class, 'edit'])->name('edit');
			Route::patch('/cliente/{client}/pedido/{order}/editar', [OrdersController::class, 'patch'])->name('patch');
			Route::post('/cliente/{client}/pedido/{order}/toggle-order', [OrdersController::class, 'toggleOrder'])->name('toggleOrder');
			Route::delete('/cliente/{client}/pedido/{order}/deletar', [OrdersController::class, 'destroy'])->name('destroy');
			Route::post('/cliente/{client}/pedido/{order}/editar/delete-file', [OrdersController::class, 'deleteFile']);
		});
	});

	Route::name('expenses.')->middleware('role:gerencia,atendimento')->group(function() {
		Route::get('/despesas', [ExpensesController::class, 'index'])->name('index');
		Route::get('/despesas/cadastro', [ExpensesController::class, 'create'])->name('create');
		Route::get('/despesas/cadastro/get-inline-form', [ExpensesController::class, 'getInlineForm']);
		Route::post('/despesas/cadastro', [ExpensesController::class, 'store'])->name('store');
		Route::get('/despesas/{expense}/get-edit-form', [ExpensesController::class, 'getEditForm']);
		Route::patch('/despesas/{expense}', [ExpensesController::class, 'patch'])->name('patch');
		Route::get('/despesas/{expense}/get-view-receipt', [ExpensesController::class, 'getViewReceipt']);

		Route::middleware('role:gerencia')->group(function() {
			Route::get('/despesas/relatorio', [ExpensesController::class, 'report'])->name('report');
			Route::delete('/despesas/{expense}/deletar', [ExpensesController::class, 'destroy'])->name('destroy');
			Route::delete('/despesas/{expense}/delete-receipt', [ExpensesController::class, 'destroyReceipt']);
		});
	});

	Route::name('cash-flow.')->middleware('role:gerencia')->group(function() {
		Route::get('/fluxo-de-caixa', [CashFlowController::class, 'index'])->name('index');
		Route::get('/fluxo-de-caixa/get-details', [CashFlowController::class, 'getDetails']);
	});

	Route::name('expense_types.')->middleware('role:gerencia')->group(function() {
		Route::post('/despesas/tipo-de-despesa', [ExpenseTypesController::class, 'store'])->name('store');
		Route::patch('/despesas/tipo-de-despesa/{expense_type}', [ExpenseTypesController::class, 'patch'])->name('patch');
	});

	Route::name('payments.')->middleware('role:gerencia,atendimento')->group(function() {
		Route::post('/cliente/{client}/pedido/{order}/new-payment', [PaymentsController::class, 'store'])->name('store');
		Route::get('/cliente/{client}/pedido/{order}/pagamento/{payment}/get-change-payment-view', [PaymentsController::class, 'getChangePaymentView']);
		Route::post('/cliente/{client}/pedido/{order}/pagamento/{payment}', [PaymentsController::class, 'patch']);
	});

	Route::name('notes.')->group(function() {
		Route::post('/cliente/{client}/pedido/{order}/new-note', [NotesController::class, 'store'])->name('store');
		Route::delete('/cliente/{client}/pedido/{order}/delete-note/{note}', [NotesController::class, 'destroy']);
	});

	Route::name('status.')->group(function() {
		Route::post('/cliente/{client}/pedido/{order}/alterar-status', [StatusController::class, 'patch'])->name('patch');
	});

	Route::name('financial.')->middleware('role:gerencia')->group(function() {
		Route::get('/financeiro', [FinancialController::class, 'index'])->name('index');
	});

	Route::name('activities.')->middleware('role:gerencia')->group(function() {
		Route::get('/atividades', [ActivitiesController::class, 'index'])->name('index');
	});
	
	Route::name('uniform-simulator')->group(function() {
		Route::get('/simulador-de-uniforme', [UniformSimulatorController::class, 'index'])->name('index');
	});
});
