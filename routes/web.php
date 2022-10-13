<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Finance\FinanceController;
use App\Http\Controllers\HeadProduction\HeadProductionController;
use App\Http\Controllers\Koordinator\ApprovalController;
use App\Http\Controllers\Koordinator\KoordinatorController;
use App\Http\Controllers\Koordinator\PDFViewController;
use App\Http\Controllers\Koordinator\PengajuanLemburController;
use App\Http\Controllers\Labour\LabourController;
use App\Http\Controllers\SuperAdmin\DivisionsController;
use App\Http\Controllers\SuperAdmin\EmployeeController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UsersController;
use App\Http\Controllers\Supervisor\SupervisorController;
use App\Http\Controllers\WorkerOfficer\AccountController;
use App\Http\Controllers\WorkerOfficer\AdminLabourController;
use App\Http\Controllers\WorkerOfficer\AdminWorkerOfficerController;
use App\Http\Controllers\WorkerOfficer\BagianController;
use App\Http\Controllers\WorkerOfficer\DataPengajuanController;
use App\Http\Controllers\WorkerOfficer\UangMakanController;
use App\Http\Controllers\WorkerOfficer\UploadSignature;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role_id == 1) {
            return redirect('/superadmin');
        } elseif (Auth::user()->role_id == 2) {
            return redirect('/supervisor');
        } elseif (Auth::user()->role_id == 3) {
            return redirect('/head-production');
        } elseif (Auth::user()->role_id == 4) {
            return redirect('/finance');
        } elseif (Auth::user()->role_id == 5) {
            return redirect('/admin-worker-officer');
        } elseif (Auth::user()->role_id == 6) {
            return redirect('/koordinator');
        } elseif (Auth::user()->role_id == 7) {
            return redirect('/labour');
        }
    } else {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/authlogin', 'authlogin')->name('authlogin');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['admin']], function () {
    Route::get('superadmin', [SuperAdminController::class, 'index'])->name('superadmin');
    Route::get('superadmin/users', [UsersController::class, 'index'])->name('superadmin.users');
    Route::post('superadmin/user/create', [UsersController::class, 'createUser'])->name('superadmin.users.create');
    Route::get('superadmin/user/{id}', [UsersController::class, 'editUser'])->name('superadmin.user.edit');
    Route::post('superadmin/user/update', [UsersController::class, 'updateUser'])->name('superadmin.user.update');
    Route::post('superadmin/user/delete', [UsersController::class, 'deleteUser'])->name('superadmin.user.delete');

    Route::get('superadmin/divisions', [DivisionsController::class, 'index'])->name('superadmin.divisions');
    Route::post('superadmin/division/create', [DivisionsController::class, 'createDivision'])->name('superadmin.division.crate');
    Route::post('superadmin/division/update', [DivisionsController::class, 'updateDivision'])->name('superadmin.division.update');
    Route::post('superadmin/division/delete', [DivisionsController::class, 'deleteDivision'])->name('superadmin.division.delete');

    Route::get('superadmin/employee', [EmployeeController::class, 'index'])->name('superadmin.employee');
    Route::get('superadmin/employee/check', [EmployeeController::class, 'checkEmployee'])->name('superadmin.employee.check');
    Route::get('superadmin/employee/getemployee', [EmployeeController::class, 'getEmployee'])->name('superadmin.employee.getemployee');
    Route::post('superadmin/employee/create', [EmployeeController::class, 'createEmployee'])->name('superadmin.employee.create');
    Route::post('superadmin/employee/update', [EmployeeController::class, 'updateEmployee'])->name('superadmin.employee.update');
    Route::post('superadmin/employee/delete', [EmployeeController::class, 'deleteEmployee'])->name('superadmin.employee.delete');
    Route::get('superadmin/employee/get-division', [EmployeeController::class, 'getDivision'])->name('superadmin.employee.get-division');
});

Route::group(['middleware' => ['supervisor']], function () {
    Route::get('supervisor', [SupervisorController::class, 'index'])->name('supervisor');
    Route::get('supervisor/data-pengajuan', [SupervisorController::class, 'showData'])->name('supervisor.data-pengajuan');

    Route::get('supervisor/detail-data/{id}', [SupervisorController::class, 'detail'])->name('supervisor.detail-data');
    Route::post('supervisor/approve', [SupervisorController::class, 'approved'])->name('supervisor.approve');
    Route::post('supervisor/reject', [SupervisorController::class, 'rejected'])->name('supervisor.reject');
    Route::get('supervisor/get-dashboard', [SupervisorController::class, 'getDashboard'])->name('supervisor.get-dashboard');
});

