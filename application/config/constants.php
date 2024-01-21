<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



/*********** TABLES  *******************/
define('TBL_COURSE', 'tbl_course');
define('TBL_COURSE_TYPE', 'tbl_course_type');
define('TBL_COUNTRY', 'tbl_countries');
define('TBL_STATES', 'tbl_states');
define('TBL_CITIES', 'tbl_cities');
define('TBL_ENQUIRY', 'tbl_enquiry');
define('TBL_PAYMENT', 'tbl_payment_transaction');
define('TBL_USER','tbl_users');
define('TBL_ROLES','tbl_roles');
define('TBL_ADMISSION','tbl_admission');
define('TBL_EMAIL_SMTP','tbl_email_smtp');
define('TBL_COURSE_TOPICS','tbl_course_topics');
define('TBL_COURSE_TOPICS_DOCUMENT','tbl_topic_document');
define('TBL_TIMETABLE','tbl_timetable');
define('TBL_TIMETABLE_TRANSECTIONS','tbl_timetable_transection');
define('TBL_EXAMINATION','tbl_examination');
define('TBL_QUESTION_PAPER','tbl_course_question_paper');
define('TBL_ENQUIRY_FOLLOW_UP', 'tbl_enquiry_follow_up');
define('TBL_TOPIC_MEETING_LINK', 'tbl_topic_meeting_link');
define('TBL_USERS_ENQUIRES', 'tbl_users_enquires');
define('TBL_ATTENDANCE', 'tbl_attendance');
define('TBL_STUDENT_ANSWER_SHEET', 'tbl_student_answer_sheet');
define('TBL_ASK_A_QUERY', 'tbl_askquery');
define('TBL_ASK_A_QUERY_ANSWER', 'tbl_queryanswers');
define('TBL_COURSE_SYLLABUS', 'tbl_course_syllabus');
define('TBL_STUDENT_REQUEST', 'tbl_student_exam_request');
define('TBL_ACTIVITY_APP_LOG', 'tbl_activity_log_app');
define('TBL_ADD_ON_COURSE', 'tbl_add_on_courses');
define('TBL_NEW_COURSE_REQUEST', 'tb_new_course_request');
define('TBL_SETTINGS', 'tbl_settings');
define('DATEANDTIME', Date('Y-m-d H:i:s'));


// define('EMAIL_SMTP_HOST','smtp-relay.brevo.com');		// your smtp host e.g. smtp.gmail.com
// define('EMAIL_SMTP_AUTH','true');		// your smtp host e.g. smtp.gmail.com
// define('EMAIL_USERNAME','admin@iictn.in');	// Your system name
// define('EMAIL_PASSWORD','EFwG7g1h2vmOTMHB');	// Your email password
// define('EMAIL_SMTP_PORT','587');				    // mail, sendmail, smtp
// define('FROM_EMAIL','admin@iictn.in');		// e.g. email@example.com
// define('FROM_EMAIL_NAME','IICTN-Payment');
// define('EMAIL_SECURE','tls');			// e.g. email@example.com
// define('EMAIL_NAME','IICTN');	


// define('EMAIL_SMTP_HOST','smtp.iictn.com');		// your smtp host e.g. smtp.gmail.com
// define('EMAIL_SMTP_AUTH','true');		// your smtp host e.g. smtp.gmail.com
// define('EMAIL_USERNAME','admin@iictn.in');	// Your system name
// define('EMAIL_PASSWORD','QY9ZT(!N#.Ro');	// Your email password
// define('EMAIL_SMTP_PORT','587');				    // mail, sendmail, smtp
// define('FROM_EMAIL','admin@iictn.in');		// e.g. email@example.com
// define('FROM_EMAIL_NAME','IICTN-Payment');
// define('EMAIL_SECURE','tls');			// e.g. email@example.com
// define('EMAIL_NAME','IICTN');


define('EMAIL_SMTP_HOST','mail.iictn.in');		// your smtp host e.g. smtp.gmail.com
define('EMAIL_SMTP_AUTH','true');		// your smtp host e.g. smtp.gmail.com
define('EMAIL_USERNAME','admin@iictn.in');	// Your system name
define('EMAIL_PASSWORD','QY9ZT(!N#.Ro');	// Your email password
define('EMAIL_SMTP_PORT','587');				    // mail, sendmail, smtp
define('FROM_EMAIL','admin@iictn.in');		// e.g. email@example.com
define('FROM_EMAIL_NAME','IICTN-Payment');
define('EMAIL_SECURE','tls');			// e.g. email@example.com
define('EMAIL_NAME','IICTN');

define('RAZORPAYKEY','rzp_test_MuaQbngB5NBp7h');



define('INSTANCE_ID','65784BDAEE97A');
define('ACCESS_TOKEN','64e7462031534');



if($_SERVER['HTTP_HOST']=='localhost'){
    define('SERVER','http://localhost/lms_2/');
}else{
    define('SERVER','https://iictn.in/');
}








