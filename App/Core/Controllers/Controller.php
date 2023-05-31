<?php

namespace App\Core\Controllers;

use App\Core\Validations\ValidationException;
use App\Core\Validations\Validator;

abstract class Controller
{
  /**
   * @var array $request The request data
   * 
   */
  protected $request;

  public function __construct()
  {
    $this->request = $_REQUEST;
  }

  /**
   * Render a view file
   * 
   * @param string $view The view file name
   * @param array $data The data to be passed to the view
   * 
   * @return string The rendered view
   */
  public function render($view, $data = [])
  {
    // Extract data to variables
    extract($data);

    $path = dirname(dirname(dirname(__DIR__))) . "/resources/views/{$view}.php";

    // Start output buffering
    ob_start();

    // Include view file
    include_once $path;

    // Get content of the buffer
    $content = ob_get_contents();

    // Clean the buffer
    ob_end_clean();

    // Return content
    return $content;
  }

  /**
   * Redirect to a URL
   * 
   * @param string $url The URL to redirect to
   * 
   * @return void
   */
  public function redirect($url)
  {
    if (strpos($url, 'http') === false) {
      if (strpos($url, '/') !== 0) {
        $url = "/{$url}";
      }

      $url = BASE_URL . $url;
    }

    header("Location: {$url}");

    exit;
  }

  /**
   * Validate the request data
   * 
   * @param array $rules The validation rules
   * 
   * @return void
   * 
   * @throws ValidationException
   */
  public function validate(array $rules)
  {
    Validator::make($this->request, $rules)->validate();
  }
}