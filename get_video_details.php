<?php
// Check if the 'video' parameter is set in the URL
if (isset($_GET['video'])) {
    $videoName = $_GET['video'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "mainpagetest");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch details of the video based on its title
    $query = "SELECT * FROM mainpage WHERE file_path = '$videoName'";
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = $row['price'];
        $diff = $row['difficulty'];
        $category = $row['category'];
        $description = $row['course_description'];

        // Get the video name without extension
        $videoNameWithoutExt = pathinfo($videoName, PATHINFO_FILENAME);

        // Construct the thumbnail path
        $thumbnailPath = "thumbnails/" . $videoNameWithoutExt . ".jpg";

        // Display the video details along with the thumbnail
        echo "<div class='video-details'>";
        echo "<img class='thumbnail'src='$thumbnailPath' alt='Thumbnail'>";
        echo "<h2 class='title'>$videoNameWithoutExt</h2>";
        echo "<div class='video-description'>";
        echo "<p><strong>Difficulty:</strong> $diff</p>";
        echo "<p style='margin-bottom: 10px;'><strong>Category:</strong> $category</p>";
        echo "<p style='margin-bottom: 10px;'>PHP$price</p>";
        echo "<p style='margin-bottom: 10px;'><strong>Description:</strong> $description</p>";
        echo "</div>";
        echo "<div class ='buttons'>";
        echo "<button class='add-btn'>ADD TO CART</button>";
        echo "<button class='buy-btn'>BUY NOW!</button>";
        echo "</div>";
    } else {
        echo "Video details not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
