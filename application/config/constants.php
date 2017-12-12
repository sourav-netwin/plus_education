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

//Google API Key
define('GOOGLE_API_KEY' , 'AIzaSyAxAOuX6VZ3411GsROuhn-SxYbNC0skt9M');

//Database table names
define('TABLE_PROGRAM' , 'frontweb_program_banner');
define('TABLE_PROGRAM_LANGUAGE' , 'frontweb_program_banner_language');
define('TABLE_LANGUAGE' , 'frontweb_language');
define('TABLE_COURSE_MASTER' , 'frontweb_course_master');
define('TABLE_COURSE_LANGUAGE' , 'frontweb_course_language');
define('TABLE_COURSE_SPECIFICATION' , 'frontweb_course_specification');
define('TABLE_COURSE_FEATURE' , 'frontweb_course_feature');
define('TABLE_PROGRAM_COURSE' , 'frontweb_program_course');
define('TABLE_JUNIOR_CENTRE' , 'frontweb_junior_centre');
define('TABLE_JUNIOR_CENTRE_PROGRAM' , 'frontweb_junior_centre_program');
define('TABLE_CENTRE' , 'centri');
define('TABLE_JUNIOR_CENTRE_ADDON' , 'frontweb_junior_centre_addon');
define('TABLE_JUNIOR_CENTRE_FACTSHEET' , 'frontweb_junior_centre_fact_sheet');
define('TABLE_JUNIOR_CENTRE_ACTIVITY_PROGRAM' , 'frontweb_junior_centre_activity_program');
define('TABLE_JUNIOR_CENTRE_MENU' , 'frontweb_junior_centre_menu');
define('TABLE_JUNIOR_CENTRE_WALKING_TOUR' , 'frontweb_junior_centre_walking_tour');
define('TABLE_CENTRI_PSG' , 'plused_join_centri_psg');
define('TABLE_JUNIOR_CENTRE_DATES' , 'frontweb_junior_centre_dates');
define('TABLE_JUNIOR_CENTRE_DATES_WEEK' , 'frontweb_junior_centre_dates_week');
define('TABLE_JUNIOR_CENTRE_DATES_PROGRAM' , 'frontweb_junior_centre_dates_program');
define('TABLE_CONTENT_MST' , 'frontweb_contentmst');
define('TABLE_MENU_MST' , 'frontweb_menumst');
define('TABLE_JUNIOR_CENTRE_PHOTO_GALLERY' , 'frontweb_junior_centre_photo_gallery');
define('TABLE_JUNIOR_CENTRE_VIDEO_GALLERY' , 'frontweb_junior_centre_video_gallery');
define('TABLE_JUNIOR_CENTRE_INTERNATIONAL_MIX' , 'frontweb_junior_centre_international_mix');

//Admin panel base url path to access images
define('ADMIN_PANEL_URL' , 'http://localhost/stvision/vision/');

//Define image location details for program banner module images
define('PROGRAM_IMAGE_PATH' , 'uploads/program/');

//Define image location details for program module images
define('COURSE_IMAGE_PATH' , 'uploads/course/');
define('COURSE_FRONT_IMAGE_PATH' , 'uploads/course_front/');

//Define image location details for program course module images
define('PROGRAM_COURSE_IMAGE_PATH' , 'uploads/program_course/');

//Define image location details for Junior Centre module images
define('JUNIOR_CENTRE_IMAGE_PATH' , 'uploads/junior_centre/');

//Define image location details for course feature module images
define('COURSE_FEATURE_IMAGE_PATH' , 'uploads/course_feature/');

//Define image location details for centre master module images
define('CENTRE_MASTER_IMAGE_PATH' , 'uploads/campus_image/');

//Define file upload location details for add on module
define('ADD_ON_FILE_PATH' , 'uploads/addon/');

//Define file upload location details for fact sheet module
define('FACTSHEET_FILE_PATH' , 'uploads/factsheet/');

//Define file upload location details for activity program module
define('ACTIVITY_PROGRAM_FILE_PATH' , 'uploads/activity_program/');

//Define file upload location details for menu module
define('MENU_FILE_PATH' , 'uploads/menu/');

//Define file upload location details for menu module
define('WALKING_TOUR_FILE_PATH' , 'uploads/walking_tour/');

//Define image location details for junior centre photo gallery images
define('PHOTO_GALLERY_IMAGE_PATH' , 'uploads/photo_gallery/');

//Define image location details for junior centre photo gallery images
define('VIDEO_GALLERY_IMAGE_PATH' , 'uploads/video_gallery/');
