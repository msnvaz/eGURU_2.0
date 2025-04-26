<?php

use App\Controllers\scheduleAlgorithm\scheduleAlgorithmController; //for schedule algorithm
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
use App\Controllers\StudentReviewController; //for forum
use App\Controllers\TutorAdDisplayController; //for forum

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
use App\Controllers\admin\adminTutorController; 
use App\Controllers\admin\adminPointsController; //for points

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
use App\Controllers\student\StudentTimeSlotController;
use App\Controllers\student\StudentDownloadsController;
use App\Controllers\student\StudentReportController;
use App\Controllers\student\StudentLogoutController;
use App\Controllers\student\StudentInboxController;

use App\Controllers\student\StudentTutorRequestFormController;

use App\Controllers\tutor\TutorSignupController;
use App\Controllers\tutor\TutorLoginController;
use App\Controllers\tutor\TutorDashboardController;
use App\Controllers\tutor\TutorEventController;
use App\Controllers\tutor\TutorRequestController;
use App\Controllers\tutor\TutorPublicProfileController;
//use App\Controllers\tutor\TutorPaymentController;
use App\Controllers\tutor\TutorFeedbackController;
use App\Controllers\tutor\TutorAdvertisementController;
use App\Controllers\tutor\TutorLogoutController;
use App\Controllers\tutor\TutorFeeRequestController;
use App\Controllers\tutor\TutorStudyMaterialsController;
use App\Controllers\tutor\TutorTimeSlotController;
use App\Controllers\tutor\TutorStudentProfileController;
use App\Controllers\tutor\TutorInboxController;


$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/subject', SubjectPageController::class, 'showSubjectPage');
$router->get('/tutorpreview', TutorPreviewController::class, 'showTutorProfile'); // newly added by shayan
$router->get('/advertisement', AdvertisementController::class, 'showAdvertisementGalleryPage');
$router->get('/announcement', DisplayAnnouncementController::class, 'displayAnnouncements');
$router->post('/announcement', DisplayAnnouncementController::class, 'loadMoreAnnouncements'); // for load more announcments
$router->post('/visitor-query', VisitorQueryController::class, 'storeVisitorQuery'); //for visitor query
$router->post('/upload-ad', AdvertisementController::class, 'uploadAdvertisement');
$router->post('/delete-ad', AdvertisementController::class, 'deleteAdvertisement');
$router->post('/update-ad', AdvertisementController::class, 'updateAdvertisement');
$router->get('/forum', ForumController::class, 'showForumMessages');
$router->post('/forum', ForumController::class, 'showForumMessages');

$router->get('/tutor/search', TutorSearchController::class, 'showSearchForm');
$router->post('/tutor/search', TutorSearchController::class, 'search');
$router->get('/studentreview', StudentReviewController::class, 'showTestimonials');
$router->get('/tutor-ads', TutorAdDisplayController::class,'index');




//student routes
$router->get('/student-login', StudentLoginController::class, 'ShowStudentLoginPage');
$router->get('/student-signup', StudentSignupController::class, 'ShowStudentSignupPage');
$router->post('/student_signup', StudentSignupController::class, 'student_signup');
$router->post('/student-login', StudentLoginController::class, 'login');
$router->get('/student-logout', StudentLoginController::class, 'logout');
$router->get('/student-dashboard', StudentDashboardController::class, 'showStudentDashboardPage');
$router->get('/student-events/get-event-dates-in-month', StudentEventsController::class, 'getEventDatesInMonth');

$router->get('/student-findtutor', StudentFindtutorController::class, 'ShowFindtutor'); // Display the Find Tutor page
$router->post('/student-search-tutor', StudentFindtutorController::class, 'searchTutors'); // Handle tutor search
$router->post('/student-request-tutor/{id}', StudentFindtutorController::class, 'requestTutor'); // Handle tutor request

$router->get('/student-request-tutor/{id}', StudentTutorRequestFormController::class, 'showTutorRequestForm'); // Show tutor request form
$router->post('/student-process-tutor-request', StudentTutorRequestFormController::class, 'processTutorRequest'); // Process tutor request form

