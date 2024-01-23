<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/Logout', 'HomeController@logout_page')->name('logout_page');

Route::get('/new_principal', 'Manage_principal_controller@index')->name('new_principal');
Route::post('/new_principal_process', 'Manage_principal_controller@new_principal_process')->name('new_principal_process');


Route::get('/new_principal_categories', 'Manage_principal_controller@new_principal_categories')->name('new_principal_categories');
Route::post('/new_categories_process', 'Manage_principal_controller@new_categories_process')->name('new_categories_process');
Route::post('/new_principal_categories_update', 'Manage_principal_controller@new_principal_categories_update')->name('new_principal_categories_update');
Route::post('/sku_category_add_sub_category', 'Manage_principal_controller@sku_category_add_sub_category')->name('sku_category_add_sub_category');

Route::get('/sku_add', 'Manage_sku_controller@index')->name('sku_add');
Route::post('/sku_show_main_category', 'Manage_sku_controller@sku_show_main_category')->name('sku_show_main_category');
Route::post('/sku_show_sub_category', 'Manage_sku_controller@sku_show_sub_category')->name('sku_show_sub_category');
Route::post('/sku_show_details', 'Manage_sku_controller@sku_show_details')->name('sku_show_details');
Route::post('/sku_add_process', 'Manage_sku_controller@sku_add_process')->name('sku_add_process');

Route::get('/sku_barcode', 'Sku_barcode_controller@index')->name('sku_barcode');
Route::post('/sku_barcode_show_sku', 'Sku_barcode_controller@sku_barcode_show_sku')->name('sku_barcode_show_sku');
Route::post('/sku_barcode_save', 'Sku_barcode_controller@sku_barcode_save')->name('sku_barcode_save');



Route::get('/sku_list', 'Sku_list_controller@index')->name('sku_list');
Route::get('pagination/fetch_data', 'Sku_list_controller@fetch_data');
Route::post('/sku_list_update_price', 'Sku_list_controller@sku_list_update_price')->name('sku_list_update_price');
Route::post('/sku_list_update_price_save', 'Sku_list_controller@sku_list_update_price_save')->name('sku_list_update_price_save');
Route::post('/sku_list_update_info', 'Sku_list_controller@sku_list_update_info')->name('sku_list_update_info');
Route::post('/search_sku_list', 'Sku_list_controller@search_sku_list')->name('search_sku_list');
Route::post('sku_list', 'Sku_list_controller@sku_update_data')->name('update.sku.post');
Route::post('/sku_list_show_data', 'Sku_list_controller@sku_list_show_data')->name('sku_list_show_data');

Route::get('/principal_discount', 'Principal_discount_controller@index')->name('principal_discount');
Route::post('/principal_discount_show_input', 'Principal_discount_controller@principal_discount_show_input')->name('principal_discount_show_input');
Route::post('/principal_discount_save', 'Principal_discount_controller@principal_discount_save')->name('principal_discount_save');

Route::get('/sku_ledger', 'Sku_ledger_controller@index');
Route::post('/search_inventory_ledger', 'Sku_ledger_controller@search_inventory_ledger')->name('postData');
Route::get('/sku_ledger_show_sku_details/{id}', 'Sku_ledger_controller@sku_ledger_show_sku_details')->name('sku_ledger_show_sku_details');

Route::get('/sku_extract_inventory', 'Sku_extract_inventory_controller@index');
Route::post('/extract_sku_inventory_generate_data', 'Sku_extract_inventory_controller@extract_sku_inventory_generate_data')->name('extract_sku_inventory_generate_data');
Route::post('/extract_sku_inventory_generate_agent_proceed', 'Sku_extract_inventory_controller@extract_sku_inventory_generate_agent_proceed')->name('extract_sku_inventory_generate_agent_proceed');
Route::post('/extract_sku_inventory_generate_export_data', 'Sku_extract_inventory_controller@extract_sku_inventory_generate_export_data')->name('extract_sku_inventory_generate_export_data');

Route::get('/sku_update_price', 'Sku_price_update_controller@index');
Route::post('/sku_update_price_show_sku', 'Sku_price_update_controller@sku_update_price_show_sku')->name('sku_update_price_show_sku');
Route::post('/sku_update_price_generate_price_inputs', 'Sku_price_update_controller@sku_update_price_generate_price_inputs')->name('sku_update_price_generate_price_inputs');
Route::post('/sku_update_price_save', 'Sku_price_update_controller@sku_update_price_save')->name('sku_update_price_save');

Route::get('/purchase_order', 'Purchase_order_controller@index')->name('purchase_order.index');
Route::post('/principal_show_inputs', 'Purchase_order_controller@purchase_order_show_input')->name('postData');
Route::post('/purchase_order_store_data', 'Purchase_order_controller@purchase_order_store_data')->name('postData');
Route::post('/purchase_order_cart', 'Purchase_order_controller@purchase_order_cart')->name('postData');
Route::post('/purchase_order_remove_cart', 'Purchase_order_controller@purchase_order_remove_cart')->name('postData');
Route::post('/purchase_order_save', 'Purchase_order_controller@purchase_order_save')->name('postData');

Route::get('/purchase_order_confirmation', 'Purchase_order_confirmation_controller@index')->name('purchase_order_confirmation');
Route::post('/purchase_order_confirmation_proceed', 'Purchase_order_confirmation_controller@purchase_order_confirmation_proceed')->name('purchase_order_confirmation_proceed');
Route::post('/purchase_order_confirmation_final_summary', 'Purchase_order_confirmation_controller@purchase_order_confirmation_final_summary')->name('purchase_order_confirmation_final_summary');
Route::post('/purchase_order_confirmation_saved', 'Purchase_order_confirmation_controller@purchase_order_confirmation_saved')->name('purchase_order_confirmation_saved');




Route::get('/purchase_order_report', 'Purchase_order_report_controller@index');
Route::post('/purchase_order_report_show_list', 'Purchase_order_report_controller@purchase_order_report_show_list')->name('postData');
Route::get('/purchase_order_report_show_details/{id}', 'Purchase_order_report_controller@purchase_order_report_show_details')->name('purchase_order_report_show_details');
Route::post('purchase_order_report', 'Purchase_order_report_controller@upload_confirmation_image')->name('confirmation.upload.post');
Route::post('purchase_order_report_show_data', 'Purchase_order_report_controller@purchase_order_report_show_data')->name('purchase_order_report_show_data');




Route::get('/receiving_draft', 'Receiving_draft_controller@index');
Route::post('/receiving_draft_proceed_generate', 'Receiving_draft_controller@receiving_draft_proceed_generate')->name('receiving_draft_proceed_generate');
Route::post('/receiving_draft_proceed', 'Receiving_draft_controller@receiving_draft_proceed')->name('receiving_draft_proceed');
Route::post('/receiving_draft_sku_selection', 'Receiving_draft_controller@receiving_draft_sku_selection')->name('receiving_draft_sku_selection');
Route::post('/receiving_draft_final_saved', 'Receiving_draft_controller@receiving_draft_final_saved')->name('receiving_draft_final_saved');




Route::get('/receive_order', 'Receive_controller@index');
Route::post('/receive_order_generate_data', 'Receive_controller@receive_order_generate_data')->name('postData');
Route::post('/receive_order_data_final_summary', 'Receive_controller@receive_order_data_final_summary')->name('postData');
Route::post('/receive_order_filter_quantity', 'Receive_controller@receive_order_filter_quantity')->name('postData');
Route::post('/received_order_save', 'Receive_controller@received_order_save')->name('postData');
Route::post('/received_order_show_selected_discount', 'Receive_controller@received_order_show_selected_discount')->name('postData');




Route::get('/received_invoice', 'Received_invoice_controller@index');
Route::post('/received_invoice_show_inputs', 'Received_invoice_controller@received_invoice_show_inputs')->name('postData');
Route::post('received_invoice', 'Received_invoice_controller@received_invoice_upload_image')->name('image.upload.post');







Route::get('/receive_order_report', 'Receive_order_report_controller@index');
Route::post('/receive_order_report_list', 'Receive_order_report_controller@receive_order_report_list')->name('postData');
Route::get('/discount_allocation/{id}', 'Receive_order_report_controller@discount_allocation')->name('discount_allocation');
Route::get('/received_sku_report/{id}', 'Receive_order_report_controller@received_sku_report')->name('received_sku_report');
Route::get('/discount_allocation_all/{id}', 'Receive_order_report_controller@discount_allocation_all')->name('discount_allocation_all');
Route::get('/received_order_report_print/{id}', 'Receive_order_report_controller@received_order_report_print')->name('received_order_report_print');

Route::get('/received_order_report_show_details/{id}', 'Receive_order_report_controller@received_order_report_show_details')->name('received_order_report_show_details');




Route::get('/return_to_principal', 'Return_to_principal_controller@index');
Route::post('/return_show_inputs', 'Return_to_principal_controller@return_show_inputs')->name('postData');
Route::post('/return_to_principal_summary', 'Return_to_principal_controller@return_to_principal_summary')->name('postData');
Route::post('/return_to_principal_save', 'Return_to_principal_controller@return_to_principal_save')->name('postData');


Route::get('return_to_principal_reports', 'Return_to_principal_report_controller@index');
Route::post('/return_to_principal_report_data', 'Return_to_principal_report_controller@return_to_principal_report_data')->name('postData');
Route::get('/return_to_principal_show_list_details/{id}', 'Return_to_principal_report_controller@return_to_principal_show_list_details')->name('return_to_principal_show_list_details');



