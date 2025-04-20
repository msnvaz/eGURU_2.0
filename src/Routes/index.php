<?php

use App\Controllers\HomeController;
use App\Controllers\SubjectPageController;
use App\Controllers\AdvertisementController;
use App\Controllers\TutorActiveController; //for most active tutors
use App\Controllers\TutorPopularController; //for most popular tutors
use App\Controllers\TutorPreviewController; //for tutor short preview
use App\Controllers\DisplayAnnouncementController; //for displaying announcements
use App\Controllers\VisitorQueryController; //for visitor-query
use App\Controllers\ForumController; //for forum
use App\Controllers\TutorSearchController; //for forum

use App\Controllers\admin\AdminLoginController;
use App\Controllers\admin\AdminDashboardController;
use App\Controllers\admin\FeeRequestController;
use App\Controllers\admin\adminSubjectController;
use App\Controllers\admin\adminSessionController;
use App\Controllers\admin\AdminAnnouncementController; //for announcement
use App\Controllers\admin\adminStudentController;
use App\Controllers\admin\AdminTutorGradingController;
use App\Controllers\admin\AdminSettingsController;
use App\Controllers\admin\AdminInboxController;
use App\Controllers\admin\AdminTransactionController;

//Cretaed for manager
use App\Controllers\manager\ManagerLoginController;
use App\Controllers\manager\ManagerDashboardController;
use App\Controllers\manager\ManagerAnnouncementController;


use App\Router;

use App\Controllers\student\StudentLoginController;
use App\Controllers\student\StudentSignupController;
use App\Controllers\student\StudentDashboardController;
use App\Controllers\student\StudentFindtutorController;
use App\Controllers\student\StudentEventsController;
use App\Controllers\student\StudentFeedbackController;
use App\Controllers\student\StudentPublicProfileController;
use App\Controllers\student\StudentSessionController;
use App\Controllers\student\StudentPaymentController;
use App\Controllers\student\StudentRatingController;
use App\Controllers\student\StudentDownloadsController;
use App\Controllers\student\StudentReportController;
use App\Controllers\student\StudentLogoutController;
use App\Controllers\student\StudentEditProfileController;

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
$router->get('/subject', SubjectPageController::class, 'showSubjectPage');
$router->get('/tutorpreview', TutorPreviewController::class, 'showTutorProfile'); // newly added by shayan
$router->get('/advertisement', AdvertisementController::class, 'showAdvertisementGalleryPage');
$router->get('/announcement', DisplayAnnouncementController::class, 'displayAnnouncements');
$router->post('/visitor-query', VisitorQueryController::class, 'storeVisitorQuery'); //for visitor query
$router->post('/upload-ad', AdvertisementController::class, 'uploadAdvertisement');
$router->post('/delete-ad', AdvertisementController::class, 'deleteAdvertisement');
$router->post('/update-ad', AdvertisementController::class, 'updateAdvertisement');
$router->get('/forum', ForumController::class, 'showForumMessages');
$router->post('/forum', ForumController::class, 'showForumMessages');
$router->get('/tutor/search', TutorSearchController::class, 'showSearchForm');
$router->post('/tutor/search', TutorSearchController::class, 'search');

//$router->get('/student-login', StudentLoginController::class, 'ShowStudentLoginPage');
//$router->get('/student-signin', StudentSigninController::class, 'ShowStudentSigninPage');

//student routes
$router->get('/student-login', StudentLoginController::class, 'ShowStudentLoginPage');
$router->get('/student-signup', StudentSignupController::class, 'ShowStudentSignupPage');
$router->post('/student_signup', StudentSignupController::class, 'student_signup');
$router->post('/student-login', StudentLoginController::class, 'login');
$router->get('/student-dashboard', StudentDashboardController::class, 'showStudentDashboardPage');

$router->get('/student-findtutor',StudentFindtutorController::class, 'ShowFindtutor');
$router->get('/student-events',StudentEventsController::class, 'ShowEvents');
$router->get('/student-feedback',StudentFeedbackController::class, 'showFeedback');
$router->post('/student-feedback/submit',StudentFeedbackController::class, 'submitFeedback');   //submitFeedback in the controller
$router->post('/student-feedback/update',StudentFeedbackController::class, 'updateFeedback');
$router->post('/student-feedback/delete',StudentFeedbackController::class, 'deleteFeedback');

