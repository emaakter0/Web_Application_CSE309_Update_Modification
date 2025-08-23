<?php
require('db.php');

header('Content-Type: application/json');

if (isset($_GET['district_id'])) {
    $district_id = intval($_GET['district_id']);
    $sql = "SELECT * FROM kithypups_areas WHERE district_id = $district_id";
    $result = mysqli_query($conn, $sql);
    
    $areas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $areas[] = $row;
    }
    
    echo json_encode($areas);
}
?>