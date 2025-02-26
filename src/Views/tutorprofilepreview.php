<?php
// database_connection.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eguru_full";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch tutor data
$tutor_id = $_GET['id'] ?? 1; // Get tutor ID from URL parameter
$sql = "SELECT profile_image, name, qualification, tutor_level, availability 
        FROM tutors 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$result = $stmt->get_result();
$tutor = $result->fetch_assoc();

// Check if user is logged in
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Profile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto my-8 p-6 bg-white rounded-lg shadow-md">
        <div class="flex flex-col items-center">
            <!-- Profile Image -->
            <img src="<?php echo htmlspecialchars($tutor['profile_image']); ?>" 
                 alt="<?php echo htmlspecialchars($tutor['name']); ?>"
                 class="w-32 h-32 rounded-full object-cover mb-4">
            
            <!-- Tutor Details -->
            <h1 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($tutor['name']); ?></h1>
            <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($tutor['qualification']); ?></p>
            <p class="text-gray-600 mb-2">Level: <?php echo htmlspecialchars($tutor['tutor_level']); ?></p>
            
            <!-- Availability Badge -->
            <div class="mb-4">
                <span class="px-3 py-1 rounded-full text-sm <?php echo $tutor['availability'] === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php echo ucfirst(htmlspecialchars($tutor['availability'])); ?>
                </span>
            </div>

            <!-- Schedule Button -->
            <?php if ($tutor['availability'] === 'available'): ?>
                <button onclick="checkLoginAndSchedule()" 
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                    Schedule Session
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg max-w-md w-full">
            <h2 class="text-xl font-bold mb-4">Login Required</h2>
            <p class="mb-4">Please login to schedule a session with this tutor.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeLoginModal()" 
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Cancel
                </button>
                <a href="login.php" 
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Login
                </a>
            </div>
        </div>
    </div>

    <script>
        function checkLoginAndSchedule() {
            <?php if (!$is_logged_in): ?>
                document.getElementById('loginModal').classList.remove('hidden');
            <?php else: ?>
                window.location.href = 'schedule_session.php?tutor_id=<?php echo $tutor_id; ?>';
            <?php endif; ?>
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }
    </script>
</body>
</html>