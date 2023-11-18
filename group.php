<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fairshare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedGroup = $_POST['group'];
    $newGroup = $_POST['newGroup'];

    if (!empty($newGroup)) {
        // Insert new group into the database
        $stmt = $conn->prepare("INSERT INTO groups (group_name) VALUES (?)");
        $stmt->bind_param("s", $newGroup);
        $stmt->execute();
        $stmt->close();
        header("Location: members.html");
        exit();
    } elseif (!empty($selectedGroup)) {
        header("Location: members.html");
        // Use the selected group as needed
        // You can add logic here to load the selected group's data.
    }
}

// Fetch existing groups from the database
$existingGroups = [];
$result = $conn->query("SELECT group_name FROM groups");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $existingGroups[] = $row['group_name'];
    }
}

$conn->close();
?>