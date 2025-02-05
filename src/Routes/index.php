<?php

use App\Controllers\HomeController;
use App\Controllers\SubjectController;
use App\Controllers\AdvertisementController;

use App\Controllers\admin\AdminLoginController;
use App\Controllers\admin\AdminDashboardController;
use App\Controllers\admin\FeeRequestController;
use App\Controllers\admin\adminSubjectController;
use App\Controllers\admin\adminSessionController;
use App\Controllers\admin\adminStudentController;
use App\Controllers\admin\AdminTutorGradingController;
use App\Controllers\admin\AdminSettingsController;
use App\Controllers\admin\AdminInboxController;

use App\Router;

use App\Controllers\StudentLoginController;
use App\Controllers\StudentSignupController;
use App\Controllers\StudentDashboardController;
use App\Controllers\StudentFindtutorController;
use App\Controllers\StudentEventsController;
use App\Controllers\StudentFeedbackController;
use App\Controllers\StudentPublicProfileController;
use App\Controllers\StudentSessionController;
use App\Controllers\StudentPaymentController;
use App\Controllers\StudentRatingController;
use App\Controllers\StudentDownloadsController;
use App\Controllers\StudentReportController;
use App\Controllers\StudentLogoutController;
use App\Controllers\StudentEditProfileController;

use App\Controllers\tutor\TutorSignupController;
use App\Controllers\tutor\TutorLoginController;
use App\Controllers\tutor\TutorDashboardController;
use App\Controllers\tutor\TutorEventController;
use App\Controllers\tutor\TutorRequestController;
use App\Controllers\tutor\TutorPublicProfileController;
use App\Controllers\tutor\TutorPaymentsController;
use App\Controllers\tutor\TutorFeedbackController;
use App\Controllers\tutor\TutorAdvertisementController;
use App\Controllers\tutor\TutorLogoutController;


$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/subject', SubjectController::class, 'showSubjectPage');
$router->get('/advertisement', AdvertisementController::class, 'showAdvertisementGalleryPage');
$router->post('/upload-ad', AdvertisementController::class, 'uploadAdvertisement');
$router->post('/delete-ad', AdvertisementController::class, 'deleteAdvertisement');
$router->post('/update-ad', AdvertisementController::class, 'updateAdvertisement');
//$router->get('/student-login', StudentLoginController::class, 'ShowStudentLoginPage');
//$router->get('/student-signin', StudentSigninController::class, 'ShowStudentSigninPage');

//student routes
$router->get('/student-login', StudentLoginController::class, 'ShowStudentLoginPage');
$router->get('/student-signup', StudentSignupController::class, 'ShowStudentSignupPage');  //get the page from backend
$router->get('/student-dashboard',StudentDashboardController::class, 'showStudentDashboardPage');
$router->get('/student-findtutor',StudentFindtutorController::class, 'ShowFindtutor');
$router->get('/student-events',StudentEventsController::class, 'ShowEvents');
$router->get('/student-feedback',StudentFeedbackController::class, 'ShowFeedback');
$router->get('/student-publicprofile', StudentPublicProfileController::class, 'ShowPublicprofile');
$router->get('/student-session',StudentSessionController::class, 'ShowSession');
$router->get('/student-payment',StudentPaymentController::class, 'ShowPayment');
$router->get('/student-rating',StudentRatingController::class, 'ShowRating');
$router->get('/student-downloads',StudentDownloadsController::class, 'ShowDownloads');
$router->get('/student-report',StudentReportController::class, 'ShowReport');
$router->get('/student-logout',StudentLogoutController::class, 'ShowLogout');
$router->get('/student-profile',StudentEditProfileController::class, 'ShowEditProfile');
$router->post('/student_signup',StudentSignupController::class, 'student_signup');  //used to send the data to the backend
$router->post('/student-login',StudentLoginController::class, 'login');
$router->post('/feedback/submit',StudentFeedbackController::class, 'save_comments');
$router->post('/feedback/edit',StudentFeedbackController::class, 'update_comments');
$router->post('/feedback/delete',StudentFeedbackController::class, 'delete_comments'); //used to send the data to the backend