Route::group(['middleware' => ['headproduction']], function () {
    Route::get('head-production', [HeadProductionController::class, 'index'])->name('headproduction');
    Route::get('head-production/data-pengajuan', [HeadProductionController::class, 'showData'])->name('headproduction.data-pengajuan');
    Route::get('head-production/detail-data/{id}', [HeadProductionController::class, 'detail'])->name('headproduction.detail-data');
    Route::post('head-production/deail-data/approve', [HeadProductionController::class, 'approved'])->name('headproduction.approve');
    Route::post('head-production/deail-data/reject', [HeadProductionController::class, 'rejected'])->name('headproduction.reject');
    Route::get('head-production/get-dashboard', [HeadProductionController::class, 'getDashboard'])->name('headproduction.get-dashboard');
});

Route::group(['middleware' => ['finance']], function () {
    Route::get('finance', [FinanceController::class, 'index'])->name('finance');
    Route::get('finance/data-pengajuan', [FinanceController::class, 'showData'])->name('finance.data-pengajuan');
    Route::get('finance/get-dashboard', [FinanceController::class, 'getDashboard'])->name('finance.get-dashboard');
    Route::get('finance/export-excel', [FinanceController::class, 'export'])->name('finance.export-excel');
    Route::get('finance/export-one', [FinanceController::class, 'exportOne'])->name('finance.export-one');
    Route::get('finance/get-employee', [FinanceController::class, 'findEmployee'])->name('finance.find-employee');
});

Route::group(['middleware' => ['adminwo', 'cors']], function () {
    Route::get('admin-worker-officer', [AdminWorkerOfficerController::class, 'index'])->name('adminwo');

    Route::get('admin-worker-officer/data-labour', [AdminLabourController::class, 'index'])->name('adminwo.data-labour');
    Route::get('admin-worker-officer/create-labour', [AdminLabourController::class, 'create'])->name('adminwo.create-labour');
    Route::post('admin-worker-officer/create-labour-action', [AdminLabourController::class, 'createLabour'])->name('adminwo.create-labour-action');
    Route::get('admin-worker-officer/edit-labour/{id}', [AdminLabourController::class, 'show'])->name('adminwo.show-labour');
    Route::post('admin-worker-officer/update-labour/{id}', [AdminLabourController::class, 'update'])->name('adminwo.create-labour-action');
    Route::post('admin-worker-officer/delete-labour', [AdminLabourController::class, 'delete'])->name('adminwo.delete-labour');
    Route::get('admin-worker-officer/get-labour/{nik}/{nama}', [AdminLabourController::class, 'findEmployee'])->name('adminwo.get-labour');

    Route::get('admin-worker-officer/data-pengajuan', [DataPengajuanController::class, 'index'])->name('adminwo.data-pengajuan');
    Route::get('admin-worker-officer/get-dashboard', [AdminWorkerOfficerController::class, 'getDashboard'])->name('adminwo.get-dashboard');
    Route::get('admin-worker-officer/get-employee', [DataPengajuanController::class, 'findEmployee'])->name('adminwo.find-employee');

    Route::get('admin-worker-office/export-excel', [DataPengajuanController::class, 'export'])->name('adminwo.export');
    Route::get('admin-worker-office/export-one', [DataPengajuanController::class, 'exportOne'])->name('adminwo.export-one');

    Route::get('admin-worker-officer/uang-makan', [UangMakanController::class, 'index'])->name('adminwo.uang-makan');
    Route::post('admin-worker-officer/uang-makan/create', [UangMakanController::class, 'create'])->name('adminwo.uang-makan.create');
    Route::post('admin-worker-officer/uang-makan/edit', [UangMakanController::class, 'edit'])->name('adminwo.uang-makan.edit');
    Route::post('admin-worker-officer/uang-makan/delete', [UangMakanController::class, 'delete'])->name('adminwo.uang-makan.delete');

    Route::get('admin-worker-officer/upload-signature', [UploadSignature::class, 'index'])->name('adminwo.upload-signature');
    Route::post('admin-worker-officer/upload-signature/create', [UploadSignature::class, 'uploadSignature'])->name('adminwo.upload-signature.uploadSignature');
    Route::get('admin-worker-officer/delete-signature/{id}', [UploadSignature::class, 'deleteSignature'])->name('adminwo.upload-signature.deleteSignature');


    Route::get('admin-woker-officer/data-bagian', [BagianController::class, 'index'])->name('adminwo.data-bagian');
    Route::post('admin-worker-officer/data-bagian/create', [BagianController::class, 'store'])->name('adminwo.data-bagian.create');
    Route::post('admin-worker-officer/data-bagian/edit', [BagianController::class, 'update'])->name('adminwo.data-bagian.edit');
    Route::post('admin-worker-officer/data-bagian/delete', [BagianController::class, 'delete'])->name('adminwo.data-bagian.delete');

    Route::get('admin-worker-officer/data-akun', [AccountController::class, 'index'])->name('adminwo.data-akun');
    Route::get('admin-worker-officer/data-akun/find/{name}/{nik}', [AccountController::class, 'findEmployee'])->name('adminwo.data-akun.find');
    Route::post('admin-worker-officer/data-akun/create', [AccountController::class, 'store'])->name('adminwo.data-akun.create');
    Route::post('admin-worker-officer/data-akun/edit', [AccountController::class, 'edit'])->name('adminwo.data-akun.edit');
    Route::post('admin-worker-officer/data-akun/reset-password', [AccountController::class, 'resetPassword'])->name('adminwo.data-akun.resetpassword');
    Route::post('admin-worker-officer/data-akun/delete', [AccountController::class, 'delete'])->name('adminwo.data-akun.delete');
});