// Route::get('/personnel_description', 'Personnel_description_controller@index');
// Route::post('/personnel_description_save', 'Personnel_description_controller@personnel_description_save')->name('personnel_description_save.save');
// Route::post('/personnel_description_edit/{id}', 'Personnel_description_controller@personnel_description_edit')->name('personnel_description_edit.edit');
// Route::post('/personnel_description_destroy/{id}', 'Personnel_description_controller@personnel_description_destroy')->name('personnel_description_edit.destroy');



// Route::get('/personnel_add', 'Personnel_add_controller@index');
// Route::post('/personnel_add_save', 'Personnel_add_controller@personnel_add_save')->name('postData');
// Route::post('/personnel_add_edit/{id}', 'Personnel_add_controller@personnel_add_edit')->name('personnel_add_edit.edit');
// Route::post('/personnel_add_destroy/{id}', 'Personnel_add_controller@personnel_add_destroy')->name('personnel_add_destroy.destroy');





Route::get('/principal_discount_list', 'Principal_discount_list_controller@index');
Route::post('/principal_discount_show_data_list', 'Principal_discount_list_controller@principal_discount_show_data_list')->name('postData');


Route::get('/principal_ledger', 'Principal_ledger_controller@index');
Route::post('/principal_ledger_generate_report', 'Principal_ledger_controller@principal_ledger_generate_report')->name('principal_ledger_generate_report');


Route::get('/principal_payment', 'Principal_payment_controller@index');
Route::get('/principal_payment_generate_accounts_payable', 'Principal_payment_controller@principal_payment_generate_accounts_payable')->name('principal_payment_generate_accounts_payable');
Route::post('/principal_payment_generate_final_summary', 'Principal_payment_controller@principal_payment_generate_final_summary')->name('principal_payment_generate_final_summary');
Route::post('/princpal_payment_save', 'Principal_payment_controller@princpal_payment_save')->name('princpal_payment_save');



Route::get('/bo_allowance_adjustments', 'Bo_allowance_adjustments_controller@index');
Route::post('/bo_allowance_adjustments_inputs', 'Bo_allowance_adjustments_controller@bo_allowance_adjustments_inputs')->name('postData');
Route::post('/bo_allowance_adjustments_show_summary', 'Bo_allowance_adjustments_controller@bo_allowance_adjustments_show_summary')->name('postData');
Route::post('/bo_allowance_adjustments_save', 'Bo_allowance_adjustments_controller@bo_allowance_adjustments_save')->name('postData');


Route::get('/bo_allowance_total', 'Bo_allowance_total_controller@index');
Route::post('/bo_allowance_total_generate_page', 'Bo_allowance_total_controller@bo_allowance_total_generate_page')->name('bo_allowance_total_generate_page');
Route::post('/bo_allowance_total_proceed_to_final_summary', 'Bo_allowance_total_controller@bo_allowance_total_proceed_to_final_summary')->name('bo_allowance_total_proceed_to_final_summary');
Route::post('/bo_allowance_total_save', 'Bo_allowance_total_controller@bo_allowance_total_save')->name('bo_allowance_total_save');

Route::get('/subsidy', 'Subsidy_controller@index');

Route::get('/bo_allowance_adjustments_report', 'Bo_allowance_adjustments_report_controller@index');
Route::post('/bo_allowance_adjustments_generate_report', 'Bo_allowance_adjustments_report_controller@bo_allowance_adjustments_generate_report')->name('postData');
Route::get('/bo_allowance_adjustments_show_details/{id}', 'Bo_allowance_adjustments_report_controller@bo_allowance_adjustments_show_details')->name('bo_allowance_adjustments_show_details');



Route::get('/invoice_cost_adjustments', 'Invoice_cost_adjustment_controller@index');
Route::post('/invoice_cost_adjustments_input', 'Invoice_cost_adjustment_controller@invoice_cost_adjustments_input')->name('postData');
Route::post('/invoice_cost_adjustments_show_summary', 'Invoice_cost_adjustment_controller@invoice_cost_adjustments_show_summary')->name('postData');
Route::post('/invoice_cost_adjustments_save', 'Invoice_cost_adjustment_controller@invoice_cost_adjustments_save')->name('postData');



Route::get('/invoice_cost_adjustments_report', 'Invoice_cost_adjustments_report_controller@index');
Route::post('/invoice_cost_adjustments_report_show_list', 'Invoice_cost_adjustments_report_controller@invoice_cost_adjustments_report_show_list')->name('postData');
Route::get('/invoice_cost_adjustments_show_details/{id}', 'Invoice_cost_adjustments_report_controller@invoice_cost_adjustments_show_details')->name('invoice_cost_adjustments_show_details');


Route::get('/bodega_out', 'Bodega_out_controller@index');
Route::post('/bodega_out_show_input', 'Bodega_out_controller@bodega_out_show_input')->name('postData');
Route::post('/show_equivalent', 'Bodega_out_controller@show_equivalent')->name('postData');
Route::post('/bodega_out_summary', 'Bodega_out_controller@bodega_out_summary')->name('postData');
Route::post('/bodega_out_saved', 'Bodega_out_controller@bodega_out_saved')->name('postData');

Route::get('/bodega_out_report', 'Bodega_out_report_controller@index');
Route::post('/bodega_out_report_list', 'Bodega_out_report_controller@bodega_out_report_list')->name('postData');
Route::get('/bodega_out_show_details/{id}', 'Bodega_out_report_controller@bodega_out_show_details')->name('bodega_out_show_details');

Route::get('/transfer_to_branch', 'Transfer_to_branch_controller@index');
Route::post('/transfer_to_branch_show_input', 'Transfer_to_branch_controller@transfer_to_branch_show_input')->name('postData');
Route::post('/transfer_to_branch_saved', 'Transfer_to_branch_controller@transfer_to_branch_saved')->name('postData');

Route::get('/transfer_to_branch_report', 'Transfer_to_branch_report_controller@index');
Route::post('/transfer_to_branch_show_list', 'Transfer_to_branch_report_controller@transfer_to_branch_show_list')->name('postData');
Route::get('/transfer_to_branch_show_details/{id}', 'Transfer_to_branch_report_controller@transfer_to_branch_show_details')->name('transfer_to_branch_show_details');

Route::get('/principal_discount', 'Principal_discount_controller@index')->name('principal_discount');
Route::post('/principal_discount_show_input', 'Principal_discount_controller@principal_discount_show_input')->name('principal_discount_show_input');
Route::post('/principal_discount_save', 'Principal_discount_controller@principal_discount_save')->name('principal_discount_save');


Route::get('/driver_helper', 'Driver_helper_controller@index');
Route::post('/driver_helper_saved', 'Driver_helper_controller@driver_helper_saved')->name('driver_helper_saved');

Route::get('/agent', 'Agent_controller@index');
Route::post('/agent_saved', 'Agent_controller@agent_saved')->name('agent_saved');





Route::get('/location', 'Location_controller@index')->name('location');
Route::post('/location_save', 'Location_controller@location_save')->name('postData');
Route::post('/location_details_save', 'Location_controller@location_details_save')->name('postData');
Route::post('/location_add_details', 'Location_controller@location_add_details')->name('location_add_details');
Route::get('/location_export', 'Location_controller@location_export')->name('location_export');





Route::get('/customer', 'Customer_controller@index')->name('customer');
Route::post('/customer_show_location_details', 'Customer_controller@customer_show_location_details')->name('postData');
Route::post('/customer_save', 'Customer_controller@customer_save')->name('postData');
Route::post('/customer_location_update', 'Customer_controller@customer_location_update')->name('customer_location_update');
Route::post('/customer_generate_location_details', 'Customer_controller@customer_generate_location_details')->name('customer_generate_location_details');



Route::get('/customer_discount', 'Customer_discount_controller@index')->name('customer_discount');
Route::post('/customer_discount_show_input', 'Customer_discount_controller@customer_discount_show_input')->name('customer_discount_show_input');
Route::post('/customer_discount_save', 'Customer_discount_controller@customer_discount_save')->name('customer_discount_save');

Route::get('/apply_customer_to_agent', 'Apply_customer_to_agent_controller@index');
Route::post('/apply_customer_to_agent_generate_customer', 'Apply_customer_to_agent_controller@apply_customer_to_agent_generate_customer')->name('apply_customer_to_agent_generate_customer');
Route::post('/apply_customer_to_agent_save', 'Apply_customer_to_agent_controller@apply_customer_to_agent_save')->name('apply_customer_to_agent_save');

Route::get('/applied_customer_to_agent_report', 'Applied_customer_to_agent_report_controller@index');
Route::post('/applied_customer_to_agent_generate_customer_report', 'Applied_customer_to_agent_report_controller@applied_customer_to_agent_generate_customer_report')->name('applied_customer_to_agent_generate_customer_report');
Route::get('/apply_customer_to_agent_report_remove', 'Applied_customer_to_agent_report_controller@apply_customer_to_agent_report_remove')->name('apply_customer_to_agent_report_remove');


Route::get('/customer_profile', 'Customer_profile_controller@index')->name('customer_profile');
Route::post('/customer_profile_search', 'Customer_profile_controller@customer_profile_search')->name('customer_profile_search');
Route::get('/customer_profile_show_details/{id}', 'Customer_profile_controller@customer_profile_show_details')->name('customer_profile_show_details');
Route::post('/customer_profile_update_credit_line', 'Customer_profile_controller@customer_profile_update_credit_line')->name('customer_profile_update_credit_line');
Route::post('/customer_profile_status_changed', 'Customer_profile_controller@customer_profile_status_changed')->name('customer_profile_status_changed');
Route::post('/customer_profile_update', 'Customer_profile_controller@customer_profile_update')->name('customer_profile_update');

