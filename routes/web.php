<?php

use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use Spatie\Permission\Contracts\Role;

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

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/get-subjects', [SubjectController::class, 'getSubjects'])->name('get-subjects');
    Route::get('/get-sections-by-class/{class_id}', [App\Http\Controllers\SystemFunctionController::class, 'getSectionsByClass']);

    Route::post('send-student-sms', [SmsController::class, 'sendStudentSms'])->name('sendStudentSms');

    // Route to display the form
    Route::get('/send-sms-form', [SmsController::class, 'index'])->name('send-sms-form');
    Route::get('/show-sms-history', [SmsController::class, 'ShowAllsms'])->name('show-sms-history');
    Route::post('/send-attendace-sms', [SmsController::class, 'SendAttendaceSms'])->name('SendAttendaceSms');
    Route::post('send-single-sms', [SmsController::class, 'SendSingleAttendaceSms'])->name('SendSingleAttendaceSms');
    Route::post('send-exam-sms', [SmsController::class, 'sendExamSms'])->name('sendExamSms');

    Route::group(['prefix' => 'admin/role', 'as' => 'role.'], function () {
        Route::get('/', [App\Http\Controllers\Role\RolePermissionController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\Role\RolePermissionController::class, 'create'])->name('create');
        Route::post('store', [App\Http\Controllers\Role\RolePermissionController::class, 'store'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\Role\RolePermissionController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\Role\RolePermissionController::class, 'update'])->name('update');
        Route::get('delete/{id}', [App\Http\Controllers\Role\RolePermissionController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::get('delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('delete');
    });

    Route::prefix('instructor')->group(function () {
        Route::get('/', [App\Http\Controllers\InstructorController::class, 'index'])->name('instructor.index');
        Route::get('view/{uuid}', [App\Http\Controllers\InstructorController::class, 'view'])->name('instructor.view');
        Route::get('edit/{uuid}', [App\Http\Controllers\InstructorController::class, 'edit'])->name('instructor.edit');
        Route::post('update/{uuid}', [App\Http\Controllers\InstructorController::class, 'update'])->name('instructor.update');
        Route::get('pending', [App\Http\Controllers\InstructorController::class, 'pending'])->name('instructor.pending');
        Route::get('approved', [App\Http\Controllers\InstructorController::class, 'approved'])->name('instructor.approved');
        Route::get('blocked', [App\Http\Controllers\InstructorController::class, 'blocked'])->name('instructor.blocked');
        Route::get('change-status/{uuid}/{status}', [App\Http\Controllers\InstructorController::class, 'changeStatus'])->name('instructor.status-change');
        Route::post('change-instructor-status', [App\Http\Controllers\InstructorController::class, 'changeInstructorStatus'])->name('admin.instructor.changeInstructorStatus');
        Route::get('delete/{uuid}', [App\Http\Controllers\InstructorController::class, 'delete'])->name('instructor.delete');

        Route::get('get-state-by-country/{country_id}', [App\Http\Controllers\InstructorController::class, 'getStateByCountry']);
        Route::get('get-city-by-state/{state_id}', [App\Http\Controllers\InstructorController::class, 'getCityByState']);

        Route::get('create', [App\Http\Controllers\InstructorController::class, 'create'])->name('instructor.create');
        Route::post('store', [App\Http\Controllers\InstructorController::class, 'store'])->name('instructor.store');
    });

    Route::prefix('student')->group(function () {
        Route::get('/', [StudentsController::class, 'index'])->name('student.index');
        Route::get('create', [StudentsController::class, 'create'])->name('student.create');
        Route::post('store', [StudentsController::class, 'store'])->name('student.store');
        //Route::get('view/{uuid}', [StudentsController::class, 'view'])->name('student.view');
        Route::match(['get', 'post'], 'view/{uuid}', [StudentsController::class, 'view'])->name('student.view');
        Route::get('edit/{uuid}', [StudentsController::class, 'edit'])->name('student.edit');
        Route::post('update/{uuid}', [StudentsController::class, 'update'])->name('student.update');
        Route::get('delete/{uuid}', [StudentsController::class, 'delete'])->name('student.delete');
        Route::post('change-student-status', [StudentsController::class, 'changeStudentStatus'])->name('admin.student.changeStudentStatus');
        Route::get('mark/{uuid}', [StudentsController::class, 'mark'])->name('admin.student.mark');
        // csv file upload
        Route::get('/student-csv-file-create', [StudentsController::class, 'student_csv_file_upload'])->name('student.csv.upload');
        Route::post('/student-csv-file-store', [StudentsController::class, 'student_csv_file_store'])->name('student.csv.store');
    });

    Route::group(['prefix' => 'class', 'as' => 'class.'], function () {
        Route::get('/', [App\Http\Controllers\SystemFunctionController::class, 'classIndex'])->name('index');
        Route::get('create', [App\Http\Controllers\SystemFunctionController::class, 'classCreate'])->name('create');
        Route::post('store', [App\Http\Controllers\SystemFunctionController::class, 'classStore'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\SystemFunctionController::class, 'classEdit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\SystemFunctionController::class, 'classUpdate'])->name('update');
        Route::get('delete/{id}', [App\Http\Controllers\SystemFunctionController::class, 'classDelete'])->name('delete');
    });

    Route::group(['prefix' => 'subject', 'as' => 'subject.'], function () {
        Route::get('/', [App\Http\Controllers\SystemFunctionController::class, 'subjectIndex'])->name('index');
        Route::get('create', [App\Http\Controllers\SystemFunctionController::class, 'subjectCreate'])->name('create');
        Route::post('store', [App\Http\Controllers\SystemFunctionController::class, 'subjectStore'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\SystemFunctionController::class, 'subjectEdit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\SystemFunctionController::class, 'subjectUpdate'])->name('update');
        Route::get('delete/{id}', [App\Http\Controllers\SystemFunctionController::class, 'subjectDelete'])->name('delete');
        // Route::get('assign', [App\Http\Controllers\SystemFunctionController::class, 'subjectAssign'])->name('assign');
    });

    Route::group(['prefix' => 'section', 'as' => 'section.'], function () {
        Route::get('/', [App\Http\Controllers\SystemFunctionController::class, 'sectionIndex'])->name('index');
        Route::get('create', [App\Http\Controllers\SystemFunctionController::class, 'sectionCreate'])->name('create');
        Route::post('store', [App\Http\Controllers\SystemFunctionController::class, 'sectionStore'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sectionEdit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sectionUpdate'])->name('update');
        Route::get('delete/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sectionDelete'])->name('delete');
    });

    Route::group(['prefix' => 'section', 'as' => 'section.'], function () {
        Route::get('/', [App\Http\Controllers\SystemFunctionController::class, 'sectionIndex'])->name('index');
        Route::get('create', [App\Http\Controllers\SystemFunctionController::class, 'sectionCreate'])->name('create');
        Route::post('store', [App\Http\Controllers\SystemFunctionController::class, 'sectionStore'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sectionEdit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sectionUpdate'])->name('update');
        Route::get('delete/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sectionDelete'])->name('delete');
    });

    Route::group(['prefix' => 'exam', 'as' => 'exam.'], function () {
        Route::get('/', [App\Http\Controllers\SystemFunctionController::class, 'examIndex'])->name('index');
        Route::get('create', [App\Http\Controllers\SystemFunctionController::class, 'examCreate'])->name('create');
        Route::post('store', [App\Http\Controllers\SystemFunctionController::class, 'examStore'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\SystemFunctionController::class, 'examEdit'])->name('edit');
        Route::get('view/{id}', [App\Http\Controllers\SystemFunctionController::class, 'viewEdit'])->name('view');
        Route::get('mark/{id}', [App\Http\Controllers\SystemFunctionController::class, 'mark'])->name('mark');
        Route::get('assign-delete/{id}/{eid}', [App\Http\Controllers\SystemFunctionController::class, 'assignDelete'])->name('assignDelete');
        Route::post('student-assign', [App\Http\Controllers\SystemFunctionController::class, 'studentSssign'])->name('assign');
        Route::post('student-given-mark', [App\Http\Controllers\SystemFunctionController::class, 'studentGivenMark'])->name('givenMark');
        Route::post('update/{id}', [App\Http\Controllers\SystemFunctionController::class, 'examUpdate'])->name('update');
        Route::get('delete/{id}', [App\Http\Controllers\SystemFunctionController::class, 'examDelete'])->name('delete');
        Route::post('send-sms/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sendMarkSMS'])->name('marksend');
    });

    Route::group(['prefix' => 'attendance', 'as' => 'attendance.'], function () {
        Route::get('/', [App\Http\Controllers\SystemFunctionController::class, 'attendanceIndex'])->name('index');
        Route::get('create', [App\Http\Controllers\SystemFunctionController::class, 'attendanceCreate'])->name('create');
        Route::get('show', [App\Http\Controllers\SystemFunctionController::class, 'attendanceShow'])->name('show');
        Route::post('store', [App\Http\Controllers\SystemFunctionController::class, 'attendanceStore'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\SystemFunctionController::class, 'attendanceEdit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\SystemFunctionController::class, 'attendanceUpdate'])->name('update');
        Route::post('edit-update/{id}', [App\Http\Controllers\SystemFunctionController::class, 'attendanceEditUpdate'])->name('edit_update');
        Route::get('delete/{id}', [App\Http\Controllers\SystemFunctionController::class, 'attendanceDelete'])->name('delete');
        Route::get('send-sms/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sendSMS'])->name('sms');
        Route::get('send-all-sms/{id}', [App\Http\Controllers\SystemFunctionController::class, 'sendAllSMS'])->name('all_sms');
    });

    Route::group(['prefix' => 'assgin', 'as' => 'assgin.'], function () {
        Route::get('/', [App\Http\Controllers\SystemFunctionController::class, 'assginIndex'])->name('index');
        Route::get('create', [App\Http\Controllers\SystemFunctionController::class, 'assginCreate'])->name('create');
        Route::post('store', [App\Http\Controllers\SystemFunctionController::class, 'assginStore'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\SystemFunctionController::class, 'assginEdit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\SystemFunctionController::class, 'assginUpdate'])->name('update');
        Route::get('delete/{id}', [App\Http\Controllers\SystemFunctionController::class, 'assginDelete'])->name('delete');
    });

});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/table', function () {
    return view('pages.common.table');
});

Route::get('/form01', function () {
    return view('pages.common.form01');
});

Route::get('/form02', function () {
    return view('pages.common.form02');
});

Auth::routes();

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('user-logout');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