$router->post('/student-available-slots', scheduleAlgorithmController::class, 'getAvailableTimeSlots'); // Get available time slots

$router->get('/student-events', StudentEventsController::class, 'showEvents');
$router->get('/student-events/get-events-by-date', StudentEventsController::class, 'getEventsByDate');
$router->get('/student-events/get-event-dates-in-month', StudentEventsController::class, 'getEventDatesInMonth');
$router->get('/student-events/get-formatted-events', StudentEventsController::class, 'getFormattedEvents');

$router->get('/student-feedback',StudentFeedbackController::class, 'showFeedback');
$router->post('/student-feedback/submit',StudentFeedbackController::class, 'submitFeedback');   //submitFeedback in the controller
$router->post('/student-feedback/update',StudentFeedbackController::class, 'updateFeedback');
$router->post('/student-feedback/delete',StudentFeedbackController::class, 'deleteFeedback');

$router->get('/student-session', StudentSessionController::class, 'showSession');
$router->get('/student-pending-requests', StudentSessionController::class, 'getPendingRequests');
$router->get('/student-request-results', StudentSessionController::class, 'getRequestResults');
$router->post('/student-cancel-request', StudentSessionController::class, 'cancelRequest');
$router->get('/student-session-details/{sessionId}', StudentSessionController::class, 'getSessionDetails');

$router->get('/student-timeslot', StudentTimeSlotController::class, 'showStudentTimeSlotPage'); 
$router->post('/student-timeslot-save', StudentTimeSlotController::class, 'saveStudentTimeSlots');
$router->post('/student-delete-timeslot', StudentTimeslotController::class, 'deleteTimeslot');
$router->post('/student-update-timeslot', StudentTimeslotController::class, 'updateTimeslot');

$router->get('/student-publicprofile', StudentPublicProfileController::class, 'ShowPublicprofile');
$router->get('/student-payment',StudentPaymentController::class, 'ShowPayment');

$router->get('/student-downloads', StudentDownloadsController::class, 'showDownloads');
$router->get('/student-downloads/filter', StudentDownloadsController::class, 'filterMaterials');
$router->get('/student-downloads/download', StudentDownloadsController::class, 'downloadMaterial');

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

$router->get('/student-inbox', StudentInboxController::class, 'showInbox');
$router->post('/student-inbox', StudentInboxController::class, 'showInbox'); // Handle search form submission
$router->get('/student-inbox-message/{id}', StudentInboxController::class, 'showMessage');
$router->post('/student-inbox-archive/{id}', StudentInboxController::class, 'archiveMessage');
$router->post('/student-inbox-unarchive/{id}', StudentInboxController::class, 'unarchiveMessage');
$router->post('/student-inbox-reply/{id}', StudentInboxController::class, 'replyToMessage');
// Tutor compose message routes
$router->get('/student-compose-message', StudentInboxController::class, 'showComposeForm');
$router->post('/student-send-message', StudentInboxController::class, 'sendMessage');
// Tutor outbox routes
$router->get('/student-outbox', StudentInboxController::class, 'showOutbox');
$router->post('/student-outbox', StudentInboxController::class, 'showOutbox'); // For handling search in outbox
$router->get('/student-outbox-message/{id}/{type}', StudentInboxController::class, 'showSentMessage');

$router->get('/student-inbox', StudentInboxController::class, 'index'); // Show inbox
$router->post('/student-inbox/send', StudentInboxController::class, 'sendMessage'); // Handle sending a message