Route::get('/customer_profile_generate_principal_code_list', 'Customer_profile_controller@customer_profile_generate_principal_code_list')->name('customer_profile_generate_principal_code_list');

Route::post('/customer_profile_generate', 'Customer_profile_controller@customer_profile_generate')->name('customer_profile_generate');

Route::get('/customer_list', 'Customer_list_controller@index')->name('customer_list');
Route::post('/customer_list_generate_data', 'Customer_list_controller@customer_list_generate_data')->name('customer_list_generate_data');
Route::get('/customer_list_show_map/{location_id}', 'Customer_list_controller@customer_list_show_map')->name('customer_list_show_map');





Route::get('/customer_principal_code_price_level', 'Customer_principal_code_price_level_controller@index')->name('customer_principal_code_price_level');
Route::post('/customer_principal_code_price_level_proceed', 'Customer_principal_code_price_level_controller@customer_principal_code_price_level_proceed')->name('customer_principal_code_price_level_proceed');
Route::post('/customer_principal_code_price_level_saved', 'Customer_principal_code_price_level_controller@customer_principal_code_price_level_saved')->name('customer_principal_code_price_level_saved');


Route::get('/sales_order', 'Sales_order_controller@index')->name('sales_order');
Route::post('/sales_order_upload', 'Sales_order_controller@sales_order_upload')->name('sales_order_upload');
Route::get('/sales_order_draft', 'Sales_order_controller@sales_order_draft')->name('sales_order_draft');
Route::post('/sales_order_draft_generate', 'Sales_order_controller@sales_order_draft_generate')->name('sales_order_draft_generate');
Route::post('/sales_order_draft_proceed_to_final_summary', 'Sales_order_controller@sales_order_draft_proceed_to_final_summary')->name('sales_order_draft_proceed_to_final_summary');
Route::post('/sales_order_draft_save', 'Sales_order_controller@sales_order_draft_save')->name('sales_order_draft_save');
Route::post('/sales_order_draft_update_customer_process', 'Sales_order_controller@sales_order_draft_update_customer_process')->name('sales_order_draft_update_customer_process');





Route::get('/sales_invoice', 'Sales_invoice_controller@index')->name('sales_invoice');
Route::get('/sales_invoice_generate', 'Sales_invoice_controller@sales_invoice_generate')->name('sales_invoice_generate');





// Route::post('/sales_order_proceed_to_summary', 'Sales_order_controller@sales_order_proceed_to_summary')->name('sales_order_proceed_to_summary');
// Route::post('/sales_order_upload_save', 'Sales_order_controller@sales_order_upload_save')->name('sales_order_upload_save');



Route::get('/sales_invoicing', 'Sales_invoicing_controller@index');
Route::post('/sales_invoicing_generate_dr', 'Sales_invoicing_controller@sales_invoicing_generate_dr')->name('sales_invoicing_generate_dr');
Route::get('/sales_invoicing_print_dr/{id}', 'Sales_invoicing_controller@sales_invoicing_print_dr')->name('sales_invoicing_print_dr');
Route::get('/sales_invoicing_print_control_for_salesman/{id}', 'Sales_invoicing_controller@sales_invoicing_print_control_for_salesman')->name('sales_invoicing_print_control_for_salesman');
Route::get('/sales_invoicing_print_control_for_sku/{id}', 'Sales_invoicing_controller@sales_invoicing_print_control_for_sku')->name('sales_invoicing_print_control_for_sku');
Route::post('/sales_invoicing_cancel_dr', 'Sales_invoicing_controller@sales_invoicing_cancel_dr')->name('sales_invoicing_cancel_dr');
Route::post('/sales_invoicing_reprint_dr', 'Sales_invoicing_controller@sales_invoicing_reprint_dr')->name('sales_invoicing_reprint_dr');




Route::get('/sales_control', 'Sales_control_controller@index')->name('sales_control');
Route::post('/sales_control_proceed', 'Sales_control_controller@sales_control_proceed')->name('sales_control_proceed');
Route::get('/sales_control_proceed_to_print_dr', 'Sales_control_controller@sales_control_proceed_to_print_dr')->name('sales_control_proceed_to_print_dr');
Route::get('/sales_control_proceed_to_print_salesman', 'Sales_control_controller@sales_control_proceed_to_print_salesman')->name('sales_control_proceed_to_print_salesman');

Route::get('/sales_order_report', 'Sales_order_report_controller@index')->name('sales_order_report');
Route::post('/sales_order_report_generate_data', 'Sales_order_report_controller@sales_order_report_generate_data')->name('sales_order_report_generate_data');

Route::get('/sales_order_register', 'Sales_order_register_controller@index')->name('sales_order_register');
Route::post('/sales_order_register_show_next_input', 'Sales_order_register_controller@sales_order_register_show_next_input')->name('sales_order_register_show_next_input');
Route::post('/sales_order_register_generate_sales_register', 'Sales_order_register_controller@sales_order_register_generate_sales_register')->name('sales_order_register_generate_sales_register');
Route::post('/sales_order_register_view_details', 'Sales_order_register_controller@sales_order_register_view_details')->name('sales_order_register_view_details');

Route::get('/van_selling_withdrawal', 'Van_selling_widthdrawal_controller@index');
Route::post('/van_selling_generate_sku', 'Van_selling_widthdrawal_controller@van_selling_generate_sku')->name('van_selling_generate_sku');
Route::post('/van_selling_generate_sku_quantity', 'Van_selling_widthdrawal_controller@van_selling_generate_sku_quantity')->name('van_selling_generate_sku_quantity');
Route::post('/van_selling_generate_final_summary', 'Van_selling_widthdrawal_controller@van_selling_generate_final_summary')->name('van_selling_generate_final_summary');
Route::post('/van_selling_save', 'Van_selling_widthdrawal_controller@van_selling_save')->name('van_selling_save');

Route::get('/van_selling_inventory_export', 'Van_selling_inventory_export_controller@index');
Route::post('/van_selling_inventory_export_generate_data', 'Van_selling_inventory_export_controller@van_selling_inventory_export_generate_data')->name('van_selling_inventory_export_generate_data');
Route::post('/van_selling_inventory_export_save', 'Van_selling_inventory_export_controller@van_selling_inventory_export_save')->name('van_selling_inventory_export_save');
Route::post('/van_selling_inventory_export_inventory_adjustments_save', 'Van_selling_inventory_export_controller@van_selling_inventory_export_inventory_adjustments_save')->name('van_selling_inventory_export_inventory_adjustments_save');
Route::post('/van_selling_inventory_export_admin_export_verify', 'Van_selling_inventory_export_controller@van_selling_inventory_export_admin_export_verify')->name('van_selling_inventory_export_admin_export_verify');



Route::get('/van_selling_report', 'Van_selling_report_controller@index');
// Route::post('/van_selling_report_show_input', 'Van_selling_report_controller@van_selling_report_show_input')->name('van_selling_report_show_input');
Route::post('/van_selling_report_generate_data', 'Van_selling_report_controller@van_selling_report_generate_data')->name('van_selling_report_generate_data');
Route::get('/van_selling_report_show_details/{id}', 'Van_selling_report_controller@van_selling_report_show_details')->name('van_selling_report_show_details');
Route::post('/van_selling_report_itemized', 'Van_selling_report_controller@van_selling_report_itemized')->name('van_selling_report_itemized');
Route::post('/van_selling_report_generate_clearing', 'Van_selling_report_controller@van_selling_report_generate_clearing')->name('van_selling_report_generate_clearing');
Route::post('/van_selling_report_clearing_operation_save', 'Van_selling_report_controller@van_selling_report_clearing_operation_save')->name('van_selling_report_clearing_operation_save');



Route::get('/van_selling_invoice', 'Van_selling_invoice_controller@index');
Route::post('/van_selling_invoice_generate', 'Van_selling_invoice_controller@van_selling_invoice_generate')->name('van_selling_invoice_generate');

Route::post('/van_selling_invoice_print', 'Van_selling_invoice_controller@van_selling_invoice_print')->name('van_selling_invoice_print');


Route::get('/van_selling_reinvoice', 'Van_selling_reinvoice_controller@index');
Route::post('/van_selling_reinvoice_generate_dr', 'Van_selling_reinvoice_controller@van_selling_reinvoice_generate_dr')->name('van_selling_reinvoice_generate_dr');
Route::post('/van_selling_reinvoice_generate_dr_details', 'Van_selling_reinvoice_controller@van_selling_reinvoice_generate_dr_details')->name('van_selling_reinvoice_generate_dr_details');
Route::post('/van_selling_reinvoice_print', 'Van_selling_reinvoice_controller@van_selling_reinvoice_print')->name('van_selling_reinvoice_print');
Route::post('/van_selling_print_save', 'Van_selling_reinvoice_controller@van_selling_print_save')->name('van_selling_print_save');
Route::post('/van_selling_reinvoice_cancel', 'Van_selling_reinvoice_controller@van_selling_reinvoice_cancel')->name('van_selling_reinvoice_cancel');

Route::get('/van_selling_import_data', 'Van_selling_import_data_controller@index');
Route::post('/van_selling_import_data_save', 'Van_selling_import_data_controller@van_selling_import_data_save')->name('van_selling_import_data_save');

