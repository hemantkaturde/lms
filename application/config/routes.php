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
$route['addsyllabus/(:any)'] = "course/addsyllabus/$1";
$route['fetchallcoursesyllabus/(:any)'] = "course/fetchallcoursesyllabus/$1";
$route['uploadCoursesayllabus'] = "course/uploadCoursesayllabus";
$route['deletecourseSyllbus'] = "course/deletecourseSyllbus";
// $route['deleteCourse/(:any)'] = "course/deleteCourse/$1";
$route['addcourseListing/(:num)'] = "course/addcourseListing/$1";
$route['deleteCourseLink/(:any)'] = "course/deleteCourseLink/$1";
$route['addchapters/(:any)'] = "course/addchapters/$1";
$route['fetchCourseAttchemant/(:any)'] = "course/fetchCourseAttchemant/$1";
$route['savecoursetopicAttahcment'] = "course/savecoursetopicAttahcment";
$route['deleteCourseTopics'] = "course/deleteCourseTopics";
$route['updatecourseTopics'] = "course/updatecourseTopics";
$route['topicattachmentListing?(:any)'] = "course/topicattachmentListing/$1";
$route['viewalltopicdocuments?(:any)'] = "course/viewalltopicdocuments/$1";
$route['timetableListing/(:any)'] = "course/timetableListing/$1";
$route['savenewtimetable'] = "course/savenewtimetable";
$route['fetchTimetable/(:any)'] = "course/fetchTimetable/$1";
// $route['fetchTopicDocument/(:any)'] = "course/fetchTopicDocument/$1";
$route['fetchTopicDocument?(:any)'] = "course/fetchTopicDocument/$1";
$route['deleteTopicDocuments'] = "course/deleteTopicDocuments";
$route['deletetopictimetable'] = "course/deletetopictimetable";
$route['timetablemaster'] = "course/timetablemaster";
$route['viewtimetablelisting?(:any)'] = "course/viewtimetablelisting/$1";
$route['fetchTopicTimetableListing?(:any)'] = "course/fetchTopicTimetableListing/$1";
$route['edittimetablerecord?(:any)'] = "course/edittimetablerecord/$1";
$route['addtopiclinksforonlineattendant?(:any)'] = "course/addtopiclinksforonlineattendant/$1";
$route['fetchtopicmeetinglink?(:any)'] = "course/fetchtopicmeetinglink/$1";
$route['delete_topic_meeting_link'] = "course/delete_topic_meeting_link";
$route['savecoursetopicMeetingLinks'] = "course/savecoursetopicMeetingLinks";
$route['addbackuptrainer?(:any)'] = "course/addbackuptrainer/$1";
$route['addbackuptrainerdata'] = "course/addbackuptrainerdata";
/************ EXAMINATION MASTER ***********************/
$route['examinationlisting'] = "examination/examinationlisting";
$route['fetchExaminationListing'] = "examination/fetchExaminationListing";
$route['createExamination'] = "examination/createExamination";
$route['viewquestionpaper/(:any)'] = "examination/viewquestionpaper/$1";
$route['updateExamination/(:any)'] = "examination/updateExamination/$1";
$route['delete_examination'] = "examination/delete_examination";
$route['uploadquestionpaper'] = "examination/uploadquestionpaper";
/*********** COURSE CONTROLLER ROUTES *******************/
$route['studentListing'] = "student/studentListing";
$route['deletestudent'] = "student/deleteStudent";
$route['fetchstudentlist'] = "student/fetchstudentlist";
$route['editstudent/(:num)'] = "student/editstudent/$1";
$route['studentbookissued/(:num)'] = "student/studentbookissued/$1";
$route['update_book_issued'] = "student/update_book_issued";
/*********** ENQUIRY CONTROLLER ROUTES *******************/
$route['enquirylisting'] = "enquiry/enquirylisting";
$route['fetchenquiry'] = "enquiry/fetchenquiry";
$route['createenquiry'] = "enquiry/createenquiry";
$route['editenquiry/(:any)'] = "enquiry/editenquiry/$1";
$route['updateenquiry/(:any)'] = "enquiry/updateenquiry/$1";
$route['deleteEnquiry'] = "enquiry/deleteEnquiry";
$route['sendEnquiryLink'] = "enquiry/sendEnquiryLink";
$route['sendPaymentLink'] = "enquiry/sendPaymentLink";
$route['sendBrochureLink'] = "enquiry/sendBrochureLink";
$route['pay/(:any)'] = "enquiry/pay/$1";
$route['razorpaysuccess'] = "enquiry/razorpaysuccess";
$route['razorthankyou/(:any)'] = "enquiry/razorthankyou/$1";
$route['paymentrecipt/(:any)'] = "enquiry/paymentrecipt/$1";
$route['new-registration-student/(:any)'] = "enquiry/newregistrationstudent";
$route['newregistrationstudentdetails'] = "enquiry/newregistrationstudentdetails";
$route['followup/(:any)'] = "enquiry/followup/$1";
$route['createFollowup'] = "enquiry/createFollowup";
$route['fetchEnquiryFollowup/(:any)'] = "enquiry/fetchEnquiryFollowup/$1";
$route['delete_enquiry_followup'] = "enquiry/delete_enquiry_followup";
$route['updatefollowupdata'] = "enquiry/updatefollowupdata";
$route['addmanualpayment'] = "enquiry/addmanualpayment";
$route['deleteEnquiryTransaction'] = "enquiry/deleteEnquirypaymentTransaction";
$route['get_enquiry_tarnsaction_details/(:any)'] = "enquiry/get_enquiry_tarnsaction_details/$1";
$route['sendManualAdmissionlink'] = "enquiry/sendManualAdmissionlink";
$route['add_on_courses/(:any)'] = "enquiry/add_on_courses/$1";
$route['save_add_on_course'] = "enquiry/save_add_on_course";
$route['activeinactiveaddoncourses'] = "enquiry/activeinactiveaddoncourses";