// Tutor routes
$router->get('/tutor-login', TutorLoginController::class, 'showLogin'); // Show login page
$router->post('/tutor-login-action', TutorLoginController::class, 'handleLogin'); // Handle login form submission
$router->get('/tutor-signup', TutorSignupController::class, 'ShowTutorSignupPage'); // Show signup page
$router->post('/tutor-signup-action', TutorSignupController::class, 'handleSignup');// Handle signup form submission
$router->get('/tutor-logout', TutorLogoutController::class, 'logout');
$router->get('/tutor-dashboard', TutorDashboardController::class, 'ShowTutorDashboardPage'); // Redirect only if logged in
$router->get('/tutor-event', TutorEventController::class, 'showEventPage'); 
$router->get('/tutor-event/get-event-dates-in-month', TutorEventController::class, 'getEventDatesInMonth');
$router->get('/tutor-event/get-events-by-date', TutorEventController::class, 'getEventsByDate');
$router->get('/tutor-request', TutorRequestController::class, 'showRequestPage'); 
$router->get('/tutor-session-cancel/{sessionId}', TutorEventController::class, 'cancelSession');
$router->post('/handle-session-request', TutorRequestController::class, 'handleSessionRequest');
$router->get('/tutor-public-profile', TutorPublicProfileController::class, 'showPublicProfilePage');
$router->post('/tutor-profile-updated', TutorPublicProfileController::class, 'ShowUpdatedprofile');
$router->get('/tutor-profile-edit', TutorPublicProfileController::class, 'ShowEditprofile');
$router->post('/tutor-profile-delete', TutorPublicProfileController::class,'DeleteProfile'); 
//$router->get('/tutor-payment', TutorPaymentController::class, 'showPaymentPage');
$router->get('/tutor-feedback', TutorFeedbackController::class, 'showFeedbackPage'); // Route to show feedback page
$router->post('/submit-reply', TutorFeedbackController::class, 'submitReply'); // Route for submitting reply
$router->post('/update-reply', TutorFeedbackController::class, 'updateReply');
$router->get('/tutor-advertisement', TutorAdvertisementController::class, 'showAdvertisementGalleryPage');
$router->post('/tutor-upload-ad', TutorAdvertisementController::class, 'uploadAdvertisement');
$router->post('/tutor-delete-ad', TutorAdvertisementController::class, 'deleteAdvertisement');
$router->post('/tutor-update-ad', TutorAdvertisementController::class, 'updateAdvertisement');
$router->post('/tutor-select-ad', TutorAdvertisementController::class, 'selectAd');
$router->get('/tutor-uploads', TutorStudyMaterialsController::class, 'showStudyMaterialsPage'); 
$router->post('/tutor-upload-material', TutorStudyMaterialsController::class, 'uploadStudyMaterial');
$router->post('/tutor-delete-material', TutorStudyMaterialsController::class, 'deleteStudyMaterial');
$router->post('/tutor-update-material', TutorStudyMaterialsController::class, 'updateStudyMaterial');
$router->get('/tutor-fee-request', TutorFeeRequestController::class, 'showFeeRequestPage'); 
$router->post('/submit-upgrade-request', TutorFeeRequestController::class, 'submitLevelUpgradeRequest');
$router->post('/submit-upgrade-request', TutorFeeRequestController::class, 'submitLevelUpgradeRequest');
$router->post('/cancel-upgrade-request', TutorFeeRequestController::class, 'cancelUpgradeRequest');
$router->get('/tutor-timeslot', TutorTimeSlotController::class, 'showTutorTimeSlotPage'); 
$router->post('/tutor-timeslot-save', TutorTimeSlotController::class, 'saveTutorTimeSlots');
$router->get('/tutor-student-profile/{id}', TutorStudentProfileController::class, 'showTutorStudentProfile');
// Tutor inbox
$router->get('/tutor-inbox', TutorInboxController::class, 'showInbox');
$router->post('/tutor-inbox', TutorInboxController::class, 'showInbox'); // Handle search form submission
$router->get('/tutor-inbox-message/{id}', TutorInboxController::class, 'showMessage');
$router->post('/tutor-inbox-archive/{id}', TutorInboxController::class, 'archiveMessage');
$router->post('/tutor-inbox-unarchive/{id}', TutorInboxController::class, 'unarchiveMessage');
$router->post('/tutor-inbox-reply/{id}', TutorInboxController::class, 'replyToMessage');
// Tutor compose message routes
$router->get('/tutor-compose-message', TutorInboxController::class, 'showComposeForm');
$router->post('/tutor-send-message', TutorInboxController::class, 'sendMessage');
// Tutor outbox routes
$router->get('/tutor-outbox', TutorInboxController::class, 'showOutbox');
$router->post('/tutor-outbox', TutorInboxController::class, 'showOutbox'); // For handling search in outbox
$router->get('/tutor-outbox-message/{id}/{type}', TutorInboxController::class, 'showSentMessage');
// Tutor Inbox(?)
$router->get('/tutor-inbox', TutorInboxController::class, 'index'); // Show inbox
$router->post('/tutor-inbox/send', TutorInboxController::class, 'sendMessage'); // Handle sending a message
// tutor cashout
if (isset($_GET['action'])) { 
    $action = $_GET['action'];
    $controller = new \App\Controllers\tutor\TutorCashoutController();
    switch ($action) {
        case 'cashout':
            $controller->showCashout();
            break;
        case 'process_cashout':
            $controller->processCashout();
            break;
        case 'cashout_success':
            $controller->cashoutSuccess();
            break;
        case 'cashout_cancel':
            $controller->cashoutCancel();
            break;
        default:
            throw new \Exception("No route found for URI: /index.php?action=$action");
    }
    exit; // Ensure no further code is executed
}


