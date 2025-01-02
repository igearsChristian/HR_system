<?php
//to use the server: enter  php -S localhost:8000 server.php    in the terminal

$requestUri = $_SERVER['REQUEST_URI'];

$basePath = __DIR__ . '/';

$requestedFile = $basePath . ltrim($requestUri, '/'); 

// Handle image requests first
if (preg_match('/^\/assets\/img\/(.+\.(jpg|jpeg|png|gif|svg))$/i', $requestUri, $matches)) {
    $imageFile = $basePath . $matches[0]; // Full path to the requested image file
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
        header('Content-Length: ' . filesize($imageFile)); // Specify content length
        readfile($imageFile);
        exit; // Stop further script execution
    } else {
        http_response_code(404);
        echo '404 Not Found';
        exit; // Stop further script execution
    }
}

if (preg_match('/\.css$/', $requestUri)) {
    $cssFile = __DIR__ . $requestUri; // Full path to the CSS file
    if (file_exists($cssFile)) {
        header('Content-Type: text/css');
        readfile($cssFile);
    } else {
        http_response_code(404);
        echo '404 Not Found';
    }
}

// Serve the index.html file
if ($requestUri === '/') {
    header('Content-Type: text/html');
    readfile('login.html');
}

else if (file_exists($requestedFile) && is_file($requestedFile)) {
    header('Content-Type: text/html');
    readfile($requestedFile);
} else { 
    echo "http not found.";}
