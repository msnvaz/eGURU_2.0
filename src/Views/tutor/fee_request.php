<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Fee Requests</title>
    <script src="request.js"></script>
    <link rel="stylesheet" href="/css/tutor/fee_request.css">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    
    
    </head>
<body>

<?php $page="fee-request"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>

<?php
$successMessage = isset($_GET['success']) && !empty($_GET['success']) ? $_GET['success'] : null;
$errorMessage = isset($_GET['error']) && !empty($_GET['error']) ? $_GET['error'] : null;
?>

<?php if ($successMessage || $errorMessage): ?>
    <div id="messageModal" class="modal" style="display: block;">
        <div class="modal-content">
            <span class="close" onclick="closeMessageModal()">&times;</span>
            <h2><?= $successMessage ? 'Success' : 'Error' ?></h2>
            <hr style="color:#adb5bd;">
            <br>
            <p style="text-align:center; color: <?= $successMessage ? 'black' : 'red' ?>;">
                <?= htmlspecialchars($successMessage ?? $errorMessage) ?>
            </p>
            <div class="modal-actions" >
                <button style="margin-left:43%;" class="confirm-button" onclick="closeMessageModal()">OK</button>
            </div>
        </div>
    </div>
<?php endif; ?>


<script>
    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
        const url = new URL(window.location);
        url.searchParams.delete('success');
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url);
    }
</script>



    <div class="upgrade-form">
        <h2>Tutor Level Details</h2>
        <table class="tutor-level-table">
    <thead>
        <tr>
            <th>Tutor Level</th>
            <th>Qualification</th>
            <th>Pay Per Hour</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tutorLevels)): ?>
            <?php foreach ($tutorLevels as $level): ?>
                <tr class="<?= $level['tutor_level_id'] == $currentLevel ? 'current-level' : '' ?>">
                    <td><?= htmlspecialchars($level['tutor_level']) ?></td>
                    <td><?= htmlspecialchars($level['tutor_level_qualification']) ?></td>
                    <td>Rs. <?= htmlspecialchars($level['tutor_pay_per_hour']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No tutor levels found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>


        <br>
    
        <div class="request-box">
            <h2>Request Tutor Level Upgrade</h2>
            <br>
            <form class="request-form" action="/submit-upgrade-request" method="POST">
                <label for="requested_level">Choose Level to Upgrade To:</label>
                <select name="requested_level" required>
                    <option value="" style="text-align: center;">-- Select --</option>
                    <?php foreach ($tutorLevels as $level): ?>
                        <option style="text-align: center;" value="<?= htmlspecialchars($level['tutor_level_id']) ?>">
                            <?= htmlspecialchars($level['tutor_level']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>


                <label for="request_body">Request Message:</label>
                <textarea name="request_body" rows="4" placeholder="Explain your reason for upgrade..." required></textarea>

                <button type="submit" class="request-button">Submit Request</button>
            </form>
        </div>

        <br><br>

        <h2> Your Request History </h2>

        <br><br>

        <script>
            function showPanel(status) {
                document.querySelectorAll('.request-panel').forEach(p => p.style.display = 'none');
                document.getElementById(status + '-panel').style.display = 'block';
            }
        </script>

        <div class="status-tabs">
            <button  onclick="showPanel('pending')">Pending</button>
            <button onclick="showPanel('accepted')">Accepted</button>
            <button onclick="showPanel('rejected')">Rejected</button>
            <button onclick="showPanel('cancelled')">Cancelled</button>
        </div>

        <?php
        $statuses = ['pending', 'accepted', 'rejected', 'cancelled'];
        foreach ($statuses as $status): 
        ?>
        <div class="request-panel" id="<?= $status ?>-panel" style="<?= $status === 'pending' ? '' : 'display:none;' ?>">
            <h3><?= ucfirst($status) ?> Requests</h3>
            <table>
                <tr>
                    <th>Request Date</th>
                    <th>Current Level</th>
                    <th>Requested Level</th>
                    <th class="table-request-body">Request Message</th>
                    <?php if ($status === 'accepted' || $status === 'rejected' || $status === 'cancelled'):  ?>
                        <th>Status Updated Date</th>
                    <?php endif; ?>
                    <?php if ($status === 'pending'): ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
                <?php foreach ($requests as $req): ?>
                    <?php if ($req['status'] === $status): ?>
                        <tr>
                            <td><?= htmlspecialchars($req['request_date']) ?></td>
                            <td><?= htmlspecialchars($req['current_level_name']) ?></td>
                            <td><?= htmlspecialchars($req['requested_level_name']) ?></td>
                            <td><?= htmlspecialchars($req['request_body']) ?></td>

                            <?php if ($status === 'accepted' || $status === 'rejected' || $status === 'cancelled'): ?>
                                <td><?= htmlspecialchars($req['status_updated_date']) ?></td>
                            <?php endif; ?>

                            <?php if ($status === 'pending'): ?>
                                <td>
                                    <!-- Cancel Button triggers modal -->
                                    <button type="button" class="cancel-button" onclick="openModal('<?= $req['request_id'] ?>')">Cancel</button>

                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endforeach; ?>


    </div>

    <!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Cancel Request</h2>
        <hr style="color:#adb5bd;">
        <br>
        <p>Are you sure you want to cancel this level upgrade request?</p>
        <form action="/cancel-upgrade-request" method="POST">
            <input type="hidden" name="request_id" id="modalRequestId">
            <div class="modal-actions">
                <button type="submit" class="confirm-button">Yes</button>
                <button type="button" class="modal-cancel-button" onclick="closeModal()">No</button>
            </div>
        </form>
    </div>
</div>




<script>
    function openModal(requestId) {
        document.getElementById('modalRequestId').value = requestId;
        document.getElementById('cancelModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }

    // Optional: close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('cancelModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
</script>



        



</body>
</html>