//student profile for admin
$router->get('/admin-student-profile/{id}', AdminStudentController::class, 'showStudentProfile');


//admin routes
$router->get('/admin-login', AdminLoginController::class, 'showLoginPage');
$router->post('/admin-login', AdminLoginController::class, 'checkAdminLogin');
$router->get('/admin-dashboard', AdminDashboardController::class, 'showDashboard');
$router->get('/admin-logout', AdminLoginController::class, 'logout');

//admin sessions
$router->get('/admin-sessions', adminSessionController::class, 'showAllSessions');

//search sessions
$router->post('/admin-sessions', adminSessionController::class, 'showAllSessions');

// Admin point purchase/cashout
$router->get('/admin-points', adminPointsController::class, 'showAllPoints');
// Search/filter points
$router->post('/admin-points', adminPointsController::class, 'showAllPoints');

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
$router->post('/admin-deleted-students', AdminStudentController::class, 'searchStudents');//deleted students
//student filter
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
//student block profile/set to blocked
// Add this with your other route definitions
$router->get('/admin-blocked-students', AdminStudentController::class, 'showBlockedStudents');
$router->post('/admin-block-student/{id}', AdminStudentController::class, 'blockStudentProfile');
$router->post('/admin-unblock-student/{id}', AdminStudentController::class, 'unblockStudentProfile');

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
$router->post('/admin-settings', AdminSettingsController::class, 'updateSettings'); // Handle form submission

//admin inbox
$router->get('/admin-inbox', AdminInboxController::class, 'showInbox');
$router->post('/admin-inbox', AdminInboxController::class, 'showInbox'); // Handle search form submission
$router->get('/admin-inbox-message/{id}', AdminInboxController::class, 'showMessage');
$router->post('/admin-inbox-archive/{id}', AdminInboxController::class, 'archiveMessage');
$router->post('/admin-inbox-unarchive/{id}', AdminInboxController::class, 'unarchiveMessage');
$router->post('/admin-inbox-reply/{id}', AdminInboxController::class, 'replyToMessage');
// Admin compose message routes
$router->get('/admin-compose-message', AdminInboxController::class, 'showComposeForm');
$router->post('/admin-send-message', AdminInboxController::class, 'sendMessage');

// Admin outbox routes
$router->get('/admin-outbox', AdminInboxController::class, 'showOutbox');
$router->post('/admin-outbox', AdminInboxController::class, 'showOutbox'); // For handling search in outbox
$router->get('/admin-outbox-message/{id}/{type}', AdminInboxController::class, 'showSentMessage');
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

$router->get('/admin-tutor-reports', AdminInboxController::class, 'showTutorReports');
$router->get('/admin-tutor-report/{id}', AdminInboxController::class, 'showTutorReport');

//transactions
$router->get('/admin-transactions', AdminTransactionController::class, 'showTransactions'); // Show all transactions and handle search
$router->post('/admin-transactions', AdminTransactionController::class, 'showTransactions'); // Allow search functionality