Route::get('/van_selling_export_updated_price', 'Van_selling_export_updated_price_controller@index');
Route::post('/van_selling_export_updated_price_generate_customer', 'Van_selling_export_updated_price_controller@van_selling_export_updated_price_generate_customer')->name('van_selling_export_updated_price_generate_customer');
Route::post('/van_selling_export_updated_price_generate_data', 'Van_selling_export_updated_price_controller@van_selling_export_updated_price_generate_data')->name('van_selling_export_updated_price_generate_data');





Route::get('/van_selling_payment', 'Van_selling_payment_controller@index');
Route::post('/van_selling_payment_search_store_code', 'Van_selling_payment_controller@van_selling_payment_search_store_code')->name('van_selling_payment_search_store_code');
Route::post('/van_selling_payment_save', 'Van_selling_payment_controller@van_selling_payment_save')->name('van_selling_payment_save');
Route::post('/van_selling_short_payment_save', 'Van_selling_payment_controller@van_selling_short_payment_save')->name('van_selling_short_payment_save');



Route::get('/van_selling_actual_stocks_on_hand', 'Van_selling_actual_stocks_on_hand_controller@index');
Route::post('/van_selling_actual_stocks_on_hand_proceed', 'Van_selling_actual_stocks_on_hand_controller@van_selling_actual_stocks_on_hand_proceed')->name('van_selling_actual_stocks_on_hand_proceed');
Route::post('/van_selling_actual_stocks_on_hand_final_summary', 'Van_selling_actual_stocks_on_hand_controller@van_selling_actual_stocks_on_hand_final_summary')->name('van_selling_actual_stocks_on_hand_final_summary');
Route::post('/van_selling_actual_stocks_on_hand_save', 'Van_selling_actual_stocks_on_hand_controller@van_selling_actual_stocks_on_hand_save')->name('van_selling_actual_stocks_on_hand_save');


Route::get('/van_selling_adjustments', 'Van_selling_adjustments_controller@index');
Route::post('/van_selling_adjustments_generate', 'Van_selling_adjustments_controller@van_selling_adjustments_generate')->name('van_selling_adjustments_generate');
Route::post('/van_selling_adjustments_final_summary', 'Van_selling_adjustments_controller@van_selling_adjustments_final_summary')->name('van_selling_adjustments_final_summary');
Route::post('/van_selling_adjusutments_save', 'Van_selling_adjustments_controller@van_selling_adjusutments_save')->name('van_selling_adjusutments_save');

Route::get('/van_selling_adjustments_export', 'Van_selling_adjustments_export_controller@index');
Route::post('/van_selling_adjustments_export_generate_data', 'Van_selling_adjustments_export_controller@van_selling_adjustments_export_generate_data')->name('van_selling_adjustments_export_generate_data');
Route::post('/van_selling_adjustmnets_export_save', 'Van_selling_adjustments_export_controller@van_selling_adjustmnets_export_save')->name('van_selling_adjustmnets_export_save');



Route::get('/pcm_upload', 'Pcm_upload_controller@index');
Route::post('/pcm_upload_save', 'Pcm_upload_controller@pcm_upload_save')->name('pcm_upload_save');


Route::get('/pcm_upload_report', 'Pcm_upload_report_controller@index');
Route::post('/pcm_upload_report_generate', 'Pcm_upload_report_controller@pcm_upload_report_generate')->name('pcm_upload_report_generate');
Route::post('/pcm_upload_report_generate_details', 'Pcm_upload_report_controller@pcm_upload_report_generate_details')->name('pcm_upload_report_generate_details');
Route::post('/pcm_upload_report_rgs_save', 'Pcm_upload_report_controller@pcm_upload_report_rgs_save')->name('pcm_upload_report_rgs_save');
Route::post('/pcm_upload_report_bo_save', 'Pcm_upload_report_controller@pcm_upload_report_bo_save')->name('pcm_upload_report_bo_save');





Route::get('/pcm_manual', 'Pcm_manual_controller@index');
Route::post('/pcm_manual_generate_dr_details', 'Pcm_manual_controller@pcm_manual_generate_dr_details')->name('pcm_manual_generate_dr_details');
Route::post('/pcm_manual_generate_final_summary', 'Pcm_manual_controller@pcm_manual_generate_final_summary')->name('pcm_manual_generate_final_summary');
Route::post('/pcm_manual_save', 'Pcm_manual_controller@pcm_manual_save')->name('pcm_manual_save');





// Route::get('/customer_update', 'Customer_update_controller@index')->name('customer_update');
// Route::post('/customer_update_generate', 'Customer_update_controller@customer_update_generate')->name('customer_update_generate');
// Route::post('/customer_update_save', 'Customer_update_controller@customer_update_save')->name('customer_update_save');





// Route::get('/sales_order_migrate', 'Sales_order_migrate_controller@index');
// Route::post('/sales_order_upload', 'Sales_order_migrate_controller@sales_order_upload')->name('sales_order_upload');
// Route::post('/sales_order_upload_final_summary', 'Sales_order_migrate_controller@sales_order_upload_final_summary')->name('sales_order_upload_final_summary');
// Route::post('/sales_order_upload_save', 'Sales_order_migrate_controller@sales_order_upload_save')->name('sales_order_upload_save');
// Route::post('/sales_order_upload_save_control', 'Sales_order_migrate_controller@sales_order_upload_save_control')->name('sales_order_upload_save_control');
// Route::get('/sales_order_upload_remove_sku', 'Sales_order_migrate_controller@sales_order_upload_remove_sku')->name('sales_order_upload_remove_sku');

Route::get('/walkin_sales_order', 'Walkin_sales_order_controller@index');
Route::post('/walk_sales_order_generate_sku', 'Walkin_sales_order_controller@walk_sales_order_generate_sku')->name('walk_sales_order_generate_sku');
Route::post('/walkin_sales_order_generate_form', 'Walkin_sales_order_controller@walkin_sales_order_generate_form')->name('walkin_sales_order_generate_form');
Route::post('/walkin_sales_order_generate_final_summary', 'Walkin_sales_order_controller@walkin_sales_order_generate_final_summary')->name('walkin_sales_order_generate_final_summary');
Route::post('/walkin_sales_order_save', 'Walkin_sales_order_controller@walkin_sales_order_save')->name('walkin_sales_order_save');


Route::post('/sales_order_migrate_print_salesman_control', 'Sales_order_migrate_controller@sales_order_migrate_print_salesman_control')->name('sales_order_migrate_print_salesman_control');
Route::post('/sales_order_migrate_print_sku_control', 'Sales_order_migrate_controller@sales_order_migrate_print_sku_control')->name('sales_order_migrate_print_sku_control');

// Route::post('/transfer_to_branch_show_list', 'Transfer_to_branch_report_controller@transfer_to_branch_show_list')->name('postData');
// Route::get('/transfer_to_branch_show_details/{id}', 'Transfer_to_branch_report_controller@transfer_to_branch_show_details')->name('transfer_to_branch_show_details');




Route::get('/customer_profile', 'Customer_profile_controller@index')->name('customer_profile');
Route::post('/customer_profile_search', 'Customer_profile_controller@customer_profile_search')->name('customer_profile_search');
Route::get('/customer_profile_show_details/{id}', 'Customer_profile_controller@customer_profile_show_details')->name('customer_profile_show_details');




Route::get('/customer_category_discount', 'Customer_category_discount_controller@index')->name('customer_category_discount');
Route::post('/customer_category_discount_show_location_details_input', 'Customer_category_discount_controller@customer_category_discount_show_location_details_input')->name('customer_category_discount_show_location_details_input');
Route::post('/customer_category_discount_show_last_inputs', 'Customer_category_discount_controller@customer_category_discount_show_last_inputs')->name('customer_category_discount_show_last_inputs');
Route::post('/customer_category_discount_generate_discount', 'Customer_category_discount_controller@customer_category_discount_generate_discount')->name('customer_category_discount_generate_discount');
Route::post('/customer_category_discount_save', 'Customer_category_discount_controller@customer_category_discount_save')->name('customer_category_discount_save');

Route::get('/customer_payment', 'Customer_payment_controller@index')->name('customer_payment');
Route::post('/customer_payment_search_store_code', 'Customer_payment_controller@customer_payment_search_store_code')->name('customer_payment_search_store_code');
Route::post('/customer_payment_generate_summary', 'Customer_payment_controller@customer_payment_generate_summary')->name('customer_payment_generate_summary');
Route::post('/customer_payment_save', 'Customer_payment_controller@customer_payment_save')->name('customer_payment_save');

Route::get('/sales_order_converted_report', 'Sales_order_converted_report_controller@index')->name('sales_order_converted_report');
Route::post('/sales_order_converted_report_generate_data', 'Sales_order_converted_report_controller@sales_order_converted_report_generate_data')->name('sales_order_converted_report_generate_data');
Route::post('/sales_order_converted_report_show_dr', 'Sales_order_converted_report_controller@sales_order_converted_report_show_dr')->name('sales_order_converted_report_show_dr');
Route::get('/sales_order_converted_report_show_dr_details/{id}', 'Sales_order_converted_report_controller@sales_order_converted_report_show_dr_details')->name('sales_order_converted_report_show_dr_details');
Route::get('/sales_order_converted_report_show_control/{id}', 'Sales_order_converted_report_controller@sales_order_converted_report_show_control')->name('sales_order_converted_report_show_control');
Route::post('/sales_order_converted_report_cancel_dr', 'Sales_order_converted_report_controller@sales_order_converted_report_cancel_dr')->name('sales_order_converted_report_cancel_dr');



