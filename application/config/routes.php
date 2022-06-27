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
$route['addNewUser'] = 'admin/addNewUser';
$route['editOld'] = "admin/editOld";
$route['editOld/(:num)'] = "admin/editOld/$1";
$route['deleteUser/(:any)'] = "admin/deleteUser/$1";

$route['staffListing'] = 'admin/staffListing';

/*********** ROLE CONTROLLER ROUTES *******************/
$route['roleListing'] = "role/roleListing";
$route['addRole'] = "role/addRole";
$route['addNewRole'] = "role/addNewRole";
$route['editRole/(:num)'] = "role/editRole/$1";
$route['editRoleRecord/(:any)'] = "role/editRoleRecord/$1";
$route['deleteRole/(:any)'] = "role/deleteRole/$1";


/*********** Masters CONTROLLER ROUTES *******************/
$route['coursetypelisting'] = "course/courseTypeListing";
$route['deleteCourseType/(:any)'] = "course/deleteCourseType/$1";

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
$route['updateenquiry/(:any)'] = "enquiry/updateenquiry/$1";

$route['deleteEnquiry'] = "enquiry/deleteEnquiry";
// $route['deleteEnquiry/(:any)'] = "enquiry/deleteEnquiry/$1";

/*********** ADMISSION CONTROLLER ROUTES *******************/
$route['admissionListing'] = "admission/admissionListing";
$route['deleteAdmission/(:any)'] = "admission/deleteAdmission/$1";
/*********** Email Setting CONTROLLER ROUTES *******************/
// Template
$route['emailtemplateListing'] = "emailSetting/emailtemplateListing";
$route['deleteTemplate/(:any)'] = "emailSetting/deleteTemplate/$1";

// SMTP
$route['emailsmtpListing'] = "emailSetting/emailsmtpListing";
$route['deleteSmtp/(:any)'] = "emailSetting/deleteSmtp/$1";