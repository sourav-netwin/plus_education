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

//For creating encrypted data
define('ENCRYPTKEY' , 'STUDYTOURS@!123456');

//Database table names
define('TABLE_USERS' , 'tbl_users');
define('TABLE_PROGRAM' , 'tbl_program_banner');
define('TABLE_PROGRAM_LANGUAGE' , 'tbl_program_banner_language');
define('TABLE_LANGUAGE' , 'tbl_language');
define('TABLE_COURSE_MASTER' , 'tbl_course_master');
define('TABLE_COURSE_LANGUAGE' , 'tbl_course_language');
define('TABLE_COURSE_SPECIFICATION' , 'tbl_course_specification');
define('TABLE_COURSE_FEATURE' , 'tbl_course_feature');
define('TABLE_REGION_MASTER' , 'tbl_region_master');
define('TABLE_CENTRE_MASTER' , 'tbl_centre_master');
define('TABLE_PROGRAM_COURSE' , 'tbl_program_course');
define('TABLE_JUNIOR_CENTRE' , 'tbl_junior_centre');
define('TABLE_JUNIOR_CENTRE_PROGRAM' , 'tbl_junior_centre_program');

//For Image cropping - path of css and js
define('CROPPING_ASSETS_PATH' , 'assets/cropping/');

//Define the upload image size
define('UPLOAD_IMAGE_SIZE' , 6000);

//Define image location , height , width , thumb details for program banner module images
define('PROGRAM_IMAGE_PATH' , 'uploads/program/');
define('PROGRAM_WIDTH' , 1920);
define('PROGRAM_HEIGHT' , 500);
define('PROGRAM_THUMB_WIDTH' , 250);
define('PROGRAM_THUMB_HEIGHT' , 65);

//Define image location , height , width , thumb details for program module images
define('COURSE_IMAGE_PATH' , 'uploads/course/');
define('COURSE_WIDTH' , 1920);
define('COURSE_HEIGHT' , 500);
define('COURSE_THUMB_WIDTH' , 250);
define('COURSE_THUMB_HEIGHT' , 65);

define('COURSE_FRONT_IMAGE_PATH' , 'uploads/course_front/');
define('COURSE_FRONT_WIDTH' , 800);
define('COURSE_FRONT_HEIGHT' , 500);
define('COURSE_FRONT_THUMB_WIDTH' , 250);
define('COURSE_FRONT_THUMB_HEIGHT' , 156);

//Define image location , height , width , thumb details for program course module images
define('PROGRAM_COURSE_IMAGE_PATH' , 'uploads/program_course/');
define('PROGRAM_COURSE_WIDTH' , 146);
define('PROGRAM_COURSE_HEIGHT' , 137);
define('PROGRAM_COURSE_THUMB_WIDTH' , 90);
define('PROGRAM_COURSE_THUMB_HEIGHT' , 87);

//Define image location , height , width , thumb details for Junior Centre module images
define('JUNIOR_CENTRE_IMAGE_PATH' , 'uploads/junior_centre/');
define('JUNIOR_CENTRE_WIDTH' , 1920);
define('JUNIOR_CENTRE_HEIGHT' , 500);
define('JUNIOR_CENTRE_THUMB_WIDTH' , 250);
define('JUNIOR_CENTRE_THUMB_HEIGHT' , 65);