Route::get('/customer_credit_memo_for_bo', 'Customer_credit_memo_for_bo_controller@index')->name('customer_credit_memo_for_bo');
Route::post('/customer_credit_memo_for_bo_show_dr_details', 'Customer_credit_memo_for_bo_controller@customer_credit_memo_for_bo_show_dr_details')->name('customer_credit_memo_for_bo_show_dr_details');
Route::post('/customer_credit_memo_for_bo_save', 'Customer_credit_memo_for_bo_controller@customer_credit_memo_for_bo_save')->name('customer_credit_memo_for_bo_save');
Route::post('/customer_credit_memo_for_bo_generate_final_computation', 'Customer_credit_memo_for_bo_controller@customer_credit_memo_for_bo_generate_final_computation')->name('customer_credit_memo_for_bo_generate_final_computation');





Route::get('/customer_credit_memo_for_rgs', 'Customer_credit_memo_for_rgs_controller@index')->name('customer_credit_memo_for_rgs');
Route::post('/customer_credit_memo_for_rgs_show_dr_details', 'Customer_credit_memo_for_rgs_controller@customer_credit_memo_for_rgs_show_dr_details')->name('customer_credit_memo_for_rgs_show_dr_details');
Route::post('/customer_credit_memo_for_rgs_save', 'Customer_credit_memo_for_rgs_controller@customer_credit_memo_for_rgs_save')->name('customer_credit_memo_for_rgs_save');


Route::get('/credit_memo_for_confirmation', 'Credit_memo_for_confirmation_controller@index')->name('credit_memo_for_confirmation');
Route::post('/credit_memo_for_confirmation_show_dr', 'Credit_memo_for_confirmation_controller@credit_memo_for_confirmation_show_dr')->name('credit_memo_for_confirmation_show_dr');


Route::get('/customer_credit_memo_for_others', 'Customer_credit_memo_for_others_controller@index')->name('customer_credit_memo_for_others');

Route::post('/customer_credit_memo_for_others_show_sku', 'Customer_credit_memo_for_others_controller@customer_credit_memo_for_others_show_sku')->name('customer_credit_memo_for_others_show_sku');
Route::post('/customer_credit_memo_for_others_proceed_summary', 'Customer_credit_memo_for_others_controller@customer_credit_memo_for_others_proceed_summary')->name('customer_credit_memo_for_others_proceed_summary');

Route::get('/ar_ledger', 'Ar_ledger_controller@index')->name('ar_ledger');
Route::post('/ar_ledger_select_report', 'Ar_ledger_controller@ar_ledger_select_report')->name('ar_ledger_select_report');
Route::post('/ar_ledger_generate_data', 'Ar_ledger_controller@ar_ledger_generate_data')->name('ar_ledger_generate_data');

Route::get('/van_selling_ledger', 'Van_selling_ledger_controller@index')->name('van_selling_ledger');
Route::post('/van_selling_ledger_generate', 'Van_selling_ledger_controller@van_selling_ledger_generate')->name('van_selling_ledger_generate');

Route::get('/van_selling_pcm', 'Van_selling_pcm_controller@index')->name('van_selling_pcm');
Route::post('/van_selling_pcm_generate_sku_per_principal', 'Van_selling_pcm_controller@van_selling_pcm_generate_sku_per_principal')->name('van_selling_pcm_generate_sku_per_principal');
Route::post('/van_selling_pcm_generate_pcm_data', 'Van_selling_pcm_controller@van_selling_pcm_generate_pcm_data')->name('van_selling_pcm_generate_pcm_data');
Route::post('/van_selling_pcm_generate_final_summary', 'Van_selling_pcm_controller@van_selling_pcm_generate_final_summary')->name('van_selling_pcm_generate_final_summary');
Route::post('/van_selling_pcm_final_summary', 'Van_selling_pcm_controller@van_selling_pcm_final_summary')->name('van_selling_pcm_final_summary');
Route::post('/van_selling_pcm_save', 'Van_selling_pcm_controller@van_selling_pcm_save')->name('van_selling_pcm_save');

Route::get('/van_selling_pcm_post', 'Van_selling_pcm_post_controller@index')->name('van_selling_pcm_post');
Route::post('/van_selling_pcm_post_generate', 'Van_selling_pcm_post_controller@van_selling_pcm_post_generate')->name('van_selling_pcm_post_generate');
Route::post('/van_selling_pcm_post_save', 'Van_selling_pcm_post_controller@van_selling_pcm_post_save')->name('van_selling_pcm_post_save');

Route::get('/van_selling_cm_report', 'Van_selling_cm_report_controller@index')->name('van_selling_cm_report');
Route::post('/van_selling_cm_report_generate', 'Van_selling_cm_report_controller@van_selling_cm_report_generate')->name('van_selling_cm_report_generate');

// Route::get('/van_selling_ar', 'Van_selling_ar_controller@index')->name('van_selling_ar');
// Route::post('/van_selling_ar_generate', 'Van_selling_ar_controller@van_selling_ar_generate')->name('van_selling_ar_generate');
// Route::post('/van_selling_ar_proceed_to_final_summary', 'Van_selling_ar_controller@van_selling_ar_proceed_to_final_summary')->name('van_selling_ar_proceed_to_final_summary');;
// Route::post('/van_selling_ar_save', 'Van_selling_ar_controller@van_selling_ar_save')->name('van_selling_ar_save');


Route::get('/van_selling_ar_ledger', 'Vs_ar_ledger_controller@index')->name('van_selling_ar_ledger');
Route::get('/van_selling_ar_ledger_adjustment', 'Vs_ar_ledger_controller@van_selling_ar_ledger_adjustment')->name('van_selling_ar_ledger_adjustment');
Route::post('/van_selling_ar_ledger_adjustments_proceed', 'Vs_ar_ledger_controller@van_selling_ar_ledger_adjustments_proceed')->name('van_selling_ar_ledger_adjustments_proceed');
Route::post('/van_selling_ar_ledger_adjustments_proceed_save', 'Vs_ar_ledger_controller@van_selling_ar_ledger_adjustments_proceed_save')->name('van_selling_ar_ledger_adjustments_proceed_save');
Route::post('/van_selling_ar_ledger_generate_data', 'Vs_ar_ledger_controller@van_selling_ar_ledger_generate_data')->name('van_selling_ar_ledger_generate_data');



Route::get('/van_selling_price_difference', 'Van_selling_price_difference_controller@index')->name('van_selling_price_difference');
Route::post('/van_selling_price_difference_generate_sku', 'Van_selling_price_difference_controller@van_selling_price_difference_generate_sku')->name('van_selling_price_difference_generate_sku');
Route::post('/van_selling_price_difference_generate', 'Van_selling_price_difference_controller@van_selling_price_difference_generate')->name('van_selling_price_difference_generate');
Route::post('/van_selling_price_difference_generate_final_summary', 'Van_selling_price_difference_controller@van_selling_price_difference_generate_final_summary')->name('van_selling_price_difference_generate_final_summary');
Route::post('/van_selling_price_difference_save', 'Van_selling_price_difference_controller@van_selling_price_difference_save')->name('van_selling_price_difference_save');


Route::get('/van_selling_charge', 'Van_selling_charge_controller@index')->name('van_selling_charge');
Route::post('/van_selling_charge_generate', 'Van_selling_charge_controller@van_selling_charge_generate')->name('van_selling_charge_generate');
Route::post('/van_selling_charge_generate_final_summary', 'Van_selling_charge_controller@van_selling_charge_generate_final_summary')->name('van_selling_charge_generate_final_summary');
Route::post('/van_selling_charge_save', 'Van_selling_charge_controller@van_selling_charge_save')->name('van_selling_charge_save');


Route::get('/van_selling_inventory_adjustments', 'Van_selling_actual_inventory_adjustments_controller@index')->name('van_selling_inventory_adjustments');
Route::post('/van_selling_inventory_adjustments_generate', 'Van_selling_actual_inventory_adjustments_controller@van_selling_inventory_adjustments_generate')->name('van_selling_inventory_adjustments_generate');
Route::post('/van_selling_inventory_adjustments_generate_final_summary', 'Van_selling_actual_inventory_adjustments_controller@van_selling_inventory_adjustments_generate_final_summary')->name('van_selling_inventory_adjustments_generate_final_summary');
Route::post('/van_selling_inventory_adjustments_save', 'Van_selling_actual_inventory_adjustments_controller@van_selling_inventory_adjustments_save')->name('van_selling_inventory_adjustments_save');
Route::post('/van_selling_inventory_adjustments_show_sku', 'Van_selling_actual_inventory_adjustments_controller@van_selling_inventory_adjustments_show_sku')->name('van_selling_inventory_adjustments_show_sku');

Route::get('/van_selling_sales_report', 'Van_selling_sales_report_controller@index')->name('van_selling_sales_report');
Route::post('/van_selling_sales_report_search_for', 'Van_selling_sales_report_controller@van_selling_sales_report_search_for')->name('van_selling_sales_report_search_for');
Route::post('/van_selling_sales_report_generate', 'Van_selling_sales_report_controller@van_selling_sales_report_generate')->name('van_selling_sales_report_generate');
Route::get('/van_selling_sales_report_generate_itemized_sales/{data}', 'Van_selling_sales_report_controller@van_selling_sales_report_generate_itemized_sales')->name('van_selling_sales_report_generate_itemized_sales');