Route::group(['middleware' => ['koordinator']], function () {
    Route::get('koordinator', [KoordinatorController::class, 'index'])->name('koordinator');
    Route::get('koordinator/data-pengajuan', [PengajuanLemburController::class, 'index'])->name('koordinator.data-pengajuan');
    Route::get('koordinator/data-pengajuan/buat-pengajuan-lembur', [PengajuanLemburController::class, 'create'])->name('koordinator.buat-pengajuan-lembur');
    Route::post('koordinator/data-pengajuan/tambah-pengajuan', [PengajuanLemburController::class, 'store'])->name('koordinator.tambah-pengajuan');
    Route::get('koordinator/data-pengajuan/edit-pengajuan/{id}', [PengajuanLemburController::class, 'edit'])->name('koordinator.edit-pengajuan');
    Route::post('koordinator/data-pengajuan/update-pengajuan', [PengajuanLemburController::class, 'update'])->name('koordinator.update-pengajuan');
    Route::post('koordinator/data-pengajuan/delete-pengajuan', [PengajuanLemburController::class, 'delete'])->name('koordinator.delete-pengajuan');

    Route::get('koordinator/getEmployee', [PengajuanLemburController::class, 'findEmployee'])->name('koordinator.findEmployee');

    Route::get('koordinator/data-pengajuan/detail-pengajuan/{id}', [PengajuanLemburController::class, 'detailPengajuan'])->name('koordinator.detail-pengajuan');
    Route::get('koordinator/data-pengajuan/detail-pengajuan/{id}/edit-list/{detail_id}', [PengajuanLemburController::class, 'editListEmployee'])->name('koordinator.edit-list-employee');
    Route::post('koordinator/data-pengajuan/detail-pengajuan/update-list', [PengajuanLemburController::class, 'updateListEmployee'])->name('koordinator.update-list-employee');
    Route::post('koordinator/data-pengajuan/detail-pengajuan/add-list-employee', [PengajuanLemburController::class, 'addListEmployee'])->name('koordinator.add-list-employee');
    Route::post('koordinator/data-pengajuan/detail-pengajuan/delete-list-employee', [PengajuanLemburController::class, 'deleteListEmployee'])->name('koordinator.delete-list-employee');

    Route::get('koordinator/konfirmasi-pengajuan/{id}', [ApprovalController::class, 'index'])->name('koordinator.konfirmasi-pengajuan');
    Route::post('koordinator/konfirmasi-pengajuan/approve', [ApprovalController::class, 'confirm'])->name('koordinator.approve');
    Route::get('koordinator/get-dashboard', [KoordinatorController::class, 'getDashboard'])->name('koordinator.get-dashboard');

    Route::get('koodrinator/find-project/{code}', [PengajuanLemburController::class, 'findProject'])->name('koordinator.findProject');

    Route::get('koordinator/export/pdf/{id}', [PDFViewController::class, 'index'])->name('export.pdf');
    Route::get('koordinator/export/get-pdf/{id}', [PDFViewController::class, 'getPDF'])->name('export.get-pdf');
});

Route::group(['middleware' => ['labour']], function () {
    Route::get('labour', [LabourController::class, 'index'])->name('labour');
    Route::get('labour/get-dashboard', [LabourController::class, 'getDashboard'])->name('labour.get-dashboard');
});
