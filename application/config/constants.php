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


/*
|--------------------------------------------------------------------------
| MY CONSTANTS
|--------------------------------------------------------------------------
|
| 1. ALL
| if DA Type is All and department is All, there is no restriction on a particular type 
| of DA, packing list, invoice packing list or any other document, user can access any
| document.
|
| 2. API
| 2.1 if DA Type is API and department is API, now user can access only the documents 
| where DA Type is API and department can be any in API
| 2.2 if DA Type is API and department can be Oral-A, Oral-B, Oral-C/ Oral-F, Oral-D, 
| Oral-E, Oral-G, Oral-H,Sterile-A/ Sterile-B/ Sterile-C or  Sterile-D/ Sterile-E, now 
| the user can only API DA with selected production block only.
|
| 3 Formulation
| 2.1 if DA Type is Formulation and department is Formulation then user can access all 
| documents where DA Type is formulation, no concern with Department.
| 2.2 if DA Type is Formulation and department is either Oral or injection then the user 
| will access the Formulation documents with connection to Department.
|
| 4. Menthol
| here DA Type will be always menthol and department will be also Menthol, no there |option, means to access menthol documents.
|
|5. Capsule
|here DA Type and department both will be capsule to access capsule documents only.
|
|6. Diagnostic
|here DA type and department both are diagnostic means user can access all diagnostic |documents.
|
*/

defined('ADMIN')      OR define('ADMIN', 1); // Amdin id
defined('PPIC')      OR define('PPIC', 13); // PPIC ROLE DECLARED
/*********** DEPARTMENT CONSTANTS ********************/

defined('API')      OR define('API', 10); // department api
defined('FORMULATION')   OR define('FORMULATION', 12); // department formulation
defined('MENTHOL')      OR define('MENTHOL', 14); // department menthol
defined('DIAGNOSTIC')      OR define('DIAGNOSTIC', 15); // department diagnostic
defined('ALL')      OR define('ALL', 18); // department all
defined('CAPSULE')      OR define('CAPSULE', '');

/********* DA TYPE CONSTANTS  *********************/

defined('DA_API')      OR define('DA_API', 1); // DA Type api
defined('DA_FORMULATION')   OR define('DA_FORMULATION', 3); // DA  Typeformulation
defined('DA_MENTHOL')      OR define('DA_MENTHOL', 2); // DA Type menthol
defined('DA_DIAGNOSTIC')      OR define('DA_DIAGNOSTIC', 6); // DA Type diagnostic
defined('DA_ALL')      OR define('DA_ALL', 11); // DA Type all
defined('DA_GWARGUM')      OR define('DA_GWARGUM', 4); // DA TypeGWARGUM
defined('DA_CAPSULE')      OR define('DA_CAPSULE', 5); // DA Type CAPSULE