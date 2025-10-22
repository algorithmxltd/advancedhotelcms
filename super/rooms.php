<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mt. Everest Hotel - Rooms</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="../styles/styles.css" />
  <link rel="stylesheet" href="styles/rooms.css" />
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
        <h2>Rooms Overview</h2>

        <div class="search-filter-container">
          <input type="text" id="searchBar" class="search-bar" placeholder="Search by room number...">
          <select id="statusFilter" class="status-filter">
            <option value="all">All Status</option>
            <option value="Available">Available</option>
            <option value="Occupied">Occupied</option>
          </select>
        </div>

        <div class="table-container">
          <table id="roomsTable">
            <thead>
              <tr>
                <th>Room Number</th>
                <th>Type</th>
                <th>Status</th>
                <th>Client</th>
                <th>Price</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $dbFile = __DIR__ . '/includes/db_connect.php';
              if (file_exists($dbFile)) {
                  require_once $dbFile;
              } else {
                  echo "<tr><td colspan='6'>Database connection not found.</td></tr>";
                  exit;
              }

              $conn->set_charset("utf8mb4");
              $sql = "SELECT id, roomNumber, roomType, roomPrice FROM rooms ORDER BY id DESC";
              $result = $conn->query($sql);

              if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      // Randomly assign room status (demo)
                      $status = (rand(0, 1) === 1) ? "Available" : "Occupied";
                      // Hardcoded clients
                      $client = ($status === "Occupied")
                          ? ["John Doe", "Mary Wanjiku", "Ahmed Noor", "Grace Otieno", "David Kim"]
                              [array_rand(["John Doe", "Mary Wanjiku", "Ahmed Noor", "Grace Otieno", "David Kim"])]
                          : "—";

                      echo "<tr>
                              <td>{$row['roomNumber']}</td>
                              <td>{$row['roomType']}</td>
                              <td>{$status}</td>
                              <td>{$client}</td>
                              <td>Ksh " . number_format($row['roomPrice'], 2) . "</td>
                              <td>
                                <a href='room.php?id={$row['id']}' class='view-link'>
                                  <i class='fa-solid fa-eye'></i> Manage
                                </a>
                              </td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='6' style='text-align:center;'>No rooms found.</td></tr>";
              }

              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    const searchBar = document.getElementById('searchBar');
    const statusFilter = document.getElementById('statusFilter');
    const tableRows = document.querySelectorAll('#roomsTable tbody tr');

    function filterTable() {
      const searchTerm = searchBar.value.toLowerCase();
      const selectedStatus = statusFilter.value;

      tableRows.forEach(row => {
        const roomNumber = row.children[0].textContent.toLowerCase();
        const status = row.children[2].textContent;

        const matchesSearch = roomNumber.includes(searchTerm);
        const matchesStatus = selectedStatus === 'all' || status === selectedStatus;

        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
      });
    }

    searchBar.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
  </script>
</body>
</html>
