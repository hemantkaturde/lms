<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/*********** COMMAN ROUTES******************/
$route['getstates'] = "comman/getstates";
$route['getcities'] = "comman/getcities";

/*********** USER DEFINED ROUTES *******************/
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'admin';
$route['logout'] = 'login/logout';

/*********** ADMIN CONTROLLER ROUTES *******************/
$route['userListing'] = 'admin/userListing';
$route['fetchUsers'] = 'admin/fetchUsers';
$route['createUser'] = 'admin/createUser';
$route['updateUser/(:num)'] = 'admin/updateUser/$1';
$route['deleteUser'] = "admin/deleteUser";
$route['staffListing'] = 'admin/staffListing';
$route['fetchStaff'] = 'admin/fetchStaff';

/*********** ROLE CONTROLLER ROUTES *******************/
$route['roleListing'] = "role/roleListing";
$route['addRole'] = "role/addRole";
$route['addNewRole'] = "role/addNewRole";
$route['fetchrolelisting'] = "role/fetchrolelisting";
$route['createRole'] = "role/createRole";
$route['editRole/(:num)'] = "role/editRole/$1";
$route['editRolerecord/(:num)'] = "role/editRolerecord/$1";
$route['deleteRole'] = "role/deleteRole";

/*********** Masters CONTROLLER ROUTES *******************/
$route['coursetypelisting'] = "course/courseTypeListing";
$route['fetchcoursetype'] = "course/fetchcoursetype";
$route['createcoursetype'] = "course/createcoursetype";
$route['deletecoursetype'] = "course/deletecoursetype";
$route['get_signle_coursetypeData'] = "course/get_signle_coursetypeData";
$route['updatcoursetype/(:num)'] = "course/updatcoursetype/$1";

/*********** COURSE CONTROLLER ROUTES *******************/
$route['courselisting'] = "course/courseListing";
$route['fetchcourse'] = "course/fetchcourse";
$route['createcourse'] = "course/createcourse";
$route['delete_course'] = "course/delete_course";
$route['updatecourse/(:num)'] = "course/updatecourse/$1";
$route['courseLinks/(:num)'] = "course/courseLinks/$1";
// $route['deleteCourse/(:any)'] = "course/deleteCourse/$1";
$route['deleteCourseLink/(:any)'] = "course/deleteCourseLink/$1";

/*********** COURSE CONTROLLER ROUTES *******************/
$route['studentListing'] = "student/studentListing";
$route['deleteStudent/(:any)'] = "student/deleteStudent/$1";

/*********** ENQUIRY CONTROLLER ROUTES *******************/
$route['enquirylisting'] = "enquiry/enquirylisting";
$route['fetchenquiry'] = "enquiry/fetchenquiry";
$route['createenquiry'] = "enquiry/createenquiry";
$route['editenquiry/(:any)'] = "enquiry/editenquiry/$1";
$route['updateenquiry/(:any)'] = "enquiry/updateenquiry/$1";
$route['deleteEnquiry'] = "enquiry/deleteEnquiry";
$route['sendEnquiryLink'] = "enquiry/sendEnquiryLink";
$route['sendPaymentLink'] = "enquiry/sendPaymentLink";
$route['pay/(:any)'] = "enquiry/pay/$1";
$route['razorpaysuccess'] = "enquiry/razorpaysuccess";
$route['razorthankyou/(:any)'] = "enquiry/razorthankyou/$1";
$route['paymentrecipt/(:any)'] = "enquiry/paymentrecipt";
$route['new-registration-student/(:any)'] = "enquiry/newregistrationstudent";
$route['newregistrationstudentdetails'] = "enquiry/newregistrationstudentdetails";
$route['followup/(:any)'] = "enquiry/followup/$1";
//$route['deleteEnquiry/(:any)'] = "enquiry/deleteEnquiry/$1";

/*********** ADMISSION CONTROLLER ROUTES *******************/
$route['admissionListing'] = "admission/admissionListing";
$route['fetchadmissions'] = "admission/fetchadmissions";
$route['deleteAdmission'] = "admission/deleteAdmission";
$route['viewadmissiondetails/(:any)'] = "admission/viewadmissiondetails/$1";

/*********** Email Setting CONTROLLER ROUTES *******************/
// Template
$route['emailtemplateListing'] = "emailSetting/emailtemplateListing";
$route['deleteTemplate/(:any)'] = "emailSetting/deleteTemplate/$1";

// SMTP
$route['emailsmtpListing'] = "emailSetting/emailsmtpListing";
$route['deleteSmtp/(:any)'] = "emailSetting/deleteSmtp/$1";


