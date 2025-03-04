<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css\manager\manager.css">
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <?php require 'sidebar.php'?>    
    <!-- Main Content -->
    <div class="main-content">
      <!-- Navbar -->
      <div class="navbar">
        <div class="menu-toggle">
          <i class="fas fa-bars"></i>
        </div>
        
        <div class="search-bar">
          <input type="text" placeholder="Search...">
          <i class="fas fa-search"></i>
        </div>
        
        <div class="actions">
          <div class="action-btn">
            <i class="far fa-envelope"></i>
            <div class="badge">3</div>
          </div>
          <div class="action-btn">
            <i class="far fa-bell"></i>
            <div class="badge">5</div>
          </div>
          <div class="action-btn">
            <i class="fas fa-th-large"></i>
          </div>
        </div>
      </div>
      
      <!-- Content Area -->
      <div class="content">
        <!-- Dashboard Overview Page -->
        <div class="page active" id="dashboard-page">
          <div class="page-title">
            <h1>Dashboard Overview</h1>
            <button class="add-btn"><i class="fas fa-plus"></i> Add New</button>
          </div>
          
          <div class="cards">
            <div class="card">
              <div class="card-icon">
                <i class="fas fa-bullhorn"></i>
              </div>
              <h3>24</h3>
              <p>Active Announcements</p>
            </div>
            
            <div class="card">
              <div class="card-icon">
                <i class="fas fa-book"></i>
              </div>
              <h3>42</h3>
              <p>Subjects</p>
            </div>
            
            <div class="card">
              <div class="card-icon">
                <i class="fas fa-question-circle"></i>
              </div>
              <h3>18</h3>
              <p>New Visitor Queries</p>
            </div>
            
            <div class="card">
              <div class="card-icon">
                <i class="fas fa-file-alt"></i>
              </div>
              <h3>56</h3>
              <p>Documents</p>
            </div>
          </div>
          
          <div class="table-container">
            <div class="table-header">
              <h3>Recent Visitor Queries</h3>
              <select class="filter-dropdown">
                <option>All Queries</option>
                <option>New</option>
                <option>Processed</option>
              </select>
            </div>
            
            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>John Smith</td>
                  <td>john.smith@example.com</td>
                  <td>Course Information</td>
                  <td>Feb 24, 2025</td>
                  <td><div class="status new">New</div></td>
                  <td class="action-cell">
                    <div class="action-icon view"><i class="far fa-eye"></i></div>
                    <div class="action-icon edit"><i class="far fa-edit"></i></div>
                    <div class="action-icon delete"><i class="far fa-trash-alt"></i></div>
                  </td>
                </tr>
                <tr>
                  <td>Sarah Johnson</td>
                  <td>sarah.j@example.com</td>
                  <td>Admission Query</td>
                  <td>Feb 22, 2025</td>
                  <td><div class="status processed">Processed</div></td>
                  <td class="action-cell">
                    <div class="action-icon view"><i class="far fa-eye"></i></div>
                    <div class="action-icon edit"><i class="far fa-edit"></i></div>
                    <div class="action-icon delete"><i class="far fa-trash-alt"></i></div>
                  </td>
                </tr>
                <tr>
                  <td>Michael Brown</td>
                  <td>m.brown@example.com</td>
                  <td>Document Request</td>
                  <td>Feb 21, 2025</td>
                  <td><div class="status processed">Processed</div></td>
                  <td class="action-cell">
                    <div class="action-icon view"><i class="far fa-eye"></i></div>
                    <div class="action-icon edit"><i class="far fa-edit"></i></div>
                    <div class="action-icon delete"><i class="far fa-trash-alt"></i></div>
                  </td>
                </tr>
                <tr>
                  <td>Emily Davis</td>
                  <td>emily.d@example.com</td>
                  <td>Technical Support</td>
                  <td>Feb 20, 2025</td>
                  <td><div class="status new">New</div></td>
                  <td class="action-cell">
                    <div class="action-icon view"><i class="far fa-eye"></i></div>
                    <div class="action-icon edit"><i class="far fa-edit"></i></div>
                    <div class="action-icon delete"><i class="far fa-trash-alt"></i></div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Announcements Page -->
        <div class="page" id="announcements-page">
          <div class="page-title">
            <h1>Announcements</h1>
            <button class="add-btn" onclick="showForm('announcement-form')"><i class="fas fa-plus"></i> Add Announcement</button>
          </div>
          
          <div class="announcement-card">
            <div class="announcement-header">
              <h3>New Course Registration Open</h3>
              <div class="announcement-actions">
                <div class="action-icon edit"><i class="far fa-edit"></i></div>
                <div class="action-icon delete"><i class="far fa-trash-alt"></i></div>
              </div>
            </div>
            <div class="announcement-body">
              <p>Registration for the Spring semester courses is now open. Students can register through the online portal until March 15, 2025.</p>
            </div>
            <div class="announcement-footer">
              <div>Published: Feb 20, 2025</div>
              <div>Visibility: All Students</div>
            </div>
          </div>
          
          <div class="announcement-card">
            <div class="announcement-header">
              <h3>Campus Maintenance Notice</h3>
              <div class="announcement-actions">
                <div class="action-icon edit"><i class="far fa-edit"></i></div>
                <div class="action-icon delete"><i class="far fa-trash-alt"></i></div>
              </div>
            </div>
            <div class="announcement-body">
              <p>The main campus building will be closed for maintenance on Saturday, March 1, 2025. All classes scheduled for that day will be held online.</p>
            </div>
            <div class="announcement-footer">
              <div>Published: Feb 18, 2025</div>
              <div>Visibility: All Users</div>
            </div>
          </div>
          
          <!-- Announcement Form (hidden by default) -->
          <div class="form-card" id="announcement-form" style="display: none; margin-top: 30px;">
            <h3 style="margin-bottom: 20px;">Add New Announcement</h3>
            
            <div class="form-group">
              <label>Title</label>
              <input type="text" class="form-control" placeholder="Enter announcement title">
            </div>
            
            <div class="form-group">
              <label>Content</label>
              <textarea class="form-control" placeholder="Enter announcement content"></textarea>
            </div>
            
            <div class="form-row">
              <div class="form-group">
                <label>Visibility</label>
                <select class="form-control">
                  <option>All Users</option>
                  <option>Students Only</option>
                  <option>Faculty Only</option>
                  <option>Staff Only</option>
                </select>
              </div>
              
              <div class="form-group">
                <label>Publish Date</label>
                <input type="date" class="form-control">
              </div>
            </div>
            
            <div class="form-actions">
              <button class="submit-btn btn-outline" onclick="hideForm('announcement-form')">Cancel</button>
              <button class="submit-btn">Publish Announcement</button>
            </div>
          </div>
        </div>
        
        <!-- Subjects Page -->
        <div class="page" id="subjects-page">
          <div class="page-title">
            <h1>Subjects</h1>
            <button class="add-btn" onclick="showForm('subject-form')"><i class="fas fa-plus"></i> Add Subject</button>
          </div>
          
          <div class="table-container">
            <div class="table-header">
              <h3>All Subjects</h3>
              <select class="filter-dropdown">
                <option>All Departments</option>
                <option>Computer Science</option>
                <option>Business</option>
                <option>Engineering</option>
              </select>
            </div>
            
            <table>
              <thead>
                <tr>
                  <th>Subject Code</th>
                  <th>Subject Name</th>
                  <th>Department</th>
                  <th>Credits</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>CS101</td>
                  <td>Introduction to Programming</td>
                  <td>Computer Science</td>
                  <td>3</td>
                  <td class="action-cell">
                    <div class="action-icon view"><i class="far fa-eye"></i></div>
                    <div class="action-icon edit"><i class="far fa-edit"></i></div>
                    <div class="action-icon delete"><i class="far fa-trash-alt"></i></div>
                  </td>
                </tr>
                <tr>
                  <td>BUS205</td>
                  <td>Business Ethics</td>
                  <td>Business</td>
                  <td>2</td>
                  <td class="action-cell">
                    <div class="action-icon view"><i class="far fa-eye"></i></div>
                    <div class="action-icon edit"><i class="far fa-edit"></i></div>
                    <div class="action-icon delete"><i class="far fa-trash-alt"></i></div>
                  </td>
                </tr>
                <tr>
                  <td>ENG301</td>
                  <td>Digital Electronics</td>
                  <td>Engineering</td>
                  <td>4</td>
                  <td class="action-cell">