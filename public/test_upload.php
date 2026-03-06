<!DOCTYPE html>
<html>

<head>
    <title>Test Upload</title>
</head>

<body>
    <h1>Debug Information</h1>

    <?php
    require_once '../app/config/config.php';

    echo "<h2>Configuration Check:</h2>";
    echo "APPROOT: " . APPROOT . "<br>";
    echo "UPLOAD_DIR: " . UPLOAD_DIR . "<br>";
    echo "UPLOAD_URL: " . UPLOAD_URL . "<br>";
    echo "Directory exists: " . (is_dir(UPLOAD_DIR) ? 'YES' : 'NO') . "<br>";
    echo "Directory writable: " . (is_writable(UPLOAD_DIR) ? 'YES' : 'NO') . "<br>";

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['test_image'])) {
        echo "<h2>Upload Test:</h2>";
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";

        if ($_FILES['test_image']['error'] == 0) {
            $filename = 'test_' . time() . '.jpg';
            $upload_path = UPLOAD_DIR . $filename;

            if (move_uploaded_file($_FILES['test_image']['tmp_name'], $upload_path)) {
                echo "<p style='color: green;'>✅ Upload successful! File saved to: $upload_path</p>";
                echo "<img src='" . UPLOAD_URL . $filename . "' style='max-width: 300px;'>";
            } else {
                echo "<p style='color: red;'>❌ Failed to move uploaded file</p>";
            }
        } else {
            echo "<p style='color: red;'>Upload error: " . $_FILES['test_image']['error'] . "</p>";
        }
    }
    ?>

    <h2>Test Upload:</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="test_image" accept="image/*">
        <button type="submit">Test Upload</button>
    </form>
</body>

</html>