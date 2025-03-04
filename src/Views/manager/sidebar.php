<div class="sidebar">
      <div class="sidebar-header">
        <h2><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></h2>
      </div>
      
      <div class="menu">
        <div class="menu-title">Main Menu</div>
        <ul class="menu-items">
          <li class="menu-item active" onclick="showPage('dashboard')">
            <i class="fas fa-home"></i>
            <span>Overview</span>
          </li>
          <li class="menu-item">
            <i class="fas fa-bullhorn"></i>
            <a href="/manager-announcement"><span>Announcement</span></a>
          </li>
          <li class="menu-item" onclick="showPage('subjects')">
            <i class="fas fa-book"></i>
            <span>Subjects</span>
          </li>
          <li class="menu-item" onclick="showPage('queries')">
            <i class="fas fa-question-circle"></i>
            <span>Visitor Queries</span>
          </li>
          <li class="menu-item" onclick="showPage('documents')">
            <i class="fas fa-file-alt"></i>
            <span>Documents</span>
          </li>
        </ul>
        
        <div class="menu-title" style="margin-top: 30px;">Settings</div>
        <ul class="menu-items">
          <li class="menu-item">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
          </li>
          <li class="menu-item">
            <i class="fas fa-user"></i>
            <span>User Management</span>
          </li>
          <li class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <a href="/manager-logout"><span>Logout</span></a>
          </li>
        </ul>
      </div>
      
      <div class="user-profile">
        <div class="avatar">AM</div>
        <div class="user-info">
          <h4>Admin Manager</h4>
          <p>Administrator</p>
        </div>
      </div>
    </div>