// Tutor routes
$router->get('/tutor-login', TutorLoginController::class, 'showLogin'); // Show login page
$router->post('/tutor-login-action', TutorLoginController::class, 'handleLogin'); // Handle login form submission
$router->get('/tutor-signup', TutorSignupController::class, 'ShowTutorSignupPage'); // Show signup page
$router->get('/tutor-dashboard', TutorDashboardController::class, 'ShowTutorDashboardPage'); // Redirect only if logged in
$router->get('/tutor-event', TutorEventController::class, 'showEventPage'); 
$router->get('/tutor-request', TutorRequestController::class, 'showrequestPage'); 
$router->get('/tutor-public-profile', TutorPublicProfileController::class, 'showPublicProfilePage'); 
$router->get('/tutor-payment', TutorPaymentController::class, 'showPaymentPage');
$router->get('/tutor-feedback', TutorFeedbackController::class, 'showFeedbackPage'); 
$router->get('/tutor-logout', TutorLogoutController::class, 'logout');
$router->get('/tutor-advertisement', TutorAdvertisementController::class, 'showAdvertisementGalleryPage');
$router->post('/tutor-upload-ad', TutorAdvertisementController::class, 'uploadAdvertisement');
$router->post('/tutor-delete-ad', TutorAdvertisementController::class, 'deleteAdvertisement');
$router->post('/tutor-update-ad', TutorAdvertisementController::class, 'updateAdvertisement');


//student profile for admin
$router->get('/admin/student-profile', AdminDashboardController::class, 'studentprofile');
//admin routes
$router->get('/admin-login', AdminLoginController::class, 'showLoginPage');
$router->post('/admin-login', AdminLoginController::class, 'checkAdminLogin');
$router->get('/admin-dashboard', AdminDashboardController::class, 'showDashboard');
$router->get('/admin-logout', AdminDashboardController::class, 'logout');
//admin sessions
$router->get('/admin-sessions', adminSessionController::class, 'showAllSessions');
//search sessions
$router->post('/admin-sessions', adminSessionController::class, 'showAllSessions');
//admin students
$router->get('/admin-students', AdminStudentController::class, 'showAllStudents');
//student search
$router->post('/admin-students', AdminStudentController::class, 'searchStudents');
//student profile
$router->get('/admin-student-profile/{id}', AdminStudentController::class, 'showStudentProfile');

//tutor grading
$router->get('/admin-tutor-grading', AdminTutorGradingController::class, 'showAllGrades');
//update tutor grade
$router->post('/admin-tutor-grading-update', AdminTutorGradingController::class, 'updateGrade');
//FeeRequest View
$router->get('/admin-dashboard/fee-requests', FeeRequestController::class, 'showFeeRequests');

//admin subjects
$router->get('/admin-subjects', adminSubjectController::class, 'showAllSubjects');

//admin settings
$router->get('/admin-settings', AdminSettingsController::class, 'showSettings');

//admin inbox
//$router->get('/admin-inbox', AdminInboxController::class, 'showInbox');

//admin update subject
$router->post('/admin-dashboard/updatesubject', adminSubjectController::class, 'updateSubject');

//admin delete subject
$router->post('/admin-dashboard/deletesubject', adminSubjectController::class, 'deleteSubject');

//admin add subject
$router->post('/admin-dashboard/addsubject', adminSubjectController::class, 'addSubject');

//restore subject
$router->post('/admin-dashboard/restoresubject', adminSubjectController::class, 'restoreSubject');

$router->get('/admin-inbox', AdminInboxController::class, 'index'); // Show inbox
$router->post('/admin-inbox/send', AdminInboxController::class, 'sendMessage'); // Handle sending a message

//transactions
$router->get('/admin-transactions', AdminTransactionController::class, 'showTransactions');

$router->dispatch();