<?php
include 'includes/conn.php';
// $servername = "localhost";
// $username = "u186082990_esp32db";
// $password = "7=AsGXVu?@Ds";
// $dbname = "u186082990_esp32db";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$establishment_id = $_POST['establishment_id'];
$slots = [];

foreach ($_POST as $key => $value) {
    if (strpos($key, "slot") === 0) {
        $slot_number = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
        $slots[$slot_number] = $value;
    }
}

// Update each slot
foreach ($slots as $index => $status) {
    $conn->query("UPDATE parking_slots SET status='$status' WHERE establishment_id='$establishment_id' AND slot_name='Slot $index'");
}

echo "Data updated!";
$conn->close();
?>
