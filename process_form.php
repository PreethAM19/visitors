<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace "your_username" with your actual MySQL username
$password = ""; // Replace "your_password" with your actual MySQL password
$database = "quarters";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $scannedText = $_POST["scannedTextHidden"]; // Assuming the input field name is "scannedTextHidden"
    $block = $_POST["block"]; // Assuming the input field name is "block"
    $flatNumber = $_POST["flatNumber"]; // Assuming the input field name is "flatNumber"

    // Escape special characters to prevent SQL injection
    $scannedText = $conn->real_escape_string($scannedText);
    $block = $conn->real_escape_string($block);
    $flatNumber = $conn->real_escape_string($flatNumber);

    // Insert data into the database
    $sql = "INSERT INTO meter_readings (block, flat_number, scanned_text) VALUES ('$block', '$flatNumber', '$scannedText')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve data from the database
$sql = "SELECT * FROM meter_readings";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data in a table
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Block</th>
                <th>Flat Number</th>
                <th>Scanned Text</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["block"] . "</td>
                <td>" . $row["flat_number"] . "</td>
                <td>" . $row["scanned_text"] . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>