<?php
function exception_handler($exception) {
    // Load your error page HTML template
    $error_page = file_get_contents(__DIR__.'/error.html');
    
    // Replace the placeholder with the error message
    $error_page = str_replace('{error_message}', $exception->getMessage(), $error_page);
    
    // Output the error page HTML
    echo $error_page;
}

// Set the custom exception handler function
set_exception_handler('exception_handler');
?>