Route::get('/van_selling_sku_price_adjustments', 'Van_selling_sku_price_adjustments_controller@index')->name('van_selling_sku_price_adjustments');
Route::post('/van_selling_sku_price_adjustments_proceed', 'Van_selling_sku_price_adjustments_controller@van_selling_sku_price_adjustments_proceed')->name('van_selling_sku_price_adjustments_proceed');
Route::post('/van_selling_sku_price_adjustments_generate', 'Van_selling_sku_price_adjustments_controller@van_selling_sku_price_adjustments_generate')->name('van_selling_sku_price_adjustments_generate');
Route::post('/van_selling_sku_price_adjustments_generate_final_summary', 'Van_selling_sku_price_adjustments_controller@van_selling_sku_price_adjustments_generate_final_summary')->name('van_selling_sku_price_adjustments_generate_final_summary');
Route::post('/van_selling_sku_price_adjustments_save', 'Van_selling_sku_price_adjustments_controller@van_selling_sku_price_adjustments_save')->name('van_selling_sku_price_adjustments_save');

Route::get('/van_selling_price_adjustments', 'Van_selling_price_adjustments_controller@index')->name('van_selling_price_adjustments');
Route::post('/van_selling_price_adjustments_save', 'Van_selling_price_adjustments_controller@van_selling_price_adjustments_save')->name('van_selling_price_adjustments_save');

Route::get('/van_selling_ns_adjustments', 'van_selling_ns_adjustments_controller@index')->name('van_selling_ns_adjustments');
Route::post('/van_selling_ns_adjustments_save', 'van_selling_ns_adjustments_controller@van_selling_ns_adjustments_save')->name('van_selling_ns_adjustments_save');


Route::get('/van_selling_other_adjustments', 'van_selling_other_adjustments_controller@index')->name('van_selling_other_adjustments');
Route::post('/van_selling_other_adjustments_save', 'van_selling_other_adjustments_controller@van_selling_other_adjustments_save')->name('van_selling_other_adjustments_save');


Route::get('/van_selling_report_date_range', 'Van_selling_report_date_range_controller@index')->name('van_selling_report_date_range');
Route::post('/van_selling_report_date_range_generate_data', 'Van_selling_report_date_range_controller@van_selling_report_date_range_generate_data')->name('van_selling_report_date_range_generate_data');
Route::get('/van_selling_report_date_range_itemized/{data}', 'Van_selling_report_date_range_controller@van_selling_report_date_range_itemized')->name('van_selling_report_date_range_itemized');
Route::post('/van_selling_report_date_range_generate_sku_movement', 'Van_selling_report_date_range_controller@van_selling_report_date_range_generate_sku_movement')->name('van_selling_report_date_range_generate_sku_movement');
Route::post('/van_selling_report_date_range_generate_clearing', 'Van_selling_report_date_range_controller@van_selling_report_date_range_generate_clearing')->name('van_selling_report_date_range_generate_clearing');
Route::post('/van_selling_report_date_range_generate_clearing_per_principal', 'Van_selling_report_date_range_controller@van_selling_report_date_range_generate_clearing_per_principal')->name('van_selling_report_date_range_generate_clearing_per_principal');
Route::post('/van_selling_report_date_range_generate_clearing_per_sku', 'Van_selling_report_date_range_controller@van_selling_report_date_range_generate_clearing_per_sku')->name('van_selling_report_date_range_generate_clearing_per_sku');
Route::post('/van_selling_report_date_range_clearing_operation_save', 'Van_selling_report_date_range_controller@van_selling_report_date_range_clearing_operation_save')->name('van_selling_report_date_range_clearing_operation_save');
Route::get('/van_selling_report_date_range_generate_specific_data/{customer_id}/{sku_id}', 'Van_selling_report_date_range_controller@van_selling_report_date_range_generate_specific_data')->name('van_selling_report_date_range_generate_specific_data');




Route::get('/van_selling_ar_adjustments', 'Van_selling_ar_adjustments_controller@index');
Route::post('/van_selling_ar_adjustments_proceed', 'Van_selling_ar_adjustments_controller@van_selling_ar_adjustments_proceed')->name('van_selling_ar_adjustments_proceed');
Route::post('/van_selling_ar_adjustments_save', 'Van_selling_ar_adjustments_controller@van_selling_ar_adjustments_save')->name('van_selling_ar_adjustments_save');

Route::get('/van_selling_transfer_inventory', 'Van_selling_transfer_inventory_controller@index');
Route::post('/van_selling_transfer_inventory_proceed', 'Van_selling_transfer_inventory_controller@van_selling_transfer_inventory_proceed')->name('van_selling_transfer_inventory_proceed');
Route::post('/van_selling_transfer_inventory_save', 'Van_selling_transfer_inventory_controller@van_selling_transfer_inventory_save')->name('van_selling_transfer_inventory_save');

Route::get('/van_selling_pcm_report', 'Van_selling_pcm_report_controller@index');
Route::post('/van_selling_pcm_report_generate_data', 'Van_selling_pcm_report_controller@van_selling_pcm_report_generate_data')->name('van_selling_pcm_report_generate_data');

Route::get('/van_selling_inventory_adjustments_report', 'Van_selling_inventory_adjustments_report_controller@index');
Route::post('/van_selling_inventory_adjustments_report_generate_data', 'Van_selling_inventory_adjustments_report_controller@van_selling_inventory_adjustments_report_generate_data')->name('van_selling_inventory_adjustments_report_generate_data');

Route::post('/van_selling_ledger_delete_agent_data', 'Van_selling_ledger_controller@van_selling_ledger_delete_agent_data')->name('van_selling_ledger_delete_agent_data');

Route::get('/van_selling_dashboard', 'Van_selling_dashboard_controller@index');
Route::post('/search_top_10_agent_sales_per_month', 'Van_selling_dashboard_controller@search_top_10_agent_sales_per_month')->name('search_top_10_agent_sales_per_month');
Route::post('/top_10_highest_store_sales', 'Van_selling_dashboard_controller@top_10_highest_store_sales')->name('top_10_highest_store_sales');
Route::post('/top_10_sku', 'Van_selling_dashboard_controller@top_10_sku')->name('top_10_sku');
Route::post('/sales_per_year', 'Van_selling_dashboard_controller@sales_per_year')->name('sales_per_year');
Route::post('/agent_monthly_performance', 'Van_selling_dashboard_controller@agent_monthly_performance')->name('agent_monthly_performance');
Route::post('/principal_monthly_sales', 'Van_selling_dashboard_controller@principal_monthly_sales')->name('principal_monthly_sales');
Route::post('/principal_yearly_sales', 'Van_selling_dashboard_controller@principal_yearly_sales')->name('principal_yearly_sales');
Route::post('/location_sales', 'Van_selling_dashboard_controller@location_sales')->name('location_sales');



Route::get('/customer_upload', 'Customer_upload_controller@index');
Route::post('/customer_upload_process', 'Customer_upload_controller@customer_upload_process')->name('customer_upload_process');

Route::get('/customer_export', 'Customer_upload_controller@customer_export')->name('customer_export');
Route::post('/customer_agent_export', 'Customer_upload_controller@customer_agent_export')->name('customer_agent_export');



Route::get('/sales_invoice_control', 'Sales_invoice_control_controller@index');
Route::post('/sales_invoice_control_proceed', 'Sales_invoice_control_controller@sales_invoice_control_proceed')->name('sales_invoice_control_proceed');


Route::get('/sku_sub_category', 'Sku_sub_category_controller@index');







Route::get('/dr_status_list', 'Logistics_controller@index');
Route::get('/dr_update_status', 'Logistics_controller@dr_update_status')->name('dr_update_status');
Route::post('/dr_update_status_generate', 'Logistics_controller@dr_update_status_generate')->name('dr_update_status_generate');
Route::post('/dr_update_status_generate_final_summary', 'Logistics_controller@dr_update_status_generate_final_summary')->name('dr_update_status_generate_final_summary');
Route::post('/dr_update_status_save', 'Logistics_controller@dr_update_status_save')->name('dr_update_status_save');
Route::get('/dr_for_delivery', 'Logistics_controller@dr_for_delivery')->name('dr_for_delivery');
Route::post('/dr_for_delivery_proceed', 'Logistics_controller@dr_for_delivery_proceed')->name('dr_for_delivery_proceed');
Route::post('/dr_for_delivery_proceed_to_final_summary', 'Logistics_controller@dr_for_delivery_proceed_to_final_summary')->name('dr_for_delivery_proceed_to_final_summary');
Route::post('/dr_for_delivery_saved', 'Logistics_controller@dr_for_delivery_saved')->name('dr_for_delivery_saved');
Route::get('/truck_and_sales_invoice', 'Logistics_controller@truck_and_sales_invoice')->name('truck_and_sales_invoice');
Route::post('/truck_and_sales_invoice_generate_data', 'Logistics_controller@truck_and_sales_invoice_generate_data')->name('truck_and_sales_invoice_generate_data');
Route::get('/truck_departure_and_arrival', 'Logistics_controller@truck_departure_and_arrival')->name('truck_departure_and_arrival');
Route::post('/truck_departure_and_arrival_generate', 'Logistics_controller@truck_departure_and_arrival_generate')->name('truck_departure_and_arrival_generate');
Route::post('/truck_departure_and_arrival_save', 'Logistics_controller@truck_departure_and_arrival_save')->name('truck_departure_and_arrival_save');



Route::get('/audit_approved_customer', 'Audit_approved_controller@index');
Route::post('/audit_approved_customer_process', 'Audit_approved_controller@audit_approved_customer_process')->name('audit_approved_customer_process');



