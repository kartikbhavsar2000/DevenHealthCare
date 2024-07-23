<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login')->middleware('login');
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Auth::routes(['register' => false]);

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return 'Cache cleared';
});
Route::get('/clear-route', function () {
    $exitCode = Artisan::call('route:clear');
    return 'Route cleared';
});

Route::get('/clear-config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Configuration cache cleared';
});

Route::group(['middleware' => ['admin']], function() {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/dhc_dashboard', [App\Http\Controllers\HomeController::class, 'dhc_dashboard'])->name('dhc_dashboard');
    Route::get('/hsp_dashboard', [App\Http\Controllers\HomeController::class, 'hsp_dashboard'])->name('hsp_dashboard');
    Route::get('/crp_dashboard', [App\Http\Controllers\HomeController::class, 'crp_dashboard'])->name('crp_dashboard');
    Route::post('/change_customer_type', [App\Http\Controllers\HomeController::class, 'change_customer_type'])->name('change_customer_type');
    Route::post('/mark_attandance', [App\Http\Controllers\HomeController::class, 'mark_attandance'])->name('mark_attandance');

    Route::get('/analytics', [App\Http\Controllers\HomeController::class, 'analytics'])->name('analytics');

    Route::get('/get_staff_booking_chart_data', [App\Http\Controllers\HomeController::class, 'get_staff_booking_chart_data'])->name('get_staff_booking_chart_data');
    Route::get('/get_income_expense_chart_data', [App\Http\Controllers\HomeController::class, 'get_income_expense_chart_data'])->name('get_income_expense_chart_data');
    Route::get('/get_profit_loss_chart_data', [App\Http\Controllers\HomeController::class, 'get_profit_loss_chart_data'])->name('get_profit_loss_chart_data');
    Route::get('/area_wise_booking_chart', [App\Http\Controllers\HomeController::class, 'area_wise_booking_chart'])->name('area_wise_booking_chart');
    Route::get('/area_wise_patient_and_staff_chart', [App\Http\Controllers\HomeController::class, 'area_wise_patient_and_staff_chart'])->name('area_wise_patient_and_staff_chart');
    Route::get('/available_and_occupied_staff', [App\Http\Controllers\HomeController::class, 'available_and_occupied_staff'])->name('available_and_occupied_staff');
    Route::get('/patient_vs_corporation_chart', [App\Http\Controllers\HomeController::class, 'patient_vs_corporation_chart'])->name('patient_vs_corporation_chart');

    Route::post('/get_cities_by_state', [App\Http\Controllers\HomeController::class, 'get_cities_by_state'])->name('get_cities_by_state');
    Route::post('/get_areas_by_city', [App\Http\Controllers\HomeController::class, 'get_areas_by_city'])->name('get_areas_by_city');

    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'bookings'])->name('bookings');
    Route::get('/get_bookings_list', [App\Http\Controllers\BookingController::class, 'get_bookings_list'])->name('get_bookings_list');
    Route::get('/add_booking', [App\Http\Controllers\BookingController::class, 'add_booking'])->name('add_booking');
    Route::get('/view_booking_details/{id}', [App\Http\Controllers\BookingController::class, 'view_booking_details'])->name('view_booking_details');
    Route::get('/view_booking_assign_details/{id}', [App\Http\Controllers\BookingController::class, 'view_booking_assign_details'])->name('view_booking_assign_details');
    Route::get('/get_booking_assign_details', [App\Http\Controllers\BookingController::class, 'get_booking_assign_details'])->name('get_booking_assign_details');
    Route::post('/create_booking', [App\Http\Controllers\BookingController::class, 'create_booking'])->name('create_booking');

    Route::get('/closed_bookings', [App\Http\Controllers\BookingController::class, 'closed_bookings'])->name('closed_bookings');
    Route::get('/get_closed_bookings_list', [App\Http\Controllers\BookingController::class, 'get_closed_bookings_list'])->name('get_closed_bookings_list');

    Route::get('/invoice/{id}', [App\Http\Controllers\BookingController::class, 'invoice'])->name('invoice');
    Route::get('/print/{id}', [App\Http\Controllers\BookingController::class, 'print'])->name('print');
    Route::get('/download/{id}', [App\Http\Controllers\BookingController::class, 'download'])->name('download');

    Route::get('/assign_bookings', [App\Http\Controllers\BookingController::class, 'assign_bookings'])->name('assign_bookings');
    Route::get('/get_assign_bookings_list', [App\Http\Controllers\BookingController::class, 'get_assign_bookings_list'])->name('get_assign_bookings_list');
    Route::get('/assign_booking/{id}', [App\Http\Controllers\BookingController::class, 'assign_booking'])->name('assign_booking');
    Route::get('/cancel_booking_staff/{id}', [App\Http\Controllers\BookingController::class, 'cancel_booking_staff'])->name('cancel_booking_staff');
    Route::post('/cancel_staff/{id}', [App\Http\Controllers\BookingController::class, 'cancel_staff'])->name('cancel_staff');
    Route::post('/store_assign_booking/{id}', [App\Http\Controllers\BookingController::class, 'store_assign_booking'])->name('store_assign_booking');
    Route::post('/assign_single_staff', [App\Http\Controllers\BookingController::class, 'assign_single_staff'])->name('assign_single_staff');
    Route::post('/assign_single_doctor', [App\Http\Controllers\BookingController::class, 'assign_single_doctor'])->name('assign_single_doctor');
    Route::post('/add_assign_single_staff', [App\Http\Controllers\BookingController::class, 'add_assign_single_staff'])->name('add_assign_single_staff');
    Route::post('/add_assign_single_doctor', [App\Http\Controllers\BookingController::class, 'add_assign_single_doctor'])->name('add_assign_single_doctor');
    Route::post('/add_single_equipment', [App\Http\Controllers\BookingController::class, 'add_single_equipment'])->name('add_single_equipment');
    Route::post('/add_single_ambulance', [App\Http\Controllers\BookingController::class, 'add_single_ambulance'])->name('add_single_ambulance');
    Route::post('/check_staff_availability', [App\Http\Controllers\BookingController::class, 'check_staff_availability'])->name('check_staff_availability');
    Route::post('/check_doctor_availability', [App\Http\Controllers\BookingController::class, 'check_doctor_availability'])->name('check_doctor_availability');
    Route::post('/pause_booking', [App\Http\Controllers\BookingController::class, 'pause_booking'])->name('pause_booking');

    Route::get('/staff_attendance', [App\Http\Controllers\BookingController::class, 'staff_attendance'])->name('staff_attendance');
    Route::get('/get_staff_attendance_list', [App\Http\Controllers\BookingController::class, 'get_staff_attendance_list'])->name('get_staff_attendance_list');
    Route::post('/approve_reject_staff_attendance', [App\Http\Controllers\BookingController::class, 'approve_reject_staff_attendance'])->name('approve_reject_staff_attendance');
    Route::post('/make_attandance_pending', [App\Http\Controllers\BookingController::class, 'make_attandance_pending'])->name('make_attandance_pending');

    Route::get('/booking_reviews', [App\Http\Controllers\BookingController::class, 'booking_reviews'])->name('booking_reviews');
    Route::get('/get_booking_reviews_list', [App\Http\Controllers\BookingController::class, 'get_booking_reviews_list'])->name('get_booking_reviews_list');
    Route::get('/get_staff_reviews_list/{id}', [App\Http\Controllers\BookingController::class, 'get_staff_reviews_list'])->name('get_staff_reviews_list');
    Route::get('/add_booking_reviews/{id}', [App\Http\Controllers\BookingController::class, 'add_booking_reviews'])->name('add_booking_reviews');
    Route::post('/create_booking_reviews', [App\Http\Controllers\BookingController::class, 'create_booking_reviews'])->name('create_booking_reviews');

    Route::get('/active_invoice', [App\Http\Controllers\InvoiceController::class, 'active_invoice'])->name('active_invoice');
    Route::get('/get_active_invoice_list', [App\Http\Controllers\InvoiceController::class, 'get_active_invoice_list'])->name('get_active_invoice_list');
    Route::get('/generate_invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'generate_invoice'])->name('generate_invoice');
    Route::post('/close_booking', [App\Http\Controllers\InvoiceController::class, 'close_booking'])->name('close_booking');
    Route::post('/invoice_details_by_dates', [App\Http\Controllers\InvoiceController::class, 'invoice_details_by_dates'])->name('invoice_details_by_dates');
    Route::post('/add_booking_payment', [App\Http\Controllers\InvoiceController::class, 'add_booking_payment'])->name('add_booking_payment');
    Route::post('/send_invoice_in_mail', [App\Http\Controllers\InvoiceController::class, 'send_invoice_in_mail'])->name('send_invoice_in_mail');

    Route::get('/closed_invoice', [App\Http\Controllers\InvoiceController::class, 'closed_invoice'])->name('closed_invoice');
    Route::get('/get_closed_invoice_list', [App\Http\Controllers\InvoiceController::class, 'get_closed_invoice_list'])->name('get_closed_invoice_list');

    Route::get('/roles', [App\Http\Controllers\UserController::class, 'roles'])->name('roles');
    Route::get('/get_roles_list', [App\Http\Controllers\UserController::class, 'get_roles_list'])->name('get_roles_list');
    Route::get('/add_role', [App\Http\Controllers\UserController::class, 'add_role'])->name('add_role');
    Route::get('/edit_role/{id}', [App\Http\Controllers\UserController::class, 'edit_role'])->name('edit_role');
    Route::post('/delete_role', [App\Http\Controllers\UserController::class, 'delete_role'])->name('delete_role');
    Route::post('/create_role', [App\Http\Controllers\UserController::class, 'create_role'])->name('create_role');
    Route::post('/update_role', [App\Http\Controllers\UserController::class, 'update_role'])->name('update_role');

    Route::get('/users', [App\Http\Controllers\UserController::class, 'users'])->name('users');
    Route::get('/get_users_list', [App\Http\Controllers\UserController::class, 'get_users_list'])->name('get_users_list');
    Route::get('/add_user', [App\Http\Controllers\UserController::class, 'add_user'])->name('add_user');
    Route::get('/edit_user/{id}', [App\Http\Controllers\UserController::class, 'edit_user'])->name('edit_user');
    Route::post('/delete_user', [App\Http\Controllers\UserController::class, 'delete_user'])->name('delete_user');
    Route::post('/create_user', [App\Http\Controllers\UserController::class, 'create_user'])->name('create_user');
    Route::post('/update_user', [App\Http\Controllers\UserController::class, 'update_user'])->name('update_user');

    Route::get('/hospitals', [App\Http\Controllers\MasterController::class, 'hospitals'])->name('hospitals');
    Route::get('/get_hospitals_list', [App\Http\Controllers\MasterController::class, 'get_hospitals_list'])->name('get_hospitals_list');
    Route::get('/add_hospital', [App\Http\Controllers\MasterController::class, 'add_hospital'])->name('add_hospital');
    Route::get('/edit_hospital/{id}', [App\Http\Controllers\MasterController::class, 'edit_hospital'])->name('edit_hospital');
    Route::post('/delete_hospital', [App\Http\Controllers\MasterController::class, 'delete_hospital'])->name('delete_hospital');
    Route::post('/create_hospital', [App\Http\Controllers\MasterController::class, 'create_hospital'])->name('create_hospital');
    Route::post('/update_hospital', [App\Http\Controllers\MasterController::class, 'update_hospital'])->name('update_hospital');

    Route::get('/shifts', [App\Http\Controllers\MasterController::class, 'shifts'])->name('shifts');
    Route::get('/get_shifts', [App\Http\Controllers\MasterController::class, 'get_shifts'])->name('get_shifts');
    Route::get('/edit_shift/{id}', [App\Http\Controllers\MasterController::class, 'edit_shift'])->name('edit_shift');
    Route::post('/update_shift', [App\Http\Controllers\MasterController::class, 'update_shift'])->name('update_shift');

    Route::get('/equipments', [App\Http\Controllers\MasterController::class, 'equipments'])->name('equipments');
    Route::get('/get_equipments_list', [App\Http\Controllers\MasterController::class, 'get_equipments_list'])->name('get_equipments_list');
    Route::get('/add_equipment', [App\Http\Controllers\MasterController::class, 'add_equipment'])->name('add_equipment');
    Route::get('/edit_equipment/{id}', [App\Http\Controllers\MasterController::class, 'edit_equipment'])->name('edit_equipment');
    Route::post('/delete_equipment', [App\Http\Controllers\MasterController::class, 'delete_equipment'])->name('delete_equipment');
    Route::post('/create_equipment', [App\Http\Controllers\MasterController::class, 'create_equipment'])->name('create_equipment');
    Route::post('/update_equipment', [App\Http\Controllers\MasterController::class, 'update_equipment'])->name('update_equipment');
    Route::post('/change_equipment_status', [App\Http\Controllers\MasterController::class, 'change_equipment_status'])->name('change_equipment_status');

    Route::get('/ambulance', [App\Http\Controllers\MasterController::class, 'ambulance'])->name('ambulance');
    Route::get('/get_ambulance_list', [App\Http\Controllers\MasterController::class, 'get_ambulance_list'])->name('get_ambulance_list');
    Route::get('/edit_ambulance/{id}', [App\Http\Controllers\MasterController::class, 'edit_ambulance'])->name('edit_ambulance');
    Route::post('/update_ambulance', [App\Http\Controllers\MasterController::class, 'update_ambulance'])->name('update_ambulance');

    Route::get('/staff_type', [App\Http\Controllers\MasterController::class, 'staff_type'])->name('staff_type');
    Route::get('/get_staff_type_list', [App\Http\Controllers\MasterController::class, 'get_staff_type_list'])->name('get_staff_type_list');
    Route::get('/add_staff_type', [App\Http\Controllers\MasterController::class, 'add_staff_type'])->name('add_staff_type');
    Route::get('/edit_staff_type/{id}', [App\Http\Controllers\MasterController::class, 'edit_staff_type'])->name('edit_staff_type');
    Route::post('/delete_staff_type', [App\Http\Controllers\MasterController::class, 'delete_staff_type'])->name('delete_staff_type');
    Route::post('/create_staff_type', [App\Http\Controllers\MasterController::class, 'create_staff_type'])->name('create_staff_type');
    Route::post('/update_staff_type', [App\Http\Controllers\MasterController::class, 'update_staff_type'])->name('update_staff_type');
    
    Route::get('/states', [App\Http\Controllers\MasterController::class, 'states'])->name('states');
    Route::get('/get_states_list', [App\Http\Controllers\MasterController::class, 'get_states_list'])->name('get_states_list');
    Route::post('/change_state_status', [App\Http\Controllers\MasterController::class, 'change_state_status'])->name('change_state_status');
    Route::get('/add_state', [App\Http\Controllers\MasterController::class, 'add_state'])->name('add_state');
    Route::get('/edit_state/{id}', [App\Http\Controllers\MasterController::class, 'edit_state'])->name('edit_state');
    Route::post('/delete_state', [App\Http\Controllers\MasterController::class, 'delete_state'])->name('delete_state');
    Route::post('/create_state', [App\Http\Controllers\MasterController::class, 'create_state'])->name('create_state');
    Route::post('/update_state', [App\Http\Controllers\MasterController::class, 'update_state'])->name('update_state');

    Route::get('/cities', [App\Http\Controllers\MasterController::class, 'cities'])->name('cities');
    Route::get('/get_cities_list', [App\Http\Controllers\MasterController::class, 'get_cities_list'])->name('get_cities_list');
    Route::get('/add_city', [App\Http\Controllers\MasterController::class, 'add_city'])->name('add_city');
    Route::get('/edit_city/{id}', [App\Http\Controllers\MasterController::class, 'edit_city'])->name('edit_city');
    Route::post('/delete_city', [App\Http\Controllers\MasterController::class, 'delete_city'])->name('delete_city');
    Route::post('/create_city', [App\Http\Controllers\MasterController::class, 'create_city'])->name('create_city');
    Route::post('/update_city', [App\Http\Controllers\MasterController::class, 'update_city'])->name('update_city');
    Route::post('/change_city_status', [App\Http\Controllers\MasterController::class, 'change_city_status'])->name('change_city_status');

    Route::get('/area', [App\Http\Controllers\MasterController::class, 'area'])->name('area');
    Route::get('/get_area_list', [App\Http\Controllers\MasterController::class, 'get_area_list'])->name('get_area_list');
    Route::get('/add_area', [App\Http\Controllers\MasterController::class, 'add_area'])->name('add_area');
    Route::get('/edit_area/{id}', [App\Http\Controllers\MasterController::class, 'edit_area'])->name('edit_area');
    Route::post('/delete_area', [App\Http\Controllers\MasterController::class, 'delete_area'])->name('delete_area');
    Route::post('/create_area', [App\Http\Controllers\MasterController::class, 'create_area'])->name('create_area');
    Route::post('/update_area', [App\Http\Controllers\MasterController::class, 'update_area'])->name('update_area');

    Route::get('/patients', [App\Http\Controllers\MenuController::class, 'patients'])->name('patients');
    Route::get('/get_patients_list', [App\Http\Controllers\MenuController::class, 'get_patients_list'])->name('get_patients_list');
    Route::get('/add_patient', [App\Http\Controllers\MenuController::class, 'add_patient'])->name('add_patient');
    Route::get('/edit_patient/{id}', [App\Http\Controllers\MenuController::class, 'edit_patient'])->name('edit_patient');
    Route::get('/view_patient_history/{id}', [App\Http\Controllers\MenuController::class, 'view_patient_history'])->name('view_patient_history');
    Route::get('/get_patient_history_list/{id}', [App\Http\Controllers\MenuController::class, 'get_patient_history_list'])->name('get_patient_history_list');
    Route::post('/delete_patient', [App\Http\Controllers\MenuController::class, 'delete_patient'])->name('delete_patient');
    Route::post('/create_patient', [App\Http\Controllers\MenuController::class, 'create_patient'])->name('create_patient');
    Route::post('/update_patient', [App\Http\Controllers\MenuController::class, 'update_patient'])->name('update_patient');

    Route::get('/staff', [App\Http\Controllers\MenuController::class, 'staff'])->name('staff');
    Route::get('/get_staff_list', [App\Http\Controllers\MenuController::class, 'get_staff_list'])->name('get_staff_list');
    Route::get('/add_staff', [App\Http\Controllers\MenuController::class, 'add_staff'])->name('add_staff');
    Route::get('/edit_staff/{id}', [App\Http\Controllers\MenuController::class, 'edit_staff'])->name('edit_staff');
    Route::get('/view_staff_details/{id}', [App\Http\Controllers\MenuController::class, 'view_staff_details'])->name('view_staff_details');
    Route::get('/view_staff_reviews/{id}', [App\Http\Controllers\MenuController::class, 'view_staff_reviews'])->name('view_staff_reviews');
    Route::get('/get_staff_all_reviews_list/{id}', [App\Http\Controllers\MenuController::class, 'get_staff_all_reviews_list'])->name('get_staff_all_reviews_list');
    Route::get('/staff_salary_slip/{id}', [App\Http\Controllers\MenuController::class, 'staff_salary_slip'])->name('staff_salary_slip');
    Route::get('/change_staff_password/{id}', [App\Http\Controllers\MenuController::class, 'change_staff_password'])->name('change_staff_password');
    Route::post('/delete_staff', [App\Http\Controllers\MenuController::class, 'delete_staff'])->name('delete_staff');
    Route::post('/create_staff', [App\Http\Controllers\MenuController::class, 'create_staff'])->name('create_staff');
    Route::post('/update_staff', [App\Http\Controllers\MenuController::class, 'update_staff'])->name('update_staff');
    Route::post('/remove_staff_document', [App\Http\Controllers\MenuController::class, 'remove_staff_document'])->name('remove_staff_document');
    Route::post('/get_staff_salary_slip_data', [App\Http\Controllers\MenuController::class, 'get_staff_salary_slip_data'])->name('get_staff_salary_slip_data');
    Route::post('/change_staff_password_post', [App\Http\Controllers\MenuController::class, 'change_staff_password_post'])->name('change_staff_password_post');
    Route::post('/change_staff_status', [App\Http\Controllers\MenuController::class, 'change_staff_status'])->name('change_staff_status');

    Route::get('/corporates', [App\Http\Controllers\MenuController::class, 'corporates'])->name('corporates');
    Route::get('/get_corporates_list', [App\Http\Controllers\MenuController::class, 'get_corporates_list'])->name('get_corporates_list');
    Route::get('/add_corporate', [App\Http\Controllers\MenuController::class, 'add_corporate'])->name('add_corporate');
    Route::get('/edit_corporate/{id}', [App\Http\Controllers\MenuController::class, 'edit_corporate'])->name('edit_corporate');
    Route::get('/view_corporate_history/{id}', [App\Http\Controllers\MenuController::class, 'view_corporate_history'])->name('view_corporate_history');
    Route::get('/get_corporate_history_list/{id}', [App\Http\Controllers\MenuController::class, 'get_corporate_history_list'])->name('get_corporate_history_list');
    Route::post('/delete_corporate', [App\Http\Controllers\MenuController::class, 'delete_corporate'])->name('delete_corporate');
    Route::post('/create_corporate', [App\Http\Controllers\MenuController::class, 'create_corporate'])->name('create_corporate');
    Route::post('/update_corporate', [App\Http\Controllers\MenuController::class, 'update_corporate'])->name('update_corporate');

    Route::get('/doctors', [App\Http\Controllers\MenuController::class, 'doctors'])->name('doctors');
    Route::get('/get_doctors_list', [App\Http\Controllers\MenuController::class, 'get_doctors_list'])->name('get_doctors_list');
    Route::get('/add_doctor', [App\Http\Controllers\MenuController::class, 'add_doctor'])->name('add_doctor');
    Route::get('/edit_doctor/{id}', [App\Http\Controllers\MenuController::class, 'edit_doctor'])->name('edit_doctor');
    Route::get('/view_doctor_details/{id}', [App\Http\Controllers\MenuController::class, 'view_doctor_details'])->name('view_doctor_details');
    Route::post('/delete_doctor', [App\Http\Controllers\MenuController::class, 'delete_doctor'])->name('delete_doctor');
    Route::post('/create_doctor', [App\Http\Controllers\MenuController::class, 'create_doctor'])->name('create_doctor');
    Route::post('/update_doctor', [App\Http\Controllers\MenuController::class, 'update_doctor'])->name('update_doctor');
    Route::post('/change_doctor_status', [App\Http\Controllers\MenuController::class, 'change_doctor_status'])->name('change_doctor_status');

    Route::get('/advance_salary', [App\Http\Controllers\PaymentController::class, 'advance_salary'])->name('advance_salary');
    Route::get('/get_advance_salary_list', [App\Http\Controllers\PaymentController::class, 'get_advance_salary_list'])->name('get_advance_salary_list');
    Route::get('/add_advance_salary', [App\Http\Controllers\PaymentController::class, 'add_advance_salary'])->name('add_advance_salary');
    Route::get('/edit_advance_salary/{id}', [App\Http\Controllers\PaymentController::class, 'edit_advance_salary'])->name('edit_advance_salary');
    Route::get('/advance_salary_history/{id}', [App\Http\Controllers\PaymentController::class, 'advance_salary_history'])->name('advance_salary_history');
    Route::post('/advance_salary_change_status', [App\Http\Controllers\PaymentController::class, 'advance_salary_change_status'])->name('advance_salary_change_status');
    Route::post('/create_advance_salary', [App\Http\Controllers\PaymentController::class, 'create_advance_salary'])->name('create_advance_salary');
    Route::post('/update_advance_salary', [App\Http\Controllers\PaymentController::class, 'update_advance_salary'])->name('update_advance_salary');

    Route::get('/salary', [App\Http\Controllers\PaymentController::class, 'salary'])->name('salary');
    Route::post('/get_staff_doctor_list', [App\Http\Controllers\PaymentController::class, 'get_staff_doctor_list'])->name('get_staff_doctor_list');
    Route::post('/get_staff_doctor_salary_details', [App\Http\Controllers\PaymentController::class, 'get_staff_doctor_salary_details'])->name('get_staff_doctor_salary_details');
    Route::post('/staff_salary_pay', [App\Http\Controllers\PaymentController::class, 'staff_salary_pay'])->name('staff_salary_pay');

    Route::get('/staff_salary_report', [App\Http\Controllers\ReportController::class, 'staff_salary_report'])->name('staff_salary_report');
    Route::get('/get_staff_salary_report_data', [App\Http\Controllers\ReportController::class, 'get_staff_salary_report_data'])->name('get_staff_salary_report_data');

    Route::get('/paused_booking_report', [App\Http\Controllers\ReportController::class, 'paused_booking_report'])->name('paused_booking_report');
    Route::get('/get_paused_booking_report_data', [App\Http\Controllers\ReportController::class, 'get_paused_booking_report_data'])->name('get_paused_booking_report_data');

});
