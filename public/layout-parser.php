<?php

$layoutPath = null;
$layoutData = [];

// Set the layout path and data
function layout($path, array $data = [])
{
  ob_start();
  
  global $layoutPath, $layoutData;

  $layoutPath = $path;
  $layoutData = $data;
}

// Shutdown function
function layout_shutdown()
{
  global $layoutPath, $layoutData, $error_triggered;

  $path = $layoutPath;

  $data = $layoutData;

  
  if (!$path) {
    return;
  }
  
  // Get the caller content (the view) and store it in $content
  $content = ob_get_contents();

  // Clean the output buffer
  ob_end_clean();
  
  // If there was an error, we don't want to load the layout
  if ($error_triggered) {
    echo $content;
    return;
  }
  
  // Check if there is a redirect
  foreach (headers_list() as $header) {
    if (preg_match('/^Location/', $header)) {
      return;
    }
  }
  
  // Load the layout and pass the content
  extract($data);
  
  require __DIR__ . "/../resources/views/fragments/{$path}.php";
}

register_shutdown_function('layout_shutdown');