$router->get('/student-publicprofile', StudentPublicProfileController::class, 'ShowPublicprofile');
$router->get('/student-session',StudentSessionController::class, 'ShowSession');
$router->get('/student-payment',StudentPaymentController::class, 'ShowPayment');
$router->get('/student-rating',StudentRatingController::class, 'ShowRating');
$router->get('/student-downloads',StudentDownloadsController::class, 'ShowDownloads');
$router->get('/student-report',StudentReportController::class, 'ShowReport');
$router->post('/student/save-report', StudentReportController::class, 'saveReport');
$router->post('/student/get-tutor-details', StudentReportController::class, 'getTutorDetails');

$router->get('/student-logout',StudentLogoutController::class, 'ShowLogout');
$router->post('/student_signup',StudentSignupController::class, 'student_signup');  //used to send the data to the backend
$router->post('/student-login',StudentLoginController::class, 'login');
$router->get('/student-publicprofile', StudentPublicProfileController::class, 'ShowPublicprofile');
$router->post('/student-profile-updated', StudentPublicProfileController::class, 'ShowUpdatedprofile');
$router->get('/student-profile-edit', StudentPublicProfileController::class, 'ShowEditprofile');
$router->post('/student-profile-delete', StudentPublicProfileController::class,'DeleteProfile');

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
$router->get('/admin-student-profile/{id}', AdminStudentController::class, 'showStudentProfile');


//admin routes
$router->get('/admin-login', AdminLoginController::class, 'showLoginPage');
$router->post('/admin-login', AdminLoginController::class, 'checkAdminLogin');
$router->get('/admin-dashboard', AdminDashboardController::class, 'showDashboard');
$router->get('/admin-logout', AdminDashboardController::class, 'logout');
//admin sessions
$router->get('/admin-sessions', adminSessionController::class, 'showAllSessions');
//search sessions
$router->post('/admin-sessions', adminSessionController::class, 'showAllSessions');
//admin announcements
$router->get('/admin-announcement', AdminAnnouncementController::class, 'showAnnouncements'); // View all announcements
$router->get('/admin-announcement/create{id}', AdminAnnouncementController::class, 'showCreateForm'); // Show create announcement form
$router->post('/admin-announcement/create', AdminAnnouncementController::class, 'createAnnouncement'); // Create a new announcement
$router->get('/admin-announcement/update/{id}', AdminAnnouncementController::class, 'showUpdateForm'); // Show update announcement form
$router->post('/admin-announcement/update', AdminAnnouncementController::class, 'updateAnnouncement'); // Update an existing announcement
$router->get('/admin-announcement/delete/{id}', AdminAnnouncementController::class, 'deleteAnnouncement'); // Delete an announcement



//admin students
$router->get('/admin-students', AdminStudentController::class, 'showAllStudents');
//student search
$router->post('/admin-students', AdminStudentController::class, 'searchStudents');
//deleted students
$router->get('/admin-deleted-students', AdminStudentController::class, 'showDeletedStudents');
//student profile
$router->get('/admin-student-profile/{id}', AdminStudentController::class, 'showStudentProfile');

//student profile edit routes
$router->get('/admin-edit-student-profile/{id}', AdminStudentController::class, 'editStudentProfile');
$router->post('/admin-update-student-profile/{id}', AdminStudentController::class, 'updateStudentProfile');

//student delete profile/set to unset
$router->post('/student-delete-profile/{id}', AdminStudentController::class, 'deleteStudentProfile');
//student restore profile/set to set
$router->post('/admin-restore-student/{id}', AdminStudentController::class, 'restoreStudentProfile');
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
$router->get('/admin-transactions', AdminTransactionController::class, 'showTransactions'); // Show all transactions and handle search
$router->post('/admin-transactions', AdminTransactionController::class, 'showTransactions'); // Allow search functionality

//refund with id
$router->post('/admin-refund/{id}', AdminTransactionController::class, 'refund');


//manager routes
$router->get('/manager-login', ManagerLoginController::class, 'showLoginPage');
$router->post('/manager-login', ManagerLoginController::class, 'checkManagerLogin');
$router->get('/manager-dashboard', ManagerDashboardController::class, 'showDashboard');
$router->get('/manager-logout', ManagerDashboardController::class, 'logout');
$router->get('/manager-announcement', ManagerAnnouncementController::class, 'getAnnouncements');




$router->dispatch();


