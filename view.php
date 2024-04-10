<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Videos</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .video-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Center align horizontally */
            align-items: center; /* Center align vertically */
            gap: 20px; /* Add spacing between items */
            padding: 20px; /* Add padding around container */
        }
        .video-item {
            margin: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            background-color:#FDFEFE ;
            justify-content: center;
            color: black;
            padding: 5px 10px;
            width: 250px; /* Set width */
            height: 300px; /* Set height */
            display: flex; /* Enable flexbox */
            flex-direction: column; /* Stack children vertically */
        }
        .video-item img {
            max-width:250px;
            max-height:150px;
            width: 100%; /* Set thumbnail width to fill container */
            height: 100%; /* Set thumbnail height to fill container */
            cursor: pointer;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }
        .video-title {
            margin-top: 5px;
            max-height: 60px; /* Set maximum height for the title */
            text-align: center;
            font-size:clamp(1rem, 2vw, 1.2rem);
            
        }
        .price {
            margin-top: 5px;
            text-align: center;
            font-weight: bold;
        }
        /* Media query for responsiveness */
        @media screen and (max-width: 768px) {
            .video-item {
                width: calc(80% - 10px); /* Adjust width for smaller screens */
                height: auto; /* Let height adjust automatically */
            }
        }
        .button-container{
            display: flex;
            justify-content: center;
            align-items: center;
            
        }
        .view-button {
            margin-top:10px;
            padding: 10px 10px;
            border: none;
            border-radius: 20px;
            background-color: #4CAF50;
            color: white;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5); /* Semi-transparent background */
            overflow: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            margin-right:-15px;
            margin-top: -20px;
            font-size: 20px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .title{
            margin-bottom:1rem;
        }
        .thumbnail{
            max-width:300px;
            max-height:auto;
            width: 100%; /* Set thumbnail width to fill container */
            height: 100%; /
        }
        .video-description{
            margin-bottom:1rem;
        }
        .buttons{
            display:flex;
            justify-content:center;
            align-items:center;
            gap: 10px;
        }
        button{
            padding: 10px 10px;
        }

    </style>
</head>
<body>
<div class="video-container">
    <?php
    function displayOtherVideos() {
        $videoDir = "uploads/";
        $thumbnailDir = "thumbnails/";
        $videos = glob($videoDir . "*.{mp4,avi,mov,wmv,webm}", GLOB_BRACE);

        foreach ($videos as $video) {
            // Get video filename without extension
            $videoName = pathinfo($video, PATHINFO_FILENAME);

            // Remove file extension and any characters after a dot
            $videoTitle = preg_replace('/\.[^.]+$/', '', $videoName);

            $thumbnail = $thumbnailDir . $videoName . ".jpg";
            if (!file_exists($thumbnail)) {
                // Command to generate thumbnail (requires ffmpeg installed)
                $cmd = "ffmpeg -i " . escapeshellarg($video) . " -ss 00:00:01 -vframes 1 " . escapeshellarg($thumbnail);
                // Execute command
                shell_exec($cmd);
            }

            // Connect to the database
            $conn = new mysqli("localhost", "root", "", "mainpagetest");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch price from the database
            $query = "SELECT * FROM mainpage WHERE file_path = '$video'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $price = $row['price'];
            } else {
                $price = "Price not available";
            }

            // Display the video item
            echo "<div class='video-item'>";
            echo "<img src='$thumbnail' alt='Thumbnail'>";
            echo "<div class='video-title'>$videoTitle</div>";
            echo "<div class='price'>PHP$price</div>";
            echo "<div class='button-container'>";
            echo "<button class='view-button' data-video='$video'>View Details</button>";
            echo "</div>";
            echo "</div>";

            // Close the database connection
            $conn->close();
        }
    }
    displayOtherVideos();
    ?>
</div>
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="video-details" id="modal-video-details">
            <!-- Video details will be displayed here -->
        </div>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("modal");

    // Get the <span> element that closes the modal
    var closeBtn = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal and fetch video details
    document.querySelectorAll('.view-button').forEach(item => {
        item.addEventListener('click', event => {
            var videoPath = item.getAttribute('data-video');
            fetchVideoDetails(videoPath);
        });
    });

    // Function to fetch video details via AJAX
    function fetchVideoDetails(videoPath) {
        // Fetch details of the selected video via AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // If request successful, display video details in modal
                    document.getElementById("modal-video-details").innerHTML = xhr.responseText;
                    modal.style.display = "block";
                    modal.style.position = "fixed";
                } else {
                    // If request failed, display error message
                    console.error('Error fetching video details:', xhr.statusText);
                }
            }
        };
        xhr.open("GET", "get_video_details.php?video=" + videoPath, true);
        xhr.send();
    }

    // When the user clicks on <span> (x), close the modal
    closeBtn.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
