<?php layout('layout', ['title' => '404']) ?>

<div class="d-flex flex-column align-items-center justify-content-center h-100">
  <h1 class="display-1">404</h1>
  <p>Oops!!</p>
  <p class='text-uppercase'>The Page Doesn't exists</p>
  <a href="<?= url('/supplier') ?>" class="btn btn-primary">Back to Home</a>
</div>