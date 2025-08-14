<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'admin/login';
//$route['default_controller'] = 'admin/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Admin panel route
$route['admin'] = 'admin/login';
$route['admin_login'] = 'admin/admin_login';
$route['logout'] = 'admin/logout';
$route['forget-password'] = 'admin/forget_password';

$route['dashboard'] = 'admin/dashboard';


$route['student'] 	       = 'admin/student';
$route['student-add']      = 'admin/student_add';
$route['student-submit']   = 'admin/student_submit';

$route['api/login'] = 'api/login';
$route['api/logout'] = 'api/logout';
$route['api/add_account'] = 'api/add_account';
$route['api/get_accounts_by_employee_id'] = 'api/get_accounts_by_employee_id';
$route['api/get_members_by_employee_id'] = 'api/get_members_by_employee_id';
$route['api/add-loan'] = 'api/addLoan';
$route['api/getAllLoansByEmployee'] = 'api/getAllLoansByEmployee';
$route['api/savingReturn'] = 'api/savingReturn';
$route['api/getAllPendingSavingReturnByEmployeeId'] = 'api/getAllPendingSavingReturnByEmployeeId';
$route['api/getAllApprovedSavingReturnByEmployeeId'] = 'api/getAllApprovedSavingReturnByEmployeeId';
$route['api/addSSPAccount'] = 'api/addSSPAccount';
$route['api/getSSPAccountByEmployeeId'] = 'api/getSSPAccountByEmployeeId';
$route['api/addSSPCollection'] = 'api/addSSPCollection';
$route['api/getSSPCollectionByEmployeeId'] = 'api/getSSPCollectionByEmployeeId';
$route['api/addSSPReturnCollection'] = 'api/addSSPReturnCollection';
$route['api/getSSPReturnCollectionsByEmployeeId'] = 'api/getSSPReturnCollectionsByEmployeeId';
$route['api/getSSPApprovedReturnCollectionsByEmployeeId'] = 'api/getSSPApprovedReturnCollectionsByEmployeeId';
$route['api/getAccountAndLoanDetails'] = 'api/getAccountAndLoanDetails';
$route['api/getAccountAndLoanDetailsByDate'] = 'api/getAccountAndLoanDetailsByDate';
$route['api/collection_confirm_single'] = 'api/collection_confirm_single';
$route['api/collection_confirm_previous'] = 'api/collection_confirm_previous';
$route['api/get_collection_by_member_and_date'] = 'api/get_collection_by_member_and_date';
$route['api/get_collection_summary_by_employee_and_date'] = 'api/get_collection_summary_by_employee_and_date';
$route['api/get_employee_report'] = 'api/get_employee_report';
$route['api/get_daily_collection_report'] = 'api/get_daily_collection_report';
$route['api/get_daily_collection_report_all_members'] = 'api/get_daily_collection_report_all_members';








