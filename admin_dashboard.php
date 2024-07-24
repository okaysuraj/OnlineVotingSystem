<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Voting System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background: #f4f4f9;
        }
        header {
            background: #4caf50;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            position: fixed;
            width: calc(100% - 250px);
            left: 250px;
            top: 0;
            z-index: 1000;
        }
        .sidebar {
            background: #333;
            color: #ffffff;
            width: 250px;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            transition: width 0.3s;
        }
        .sidebar.retracted {
            width: 60px;
        }
        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #575757;
        }
        .main-content {
            margin-left: 250px;
            margin-top: 70px;
            padding: 20px;
            flex: 1;
        }
        footer {
            background: #4caf50;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: calc(100% - 250px);
            margin-left: 250px;
        }
        h1 {
            margin-top: 0;
            color: #333;
        }
        .box {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            cursor: pointer;
        }
        .box:hover {
            background: #f1f1f1;
        }
        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        button {
            background: #4caf50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #4caf50;
            color: #ffffff;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .toggle-btn {
            background: #333;
            color: #ffffff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <div class="sidebar">
        <a href="#dashboard">Dashboard</a>
        <a href="#add-election">Add Election</a>
        <a href="#add-candidate">Add Candidates</a>
        <a href="#show-results">Show Results</a>
        <a href="#delete-election">Delete Election</a>
    </div>
    <div class="main-content">
        <!-- Dashboard Section -->
        <div id="dashboard">
            <h2>Dashboard</h2>
            <?php
            // Fetch elections from database
            $conn = new mysqli("localhost", "root", "", "voting_system");
            $result = $conn->query("SELECT * FROM elections");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='box' onclick=\"showElectionDetails(" . $row['id'] . ")\">" . htmlspecialchars($row['name']) . "</div>";
            }
            $conn->close();
            ?>
        </div>

        <!-- Add Election Form -->
        <div id="add-election">
            <h2>Add New Election</h2>
            <form method="POST" action="add_election.php">
                <label for="election_name">Election Name:</label>
                <input type="text" id="election_name" name="election_name" required><br>
                <label for="election_date">Election Date:</label>
                <input type="date" id="election_date" name="election_date" required><br>
                <button type="submit">Add Election</button>
            </form>
        </div>

        <!-- Add Candidate Form -->
        <div id="add-candidate">
            <h2>Add New Candidate</h2>
            <form method="POST" action="add_candidate.php">
                <label for="election_id">Select Election:</label>
                <select id="election_id" name="election_id" required>
                    <?php
                    // Populate election dropdown
                    $conn = new mysqli("localhost", "root", "", "voting_system");
                    $result = $conn->query("SELECT * FROM elections");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                    $conn->close();
                    ?>
                </select><br>
                <label for="candidate_name">Candidate Name:</label>
                <input type="text" id="candidate_name" name="candidate_name" required><br>
                <button type="submit">Add Candidate</button>
            </form>
        </div>

        <!-- Show Results -->
        <div id="show-results">
            <h2>Show Results</h2>
            <table>
                <thead>
                    <tr>
                        <th>Election</th>
                        <th>Candidate</th>
                        <th>Votes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch votes from database
                    $conn = new mysqli("localhost", "root", "", "voting_system");
                    $result = $conn->query("
                        SELECT e.name AS election_name, c.name AS candidate_name, c.votes
                        FROM candidates c
                        JOIN elections e ON c.election_id = e.id
                    ");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['election_name']) . "</td>
                                <td>" . htmlspecialchars($row['candidate_name']) . "</td>
                                <td>" . htmlspecialchars($row['votes']) . "</td>
                            </tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Delete Election -->
        <div id="delete-election">
            <h2>Delete Election</h2>
            <form method="POST" action="delete_election.php">
                <label for="delete_election_id">Select Election:</label>
                <select id="delete_election_id" name="delete_election_id" required>
                    <?php
                    // Populate delete dropdown
                    $conn = new mysqli("localhost", "root", "", "voting_system");
                    $result = $conn->query("SELECT * FROM elections");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                    $conn->close();
                    ?>
                </select><br>
                <button type="submit">Delete Election</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Online Voting System. All rights reserved.</p>
    </footer>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('retracted');
            const header = document.querySelector('header');
            header.style.width = sidebar.classList.contains('retracted') ? 'calc(100% - 60px)' : 'calc(100% - 250px)';
            header.style.left = sidebar.classList.contains('retracted') ? '60px' : '250px';
        }

        function showElectionDetails(electionId) {
            // Implement AJAX request or redirect to a details page
            alert('Show details for election ID: ' + electionId);
        }
    </script>
</body>
</html>

