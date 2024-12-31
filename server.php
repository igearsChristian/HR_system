<?php
//to use the server: enter  php -S localhost:8000 server.php    in the terminal

// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Serve the index.html file
if ($requestUri === '/' || $requestUri === '/index.html') {
    if (file_exists('index.html')) {
        header('Content-Type: text/html');
        readfile('index.html');
    } else {
        http_response_code(404);
        echo '404 Not Found';
    }
}

//phrase 1: try upload a single image requested by test.html in test_server.php 
// if ($requestUri === '/assets/img/logo.png') {
//     $imageFile = __DIR__ . '/assets/img/logo.png'; // Full path to logo.png
//     if (file_exists($imageFile)) {
//         header('Content-Type: image/png');
//         readfile($imageFile);
//     } else {
//         http_response_code(404);
//         echo '404 Not Found';
//     }
// }

//phrase 2: try upload all the images requested by test.html in test_server.php 
// if (preg_match('/^\/assets\/img\/(.+\.(jpg|jpeg|png|gif|svg))$/', $requestUri, $matches)) {
//     $imageFile = __DIR__ . $matches[0]; // Full path to the requested image file
//     if (file_exists($imageFile)) {
//         $extension = pathinfo($imageFile, PATHINFO_EXTENSION);
//         $mimeType = 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension);
//         header('Content-Type: ' . $mimeType);
//         readfile($imageFile);
//     } else {
//         http_response_code(404);
//         echo '404 Not Found';
//     }
// }

//phrase 3: try to upload a single svg image requested by test.html in test_server.php 
if (preg_match('/^\/assets\/img\/(.+\.(jpg|jpeg|png|gif|svg))$/', $requestUri, $matches)) {
    $imageFile = __DIR__ . '/' . $matches[0]; // Full path to the requested image file
    if (file_exists($imageFile)) {
        $extension = pathinfo($imageFile, PATHINFO_EXTENSION);
        
        // Determine the correct MIME type
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $mimeType = 'image/jpeg';
                break;
            case 'png':
                $mimeType = 'image/png';
                break;
            case 'gif':
                $mimeType = 'image/gif';
                break;
            case 'svg':
                $mimeType = 'image/svg+xml';
                break;
            default:
                $mimeType = 'application/octet-stream'; // Fallback type
                break;
        }
        
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($imageFile)); // Optional: Specify content length
        readfile($imageFile);
        exit; // Stop further script execution
    } else {
        http_response_code(404);
        echo '404 Not Found';
    }
}


// Serve CSS files
elseif (preg_match('/\.css$/', $requestUri)) {
    $cssFile = __DIR__ . $requestUri; // Full path to the CSS file
    if (file_exists($cssFile)) {
        header('Content-Type: text/css');
        readfile($cssFile);
    } else {
        http_response_code(404);
        echo '404 Not Found';
    }
} else {
    http_response_code(404);
    echo '404 Not Found';
}





?>