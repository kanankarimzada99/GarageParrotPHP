<?php
$conn = new mysqli("localhost", "username", "password", "database_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $carId = $row["id"];
        $carBrand = $row["brand"];
        $carImages = getCarImages($conn, $carId);
        
        echo "<div class='car'>";
        echo "<h2>{$carBrand}</h2>";
        
        foreach ($carImages as $imagePath) {
            echo "<img class='image' src='{$imagePath}' alt='{$carBrand}'>";
        }
        
        echo "</div>";
    }
} else {
    echo "No cars available.";
}

$conn->close();

function getCarImages($conn, $carId) {
    $images = [];
    $sql = "SELECT image_path FROM images WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $images[] = $row["image_path"];
    }
    
    return $images;
}