Route::get('/vs_upload_and_export_customer', 'Van_selling_upload_and_export_customer_controller@vs_upload_and_export_customer');
Route::post('/vs_upload_and_export_proceed', 'Van_selling_upload_and_export_customer_controller@vs_upload_and_export_proceed')->name('vs_upload_and_export_proceed');
Route::post('/vs_upload_and_export_proceed_upload', 'Van_selling_upload_and_export_customer_controller@vs_upload_and_export_proceed_upload')->name('vs_upload_and_export_proceed_upload');




Route::get('/van_selling_import_os', 'Van_selling_os_controller@index');
Route::post('/vs_import_os_process', 'Van_selling_os_controller@vs_import_os_process')->name('vs_import_os_process');
Route::get('/van_selling_os_report', 'Van_selling_os_controller@van_selling_os_report')->name('van_selling_os_report');
Route::post('/van_selling_os_report_generate_data', 'Van_selling_os_controller@van_selling_os_report_generate_data')->name('van_selling_os_report_generate_data');



Route::get('/van_selling_import_calls', 'Van_selling_calls_controller@index');
Route::post('/vs_import_calls_process', 'Van_selling_calls_controller@vs_import_calls_process')->name('vs_import_calls_process');
Route::get('/van_selling_calls_report', 'Van_selling_calls_controller@van_selling_calls_report')->name('van_selling_calls_report');
Route::post('/van_selling_calls_report_generate_data', 'Van_selling_calls_controller@van_selling_calls_report_generate_data')->name('van_selling_calls_report_generate_data');



Route::get('/customer_upload_check', 'Customer_upload_check_controller@index')->name('customer_upload_check');
Route::post('/customer_upload_check_process', 'Customer_upload_check_controller@customer_upload_check_process')->name('customer_upload_check_process');

Route::get('/invoice_out', 'Invoice_out_controller@index')->name('invoice_out');
Route::post('/invoice_out_proceed', 'Invoice_out_controller@invoice_out_proceed')->name('invoice_out_proceed');
Route::post('/invoice_out_final_summary', 'Invoice_out_controller@invoice_out_final_summary')->name('invoice_out_final_summary');
Route::post('/invoice_out_very_final_summary', 'Invoice_out_controller@invoice_out_very_final_summary')->name('invoice_out_very_final_summary');
Route::post('/invoice_out_saved', 'Invoice_out_controller@invoice_out_saved')->name('invoice_out_saved');
Route::post('/invoice_out_van_final_summary', 'Invoice_out_controller@invoice_out_van_final_summary')->name('invoice_out_van_final_summary');
Route::post('/invoice_out_van_saved', 'Invoice_out_controller@invoice_out_van_saved')->name('invoice_out_van_saved');
Route::post('/invoice_out_sales_invoice_final_summary', 'Invoice_out_controller@invoice_out_sales_invoice_final_summary')->name('invoice_out_sales_invoice_final_summary');
Route::post('/invoice_out_sales_invoice_saved', 'Invoice_out_controller@invoice_out_sales_invoice_saved')->name('invoice_out_sales_invoice_saved');




Route::get('/disbursement', 'Disbursement_controller@index')->name('disbursement');
Route::post('/disbursement_show_selection', 'Disbursement_controller@disbursement_show_selection')->name('disbursement_show_selection');
Route::post('/disbursement_proceed', 'Disbursement_controller@disbursement_proceed')->name('disbursement_proceed');
Route::post('/disbursement_final_summary', 'Disbursement_controller@disbursement_final_summary')->name('disbursement_final_summary');
Route::post('/disbursement_saved', 'Disbursement_controller@disbursement_saved')->name('disbursement_saved');

Route::post('/disbursement_show_po_rr_payable', 'Disbursement_controller@disbursement_show_po_rr_payable')->name('disbursement_show_po_rr_payable');




Route::get('/disbursement_report', 'Disbursement_report_controller@index')->name('disbursement_report');
Route::post('/disbursement_report_show_data', 'Disbursement_report_controller@disbursement_report_show_data')->name('disbursement_report_show_data');


Route::get('/upload_raw_data', 'Upload_raw_data_controller@index')->name('upload_raw_data');
Route::post('/upload_raw_data_saved', 'Upload_raw_data_controller@upload_raw_data_saved')->name('upload_raw_data_saved');


Route::get('/inventory_adjustments', 'Inventory_adjustments_controller@index')->name('inventory_adjustments');
Route::post('/inventory_adjustments_proceed', 'Inventory_adjustments_controller@inventory_adjustments_proceed')->name('inventory_adjustments_proceed');
Route::post('/inventory_adjustments_proceed_to_final_summary', 'Inventory_adjustments_controller@inventory_adjustments_proceed_to_final_summary')->name('inventory_adjustments_proceed_to_final_summary');
Route::post('/inventory_adjustments_saved', 'Inventory_adjustments_controller@inventory_adjustments_saved')->name('inventory_adjustments_saved');



Route::get('/warehouse_releasing', 'Releasing_controller@index')->name('warehouse_releasing');
Route::post('/warehouse_proceed', 'Releasing_controller@warehouse_proceed')->name('warehouse_proceed');
Route::post('/warehouse_final_summary', 'Releasing_controller@warehouse_final_summary')->name('warehouse_final_summary');
Route::post('/warehouse_saved', 'Releasing_controller@warehouse_saved')->name('warehouse_saved');



Route::get('/warehouse_bo', 'Warehouse_rgs_controller@index')->name('warehouse_rgs');
Route::post('/warehouse_rgs_proceed', 'Warehouse_rgs_controller@warehouse_rgs_proceed')->name('warehouse_rgs_proceed');
Route::post('/warehouse_rgs_final_summary', 'Warehouse_rgs_controller@warehouse_rgs_final_summary')->name('warehouse_rgs_final_summary');
Route::post('/warehouse_rgs_saved', 'Warehouse_rgs_controller@warehouse_rgs_saved')->name('warehouse_rgs_saved');

Route::get('/warehouse_bo', 'Warehouse_bo_controller@index')->name('warehouse_bo');
Route::post('/warehouse_bo_proceed', 'Warehouse_bo_controller@warehouse_bo_proceed')->name('warehouse_bo_proceed');
Route::post('/warehouse_bo_final_summary', 'Warehouse_bo_controller@warehouse_bo_final_summary')->name('warehouse_bo_final_summary');
Route::post('/warehouse_bo_saved', 'Warehouse_bo_controller@warehouse_bo_saved')->name('warehouse_bo_saved');


Route::get('/warehouse_rgs_report', 'Warehouse_rgs_report_controller@index')->name('warehouse_rgs_report');
Route::post('/warehouse_rgs_report_proceed', 'Warehouse_rgs_report_controller@warehouse_rgs_report_proceed')->name('warehouse_rgs_report_proceed');

Route::get('/warehouse_bo_report', 'Warehouse_bo_report_controller@index')->name('warehouse_bo_report');
Route::post('/warehouse_bo_report_proceed', 'Warehouse_bo_report_controller@warehouse_bo_report_proceed')->name('warehouse_bo_report_proceed');




Route::get('/booking_pcm', 'Booking_pcm_controller@index')->name('booking_pcm');

Route::post('/booking_pcm_show_invoice', 'Booking_pcm_controller@booking_pcm_show_invoice')->name('booking_pcm_show_invoice');
Route::post('/booking_pcm_proceed', 'Booking_pcm_controller@booking_pcm_proceed')->name('booking_pcm_proceed');
Route::post('/booking_pcm_proceed_final_summary', 'Booking_pcm_controller@booking_pcm_proceed_final_summary')->name('booking_pcm_proceed_final_summary');
Route::post('/booking_pcm_save', 'Booking_pcm_controller@booking_pcm_save')->name('booking_pcm_save');





Route::get('/warehouse_pcm', 'Warehouse_pcm_controller@index')->name('warehouse_pcm');
Route::post('/warehouse_pcm_proceed', 'Warehouse_pcm_controller@warehouse_pcm_proceed')->name('warehouse_pcm_proceed');
Route::post('/warehouse_pcm_final_summary', 'Warehouse_pcm_controller@warehouse_pcm_final_summary')->name('warehouse_pcm_final_summary');
Route::post('/warehouse_pcm_save', 'Warehouse_pcm_controller@warehouse_pcm_save')->name('warehouse_pcm_save');



Route::get('/sku_withdrawal', 'Sku_withdrawal_controller@index')->name('sku_withdrawal');
Route::post('/sku_withdrawal_proceed', 'Sku_withdrawal_controller@sku_withdrawal_proceed')->name('sku_withdrawal_proceed');
Route::post('/sku_withdrawal_final_summary', 'Sku_withdrawal_controller@sku_withdrawal_final_summary')->name('sku_withdrawal_final_summary');
Route::post('/sku_withdrawal_very_final_summary', 'Sku_withdrawal_controller@sku_withdrawal_very_final_summary')->name('sku_withdrawal_very_final_summary');
Route::post('/sku_withdrawal_save', 'Sku_withdrawal_controller@sku_withdrawal_save')->name('sku_withdrawal_save');



Route::get('/van_selling_customer_list', 'Van_selling_customer_list_controller@index')->name('van_selling_customer_list');
Route::post('/van_selling_customer_list_show_data', 'Van_selling_customer_list_controller@van_selling_customer_list_show_data')->name('van_selling_customer_list_show_data');
Route::get('/van_selling_customer_list_show_map/{location_id}', 'Van_selling_customer_list_controller@van_selling_customer_list_show_map')->name('van_selling_customer_list_show_map');