//refund with id
$router->post('/admin-refund/{id}', AdminTransactionController::class, 'refund');

// Admin tutor routes
$router->get('/admin-tutors', adminTutorController::class, 'showAllTutors');
$router->post('/admin-tutors', adminTutorController::class, 'searchTutors');
$router->post('/admin-deleted-tutors', adminTutorController::class, 'searchTutors');
$router->get('/admin-deleted-tutors', adminTutorController::class, 'showDeletedTutors');
$router->get('/admin-tutor-profile/{id}', adminTutorController::class, 'showTutorProfile');
$router->get('/admin-edit-tutor-profile/{id}', adminTutorController::class, 'editTutorProfile');
$router->post('/admin-update-tutor-profile/{id}', adminTutorController::class, 'updateTutorProfile');
$router->post('/tutor-delete-profile/{id}', adminTutorController::class, 'deleteTutorProfile');
$router->post('/admin-restore-tutor/{id}', adminTutorController::class, 'restoreTutorProfile');
// GET route for displaying the blocked tutors page
$router->get('/admin-blocked-tutors', adminTutorController::class, 'showBlockedTutors');

$router->post('/admin-update-tutor-advertisement', adminTutorController::class,'updateTutorAdvertisement');
$router->post('/admin-delete-tutor-advertisement', adminTutorController::class,'deleteTutorAdvertisement');
$router->post('/admin-select-tutor-advertisement', adminTutorController::class,'selectTutorAdvertisement');

// POST route for handling search/filter submissions on the blocked tutors page
$router->post('/admin-blocked-tutors',  adminTutorController::class, 'searchTutors');

// Block/unblock routes - fix duplicate and inconsistent casing
$router->post('/admin-block-tutor/{id}',  adminTutorController::class, 'blockTutorProfile');
$router->post('/admin-unblock-tutor/{id}',  adminTutorController::class, 'unblockTutorProfile');

// Tutor request routes
$router->get('/admin-tutor-requests', adminTutorController::class, 'showTutorRequests');
$router->post('/admin-tutor-requests', adminTutorController::class, 'searchTutors');
$router->post('/admin-approve-tutor/{id}', adminTutorController::class, 'approveTutorRequest');
$router->post('/admin-reject-tutor/{id}', adminTutorController::class, 'rejectTutorRequest');
$router->get('/download-qualification-proof/{id}', adminTutorController::class, 'downloadQualificationProof');

// Tutor upgrade requests routes
$router->get('/admin-tutor-upgrade-requests', adminTutorController::class, 'showTutorUpgradeRequests');
$router->post('/admin-tutor-upgrade-requests', adminTutorController::class, 'searchTutorUpgradeRequests');

// Tutor upgrade request details route
$router->get('/admin-tutor-upgrade-details/{id}', adminTutorController::class, 'showUpgradeRequestDetails');

// Approve/reject upgrade request routes
$router->post('/admin-approve-upgrade/{id}', adminTutorController::class, 'approveUpgradeRequest');
$router->post('/admin-reject-upgrade/{id}', adminTutorController::class, 'rejectUpgradeRequest');

//tutor study materials /download-material/38
$router->get('/download-material/{id}', adminTutorController::class, 'downloadStudyMaterial');

// Update advertisement
$router->post('/admin-update-advertisement/{id}', adminTutorController::class,'updateAdvertisement');

// Delete advertisement
$router->get('/admin-delete-advertisement/{id}', adminTutorController::class,'deleteAdvertisement');

// Add new advertisement
$router->post('/admin-add-advertisement', adminTutorController::class,'addAdvertisement');

//manager routes
$router->get('/manager-login', ManagerLoginController::class, 'showLoginPage');
$router->post('/manager-login', ManagerLoginController::class, 'checkManagerLogin');
$router->get('/manager-dashboard', ManagerDashboardController::class, 'showDashboard');
$router->get('/manager-logout', ManagerDashboardController::class, 'logout');
$router->get('/manager-announcement', ManagerAnnouncementController::class, 'getAnnouncements');


$router->dispatch();