//$route['deleteEnquiry/(:any)'] = "enquiry/deleteEnquiry/$1";
/*********** ADMISSION CONTROLLER ROUTES *******************/
$route['admissionListing'] = "admission/admissionListing";
$route['fetchadmissions'] = "admission/fetchadmissions";
$route['deleteAdmission'] = "admission/deleteAdmission";
$route['viewadmissiondetails/(:any)'] = "admission/viewadmissiondetails/$1";
$route['editadmission/(:any)'] = "admission/editadmission/$1";
$route['updateadmission'] = "admission/updateadmission";
$route['cancleadmission'] = "admission/cancleadmission";
$route['delete_add_on_course'] = "admission/delete_add_on_course";
/*********** Email Setting CONTROLLER ROUTES *******************/
// Template
$route['emailtemplateListing'] = "emailSetting/emailtemplateListing";
$route['deleteTemplate/(:any)'] = "emailSetting/deleteTemplate/$1";
// SMTP
$route['emailsmtpListing'] = "emailSetting/emailsmtpListing";
//$route['deleteSmtp/(:any)'] = "emailSetting/deleteSmtp/$1";
$route['fetchSmtpsetting'] = 'emailSetting/fetchSmtpsetting';
$route['createemailsmtp'] = 'emailSetting/createemailsmtp';
$route['deletesmtp'] = 'emailSetting/deletesmtp';
$route['updateSMTP/(:any)'] = 'emailSetting/updateSMTP/$1';
// Payment 
$route['payment_details/(:any)'] = 'enquiry/payment_details/$1';
$route['update_discount'] = 'enquiry/update_discount';
// Tax Invoices
$route['taxinvoices'] = 'enquiry/taxinvoices';
$route['fetchTaxinvoices'] = 'enquiry/fetchTaxinvoices';
// Student Loging Billing Info
$route['billinginfo'] = 'student/billinginfo';
$route['fetchBillinginfo'] = 'student/fetchBillinginfo';
$route['update_student'] = 'student/update_student';
// Student Loging Billing Info
$route['profilesetting'] = 'admin/profilesetting';
$route['updateprofile'] = 'admin/updateprofile';
//attendance
$route['attendance'] = 'admin/attendance';
$route['fetchstudentattendance'] = 'admin/fetchstudentattendance';
// Students Enquires and Srudent Listings here 
$route['studentadmissions'] = 'student/studentadmissions';
$route['fetchstudentadmissions'] = 'student/fetchstudentadmissions';
$route['studentpaymentdetails/(:any)'] = 'student/studentpaymentdetails/$1';
$route['studentcourses'] = 'student/studentcourses';
$route['fetchstudentcourse'] = "student/fetchstudentcourse";
$route['viewstudentscoursetopis/(:any)'] = "student/viewstudentscoursetopis/$1";
$route['fetchstudnetCourseAttchemant/(:any)'] = "student/fetchstudnetCourseAttchemant/$1";
$route['studenttopicdocumentslisting?(:any)'] = "student/studenttopicdocumentslisting/$1";
$route['studentviewalltopicdocuments?(:any)'] = "student/studentviewalltopicdocuments/$1";
$route['studentfetchTopicDocument?(:any)'] = "student/studentfetchTopicDocument/$1";
$route['studentfetchTopicDocument?(:any)'] = "student/studentfetchTopicDocument/$1";
$route['studenttimetableListing/(:any)'] = "student/studenttimetableListing/$1";
$route['fetchstudentTimetable/(:any)'] = "student/fetchstudentTimetable/$1";
$route['studentviewtimetablelisting?(:any)'] = "student/studentviewtimetablelisting/$1";
$route['fetchStudentTopicTimetableListing?(:any)'] = "student/fetchStudentTopicTimetableListing/$1";
$route['addstudenttopiclinksforonlineattendant?(:any)'] = "student/addstudenttopiclinksforonlineattendant/$1";
$route['fetchstudenttopicmeetinglink?(:any)'] = "student/fetchstudenttopicmeetinglink/$1";
$route['attendClasses'] = "student/attendClasses";
$route['studentattendance'] = "student/studentattendance";
$route['fetchstudentattendancestudentpanel'] = "student/fetchstudentattendancestudentpanel";
$route['studentexaminationlist'] = "student/studentexaminationlist";
$route['studentexamination/(:any)'] = "student/studentexamination/$1";
$route['fetchstudentexamination'] = "student/fetchstudentexamination";
$route['attendexamination/(:any)'] = "student/attendexamination/$1";
$route['start_exam/(:any)'] = "student/start_exam/$1";
$route['submit_examination_db'] = "student/submit_examination_db";
$route['showexamstatus/(:any)'] = "student/showexamstatus/$1";
$route['examcheckingList'] = "admin/examcheckingList";
$route['fetchExamcheckListing'] = "admin/fetchExamcheckListing";
$route['checkanswersheet?(:any)'] = "admin/checkanswersheet/$1";
$route['fetchallstudentansersheet?(:any)'] = "admin/fetchallstudentansersheet/$1";
$route['addmarkstoexam?(:any)'] = "admin/addmarkstoexam/$1";
$route['submit_examination_answer_db'] = "admin/submit_examination_answer_db";
$route['crtificateListing'] = "admin/crtificateListing";
$route['fetchallstudentcertificates'] = "admin/fetchallstudentcertificates";
$route['studentcrtificateListing'] = "student/studentcrtificateListing";
$route['fetchallstudentcertificatesstudentPortal'] = "student/fetchallstudentcertificatesstudentPortal";
$route['updateevbtrnumber'] = "student/updateevbtrnumber";
$route['printmarksheet?(:any)'] = "admin/printmarksheet/$1";
$route['askqquery'] = "student/askqquery";
$route['fetchallstudentquerys'] = "student/fetchallstudentquerys";
$route['addnewquery'] = "student/addnewquery";
$route['delete_query'] = "student/delete_query";
$route['viewqueryanswer/(:any)'] = "student/viewqueryanswer/$1";
$route['fetchallstudentquerysanswer/(:any)'] = "student/fetchallstudentquerysanswer/$1";
$route['addqueryanswer'] = "student/addqueryanswer";
$route['delete_query_answer'] = "student/delete_query_answer";
/*  Report Section Start Here */ 
// $route['studentreport'] = "student/studentreport";
$route['studentreport'] = "student/studentreportexportpdf";
$route['fetchallstudentreportlist'] = "student/fetchallstudentreportlist";
$route['fetchallstudentdataforprintidcard'] = "student/fetchallstudentdataforprintidcard";
$route['studentreportexporttoexel'] = "student/studentreportexporttoexel";
$route['getcoursetopic'] = "student/getcoursetopic";
$route['cancletimetableclass'] = "course/cancletimetableclass";
$route['activstetimetableclass'] = "course/activstetimetableclass";
$route['studentexamrequest'] = "admin/studentexamrequest";
$route['getstudentcourselist'] = "admin/getstudentcourselist";
$route['allowstudentexamrequest'] = "admin/allowstudentexamrequest";
$route['fetchstudentexamrequestdata'] = "admin/fetchstudentexamrequestdata";
$route['deletestudentrequest'] = "admin/deletestudentrequest";
$route['CheckboxCheckUncheckpermission'] = "admin/CheckboxCheckUncheckpermission";
$route['courseRequest'] = "admin/courseRequest";
$route['fetchcourseRequest'] = "admin/fetchcourseRequest";
$route['getcoursetopicrequestdetails'] = "admin/getcoursetopicrequestdetails";
$route['addnewcoursetopicrequest'] = "admin/addnewcoursetopicrequest";
$route['viewclassrequest'] = "admin/viewclassrequest";
$route['fetchcourseRequestadmin'] = "admin/fetchcourseRequestadmin";
$route['getcoursetopicrequestdetailsadmin'] = "admin/getcoursetopicrequestdetailsadmin";
$route['addnewcoursetopicrequestapproved'] = "admin/addnewcoursetopicrequestapproved";
$route['add_addon_discount_payment'] = "enquiry/add_addon_discount_payment";
$route['viewaddoncoursepaymentdetails/(:any)'] = "enquiry/viewaddoncoursepaymentdetails/$1";
$route['fetchaddoncoursepaymentdetails/(:any)'] = "enquiry/fetchaddoncoursepaymentdetails/$1";
$route['sendPaymentLinkaddoncourse'] = "enquiry/sendPaymentLinkaddoncourse";
$route['settings'] = "admin/settings";
$route['whatappconfigupdate'] = "admin/whatappconfigupdate";


$route['leaverequest'] = "student/leaverequest";
$route['fetchleaverequestlist'] = "student/fetchleaverequestlist";
$route['addnewleaverequest'] = "student/addnewleaverequest";
$route['deleteleaverequestdata'] = "student/deleteleaverequestdata";
$route['editleaverequest/(:any)'] = "student/editleaverequest/$1";

















































