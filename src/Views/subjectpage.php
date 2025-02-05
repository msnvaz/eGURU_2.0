<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subject Page</title>
  <link rel="stylesheet" href="/css/subjectpage.css">
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="/css/footer.css">

</head>
<body>

<?php include 'navbar.php'; ?> <!-- Include the navbar -->

  <div class="container">
    <header class="header">
      <img src="images/Science.png" alt="Science Logo" class="logo">
      <h1>Science</h1>
      <div class="filter">
        <span>Filter by</span>
        <select id="grade-filter">
          <option value="">Grade</option>
          <option value="Undergraduate">Undergraduate</option>
          <option value="Graduate">Graduate</option>
          <option value="Full-time">Full-time</option>
          <option value="Retired">Retired</option>
        </select>
        <input type="checkbox" id="availability-filter">
        <label for="availability-filter">Availability</label>
      </div>
    </header>

    <div class="tutor-list">
      <div class="tutor-card available">
        <img src="images/tutor_1.jpeg" alt="Ms. Ava James">
        <div class="info">
          <h3>Ms. Ava James</h3>
          <p>Undergraduate Tutor</p>
          <p>Investment per hour: LKR.800</p>
          <div class="rating">⭐⭐⭐⭐⭐</div>
        </div>
        <div class="status available-status">Available</div>
      </div>

      <!-- Display the tutors dynamically -->
      <?php foreach ($tutors as $tutor) { ?>
        <div class="tutor-card available" id="<?php echo $tutor['tutor_id']; ?>">
          
          <div class="info">
            <h3><?php echo htmlspecialchars($tutor['name']); ?></h3>
            <p><?php echo htmlspecialchars($tutor['tutor_level']); ?></p>
            <p>Investment per hour: LKR.<?php echo htmlspecialchars($tutor['hour_fees']); ?></p>
            <div class="rating"><?php echo str_repeat('⭐', $tutor['rating']); ?></div>
          </div>
          <div class="status available-status">Available</div>
        </div>
      <?php } ?>
    </div>


    <button class="subject-page-see-more">See More</button>
  </div>

  <script src="script.js"></script>

  <?php include 'footer.php'; ?> <!-- Include the footer -->

</body>
</html>