Route::get('/booking_pcm_upload', 'Booking_pcm_upload_controller@index')->name('booking_pcm_upload');
Route::post('/booking_pcm_upload_process', 'Booking_pcm_upload_controller@booking_pcm_upload_process')->name('booking_pcm_upload_process');
Route::post('/booking_pcm_upload_final_process', 'Booking_pcm_upload_controller@booking_pcm_upload_final_process')->name('booking_pcm_upload_final_process');

Route::get('/truck_register', 'Truck_controller@index');
Route::post('/truck_register_save', 'Truck_controller@truck_register_save')->name('truck_register_save');

Route::get('/truck_load', 'Truck_load_controller@index');
Route::post('/truck_load_proceed', 'Truck_load_controller@truck_load_proceed')->name('truck_load_proceed');
Route::post('/truck_load_generated_invoices', 'Truck_load_controller@truck_load_generated_invoices')->name('truck_load_generated_invoices');
Route::post('/truck_load_generated_invoices_data', 'Truck_load_controller@truck_load_generated_invoices_data')->name('truck_load_generated_invoices_data');
Route::post('/truck_load_generated_final_summary_invoices_data', 'Truck_load_controller@truck_load_generated_final_summary_invoices_data')->name('truck_load_generated_final_summary_invoices_data');
Route::post('/truck_load_generated_final_summary_invoices_remove_data', 'Truck_load_controller@truck_load_generated_final_summary_invoices_remove_data')->name('truck_load_generated_final_summary_invoices_remove_data');
Route::post('/truck_load_generated_very_final_summary_invoices_data', 'Truck_load_controller@truck_load_generated_very_final_summary_invoices_data')->name('truck_load_generated_very_final_summary_invoices_data');
Route::post('/truck_load_save', 'Truck_load_controller@truck_load_save')->name('truck_load_save');

Route::get('/truck_load_list', 'Truck_load_list_controller@index');
Route::post('/truck_load_lost_update_loading_date', 'Truck_load_list_controller@truck_load_lost_update_loading_date')->name('truck_load_lost_update_loading_date');
Route::post('/truck_load_lost_update_departure_date', 'Truck_load_list_controller@truck_load_lost_update_departure_date')->name('truck_load_lost_update_departure_date');
Route::post('/truck_load_lost_update_arrival_date', 'Truck_load_list_controller@truck_load_lost_update_arrival_date')->name('truck_load_lost_update_arrival_date');
Route::post('/truck_load_lost_update_sg_departure_noted_by', 'Truck_load_list_controller@truck_load_lost_update_sg_departure_noted_by')->name('truck_load_lost_update_sg_departure_noted_by');
Route::post('/truck_load_lost_update_sg_arrival_noted_by', 'Truck_load_list_controller@truck_load_lost_update_sg_arrival_noted_by')->name('truck_load_lost_update_sg_arrival_noted_by');
Route::post('/truck_load_lost_update_fuel_given', 'Truck_load_list_controller@truck_load_lost_update_fuel_given')->name('truck_load_lost_update_fuel_given');
Route::post('/truck_load_lost_update_remarks', 'Truck_load_list_controller@truck_load_lost_update_remarks')->name('truck_load_lost_update_remarks');
Route::post('/truck_load_lost_update_total_expense', 'Truck_load_list_controller@truck_load_lost_update_total_expense')->name('truck_load_lost_update_total_expense');
Route::get('/truck_load_list_print/{id}', 'Truck_load_list_controller@truck_load_list_print')->name('truck_load_list_print');
Route::get('/truck_load_list_driver_print/{id}', 'Truck_load_list_controller@truck_load_list_driver_print')->name('truck_load_list_driver_print');

Route::post('/truck_logistics_details_show', 'Truck_load_list_controller@truck_logistics_details_show')->name('truck_logistics_details_show');
Route::post('/truck_load_list_update_data', 'Truck_load_list_controller@truck_load_list_update_data')->name('truck_load_list_update_data');
Route::post('/truck_load_list_update_delivery_status', 'Truck_load_list_controller@truck_load_list_update_delivery_status')->name('truck_load_list_update_delivery_status');



Route::get('/truck_load_report', 'Truck_load_report_controller@index');
Route::post('/truck_load_report_show', 'truck_load_report_controller@truck_load_report_show')->name('truck_load_report_show');





Route::get('/ap_subsidiary_ledger', 'Ap_ledger_controller@index');
Route::post('/ap_ledger_subsidiary_ledger_show_report_list', 'Ap_ledger_controller@ap_ledger_subsidiary_ledger_show_report_list')->name('ap_ledger_subsidiary_ledger_show_report_list');

Route::get('/ap_general_ledger', 'Ap_ledger_controller@ap_general_ledger');
Route::post('/ap_ledger_general_ledger_show_report_list', 'Ap_ledger_controller@ap_ledger_general_ledger_show_report_list')->name('ap_ledger_general_ledger_show_report_list');

Route::get('/ap_ledger_subsidiary_cut_off/{principal_id}', 'Ap_ledger_controller@ap_ledger_subsidiary_cut_off')->name('ap_ledger_subsidiary_cut_off');
Route::post('/ap_ledger_subsidiary_cut_off_save', 'Ap_ledger_controller@ap_ledger_subsidiary_cut_off_save')->name('ap_ledger_subsidiary_cut_off_save');
Route::post('/ap_ledger_general_ledger_show_search_type', 'Ap_ledger_controller@ap_ledger_general_ledger_show_search_type')->name('ap_ledger_general_ledger_show_search_type');




Route::get('/van_selling_reports_and_dashboard', 'Van_selling_reports_and_dashboard_controller@index');
Route::get('/van_selling_reports_and_dashboard_productive_calls', 'Van_selling_reports_and_dashboard_controller@van_selling_reports_and_dashboard_productive_calls')->name('van_selling_reports_and_dashboard_productive_calls');
Route::post('/van_selling_reports_and_dashboard_productive_calls_generate', 'Van_selling_reports_and_dashboard_controller@van_selling_reports_and_dashboard_productive_calls_generate')->name('van_selling_reports_and_dashboard_productive_calls_generate');



Route::get('/van_selling_export_sales_and_os', 'Van_selling_export_sales_and_os_controller@index');
Route::post('/van_selling_export_sales_and_os_generate', 'Van_selling_export_sales_and_os_controller@van_selling_export_sales_and_os_generate')->name('van_selling_export_sales_and_os_generate');


Route::get('/customer_ledger', 'Customer_ledger_controller@index');
Route::post('/customer_ledger_generate', 'Customer_ledger_controller@customer_ledger_generate')->name('customer_ledger_generate');

Route::get('/collection', 'Collection_controller@index');
Route::post('/collection_show_customers', 'Collection_controller@collection_show_customers')->name('collection_show_customers');
Route::post('/collection_proceed', 'Collection_controller@collection_proceed')->name('collection_proceed');
Route::post('/collection_final_summary', 'Collection_controller@collection_final_summary')->name('collection_final_summary');
Route::post('/collection_saved', 'Collection_controller@collection_saved')->name('collection_saved');
Route::get('/collection_sales_invoice_show_copy/{id}', 'Collection_controller@collection_sales_invoice_show_copy')->name('collection_sales_invoice_show_copy');
Route::post('/collection_sales_invoice_show_copy', 'Collection_controller@collection_sales_invoice_show_copy')->name('collection_sales_invoice_show_copy');
Route::post('/collection_post_bo_final_summary', 'Collection_controller@collection_post_bo_final_summary')->name('collection_post_bo_final_summary');
Route::post('/collection_post_bo_save', 'Collection_controller@collection_post_bo_save')->name('collection_post_bo_save');
Route::post('/collection_post_rgs_final_summary', 'Collection_controller@collection_post_rgs_final_summary')->name('collection_post_rgs_final_summary');
Route::post('/collection_post_rgs_save', 'Collection_controller@collection_post_rgs_save')->name('collection_post_rgs_save');







Route::get('/post_credit_memo', 'Post_credit_memo_controller@index');
Route::post('/post_credit_memo_proceed', 'Post_credit_memo_controller@post_credit_memo_proceed')->name('post_credit_memo_proceed');
Route::post('/post_credit_generate_final_summary', 'Post_credit_memo_controller@post_credit_generate_final_summary')->name('post_credit_generate_final_summary');
Route::post('/post_credit_memo_save', 'Post_credit_memo_controller@post_credit_memo_save')->name('post_credit_memo_save');


Route::get('/agent_ledger', 'Agent_ledger_controller@index');
Route::post('/agent_ledger_generate', 'Agent_ledger_controller@agent_ledger_generate')->name('agent_ledger_generate');

Route::get('/ewt_rate', 'Ewt_rate_controller@index');
Route::post('/ewt_rate_process', 'Ewt_rate_controller@ewt_rate_process')->name('ewt_rate_process');


Route::get('/chart_of_accounts', 'Chart_of_accounts_controller@index');
Route::post('/chart_of_accounts_transaction', 'Chart_of_accounts_controller@chart_of_accounts_transaction')->name('chart_of_accounts_transaction');
Route::post('/chart_of_accounts_transaction_proceed', 'Chart_of_accounts_controller@chart_of_accounts_transaction_proceed')->name('chart_of_accounts_transaction_proceed');
Route::post('/chart_of_accounts_final_summary', 'Chart_of_accounts_controller@chart_of_accounts_final_summary')->name('chart_of_accounts_final_summary');
Route::post('/chart_of_accounts_save', 'Chart_of_accounts_controller@chart_of_accounts_save')->name('chart_of_accounts_save');

Route::get('/general_ledger', 'General_ledger_controller@index');
Route::post('/general_ledger_generate', 'General_ledger_controller@general_ledger_generate')->name('general_ledger_generate');
