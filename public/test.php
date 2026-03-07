<?php
require_once '../app/bootstrap.php';
echo "Bootstrap loaded\n";
if (class_exists('Core')) {
    echo "Core class found\n";
} else {
    echo "Core class NOT found\n";
    $className = 'Core';
    $file = dirname(__DIR__) . '/app/libraries/' . $className . '.php';
    echo "Checking file: $file\n";
    if (file_exists($file)) {
        echo "File exists\n";
        require_once $file;
        if (class_exists('Core')) {
            echo "Core class found after manual require\n";
        } else {
            echo "Core class still NOT found after manual require\n";
        }
    } else {
        echo "File DOES NOT exist\n";
    }
}
