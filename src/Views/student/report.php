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

        /* Enhanced modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 700px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 16px;
            position: relative;
            animation: slideIn 0.3s ease-out;
        }

        .tutor-profile {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e9ecef;
        }

        .tutor-image {
            width: 150px;
            height: 150px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .tutor-basic-info {
            flex: 1;
        }

        .tutor-name {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .tutor-level {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #e9ecef;
            border-radius: 20px;
            color: #495057;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .tutor-subjects {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .subject-tag {
            padding: 0.25rem 0.75rem;
            background: #f8f9fa;
            border-radius: 15px;
            color: #495057;
            font-size: 0.9rem;
        }

        .tutor-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .stat-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
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

            .tutor-profile {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .tutor-subjects {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .modal-content {
                width: 95%;
                margin: 1rem auto;
            }

            .tutor-stats {
                grid-template-columns: 1fr;
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
                    <img 
                                    src="images/student-uploads/<?php echo htmlspecialchars($tutor['tutor_profile_photo']); ?>" 
                                    alt="<?php echo htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']); ?>" 
                                    class="tutor-image"
                                    
                                >
                        <?php 
                            echo $_SESSION['success_message']; 
                            unset($_SESSION['success_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger">
                    <img 
                                    src="images/student-uploads/<?php echo htmlspecialchars($tutor['tutor_profile_photo']); ?>" 
                                    alt="<?php echo htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']); ?>" 
                                    class="tutor-image"
                                    
                                >
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
                                    <th>Status</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($previousReports as $report): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($report['created_at']))); ?></td>
                                        <td><?php echo htmlspecialchars($report['tutor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($report['issue_type']); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $report['status'] === 'Pending' ? 'status-pending' : 'status-review'; ?>">
                                                <?php echo htmlspecialchars($report['status']); ?>
                                            </span>
                                        </td>
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

    <!-- Enhanced Tutor Details Modal -->
    <div id="tutorModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="tutorDetails"></div>
            <button id="confirmTutor" class="btn btn-primary" style="margin-top: 1rem;">Confirm Selection</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reportForm');
            const tutorSelect = document.getElementById('tutor_id');
            const modal = document.getElementById('tutorModal');
            const closeBtn = document.querySelector('.close');
            const confirmBtn = document.getElementById('confirmTutor');
            let selectedTutorId = null;

            // Form validation
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            // Tutor selection handling
            if (tutorSelect) {
                tutorSelect.addEventListener('change', function() {
                    selectedTutorId = this.value;
                    if(selectedTutorId) {
                        fetchTutorDetails(selectedTutorId);
                    }
                });
            }

            // Modal handling
            closeBtn.addEventListener('click', () => modal.style.display = 'none');
            window.addEventListener('click', (e) => {
                if (e.target === modal) modal.style.display = 'none';
            });

            confirmBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // Fetch tutor details
            function fetchTutorDetails(tutorId) {
                fetch('/student/get-tutor-details', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'tutor_id=' + tutorId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.error) {
                        console.error(data.error);
                        return;
                    }
                    
                    const availabilityClass = data.availability === 'available' ? 
                        'status-available' : 'status-unavailable';
                    
                    const detailsHtml = `
                        <div class="tutor-profile">
                            <img src="${data.tutor_profile_photo || 'default-tutor.jpg'}" alt="${data.name}" class="tutor-image">
                            <div class="tutor-basic-info">
                                <h3 class="tutor-name">${data.name}</h3>
                                <div class="tutor-level">${data.tutor_level}</div>
                                <div class="tutor-subjects">
                                    <span class="subject-tag">${data.subject}</span>
                                </div>
                            </div>
                        </div>
                        <div class="tutor-stats">
                            <div class="stat-item">
                                <div class="stat-value">${parseFloat(data.rating).toFixed(1)}</div>
                                <div class="stat-label">Rating</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">Rs. ${data.hour_fees}</div>
                                <div class="stat-label">Per Hour</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">
                                    <span class="status-badge ${availabilityClass}">
                                        ${data.availability}
                                    </span>
                                </div>
                                <div class="stat-label">Status</div>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('tutorDetails').innerHTML = detailsHtml;
                    modal.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorHtml = `
                        <div class="alert alert-danger">
                            <p>Failed to load tutor details. Please try again.</p>
                        </div>
                    `;
                    document.getElementById('tutorDetails').innerHTML = errorHtml;
                });
            }
        });
    </script>
</body>
</html>