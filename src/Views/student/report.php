<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Tutor</title>
    <link rel="stylesheet" href="css/student/report.css">
    <link rel="stylesheet" href="css/student/new.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
    <style>
        /* Main layout */
        .main-content {
            margin-left: 250px; /* Adjust based on your sidebar width */
            padding-top: 70px; /* Adjust based on your header height */
            min-height: 100vh;
            background: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Enhanced card styling */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .card h2 {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #495057;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #E14177;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            outline: none;
        }

        /* Button styling */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background:#E14177 ;
            color: white;
        }

        .btn-primary:hover {
            background:#e02362;
            transform: translateY(-1px);
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-available {
            background: #d4edda;
            color: #155724;
        }

        .status-unavailable {
            background: #f8d7da;
            color: #721c24;
        }

        /* Reports table */
        .reports-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1rem;
            margin-left: 2px;
        }

        .reports-table th,
        .reports-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .reports-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }

        .reports-table tr:hover {
            background: #f8f9fa;
        }

        /* Responsive design */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include '../src/Views/student/header.php'; ?>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div class="card">
                <h2>Report a Tutor</h2>
                <p class="text-muted">You can only report tutors with whom you've completed sessions.</p>

                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            echo $_SESSION['success_message']; 
                            unset($_SESSION['success_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            echo $_SESSION['error_message']; 
                            unset($_SESSION['error_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($tutors)): ?>
                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <p>You don't have any completed sessions with tutors yet. You can only report tutors after completing sessions with them.</p>
                    </div>
                <?php else: ?>
                    <form id="reportForm" action="/student/save-report" method="post" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="tutor_id">Select Tutor:</label>
                            <select id="tutor_id" name="tutor_id" class="form-control" required>
                                <option value="" disabled selected>Choose a tutor</option>
                                <?php foreach ($tutors as $tutor): ?>
                                    <option value="<?php echo htmlspecialchars($tutor['tutor_id']); ?>">
                                        <?php echo htmlspecialchars($tutor['name'] . ' (' . $tutor['completed_sessions'] . ' completed sessions)'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="issue_type">Issue Type:</label>
                            <select id="issue_type" name="issue_type" class="form-control" required>
                                <option value="" disabled selected>Select the issue</option>
                                <option value="Misconduct">Misconduct</option>
                                <option value="Inappropriate Behavior">Inappropriate Behavior</option>
                                <option value="Unprofessionalism">Unprofessionalism</option>
                                <option value="Technical Issue">Technical Issue</option>
                                <option value="Payment Issue">Payment Issue</option>
                                <option value="Missed Class">Missed Class</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description of the Issue:</label>
                            <textarea id="description" name="description" class="form-control" rows="6" 
                                    placeholder="Please provide detailed information about the issue..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Previous Reports Section -->
            <div class="card">
                <h2>Your Previous Reports</h2>
                <?php if (!empty($previousReports)): ?>
                    <div class="table-responsive">
                        <table class="reports-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Tutor</th>
                                    <th>Issue Type</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($previousReports as $report): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($report['created_at']))); ?></td>
                                        <td><?php echo htmlspecialchars($report['tutor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($report['issue_type']); ?></td>
                                        <td><?php echo htmlspecialchars($report['description']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No reports submitted yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reportForm');

            // Form validation
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            }
        });
    </script>
</body>
</html>