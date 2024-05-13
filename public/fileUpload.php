<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileData = $_POST['fileData'];
    $fileName = $_POST['fileName'];
    $fileType = $_POST['fileType'];

    // Decode the base64 string to binary data
    $binaryData = base64_decode($fileData);

    // Assuming you have a database connection set up and ready to go
    // Prepare a MySQL query to insert binary data into a BLOB field
    $query = $conn->prepare("INSERT INTO files (filename, filetype, content) VALUES (?, ?, ?)");
    $query->bind_param("ssb", $fileName, $fileType, $null);
    $query->send_long_data(2, $binaryData);

    if ($query->execute()) {
        echo "File uploaded successfully";
    } else {
        echo "File upload failed: " . $conn->error;
    }

    $query->close();
    $conn->close();
} else {
    echo "No file uploaded.";
}




require_once dirname(__DIR__, 1) . "/autoload.php";




// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     if (isset($_FILES["uploadedFile"]) && $_FILES["uploadedFile"]["error"] == 0) {
//         $filePath = $_FILES["uploadedFile"]["tmp_name"];
//         $blob = fopen($filePath, "rb");
//         $binaryContent = stream_get_contents($blob);

//         $query = $conn->prepare("INSERT INTO file (content) VALUES (?)");
//         $query->bind_param("b", $null);
//         $query->send_long_data(0, $binaryContent);

//         if ($query->execute()) {
//             echo "File uploaded successfully";
//         } else {
//             echo "File upload failed";
//         };
        
//         $query->close();
//         fclose($blob);
//     } else {
//         echo "Error: " . $_FILES['uploadedFile']['error'];
//     }
//     $conn->close();
// } else {
//     echo "Please upload a file.";
// }       
?>