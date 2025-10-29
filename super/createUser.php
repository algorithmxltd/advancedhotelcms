<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mt. Everest Hotel - Create User</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="styles/addRoom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-container" id="content-container">

                <!-- Page Header -->
                <div class="section-header">
                    <h2>Create User</h2>
                </div>

                <!-- Response Box -->
                <div id="responseBox" class="response-container" style="display:none;">
                    <p id="responseMessage"></p>
                    <button id="closeResponseBtn" class="response-close">Close</button>
                </div>

                <!-- Create User Form -->
                <form id="createUserForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="userName">Full Name</label>
                        <input id="userName" name="userName" type="text" placeholder="Enter full name" required>
                    </div>

                    <div class="form-group">
                        <label for="nationalId">National ID</label>
                        <input id="nationalId" name="nationalId" type="text" placeholder="Enter national ID number" required>
                    </div>

                    <div class="form-group">
                        <label for="userEmail">Email Address</label>
                        <input id="userEmail" name="userEmail" type="email" placeholder="Enter email address" required>
                    </div>

                    <div class="form-group">
                        <label for="userPhone">Phone Number</label>
                        <input id="userPhone" name="userPhone" type="tel" placeholder="Enter phone number" required>
                    </div>

                    <div class="form-group">
                        <label for="userRole">User Role</label>
                        <select id="userRole" name="userRole" required>
                            <option value="">Select User Role</option>
                            <option value="System Admin">System Admin – Full control over all system settings, users, and data.</option>
                            <option value="Senior Admin">Senior Admin – Can manage users, rooms, and bookings, but not system settings.</option>
                            <option value="Standard Admin">Standard Admin – Can manage rooms, guests, and daily operations.</option>
                            <option value="Receptionist">Receptionist – Can handle guest check-ins, check-outs, and basic booking edits.</option>
                            <option value="Auditor">Auditor – Can view records and reports but cannot make any changes.</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <button type="button" class="submit-btn btn-primary" id="submitUserBtn">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/createUser.js"></script>
</body>
</html>