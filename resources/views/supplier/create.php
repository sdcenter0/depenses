<?php layout('layout', ['title' => 'Supplier Create']) ?>

<div class="container mt-3">
  <h2>Create Supplier</h2>

  <form action="store"
        method="post">
    <div class="mb-3">

      <input type="text"
             name="supplier_code"
             value="<?= old('supplier_code') ?>"
             class="form-control <?= has_errors('supplier_code') ? 'is-invalid' : '' ?>"
             placeholder="Supplier Code">

      <?php if (has_errors('supplier_code')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('supplier_code') as $error): ?>
            <div>
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="mb-3">

      <input type="text"
             name="name"
             value="<?= old('name') ?>"
             class="form-control <?= has_errors('name') ? 'is-invalid' : '' ?>"
             placeholder="Supplier Name">

      <?php if (has_errors('name')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('name') as $error): ?>
            <div>
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <input type="submit" value="Save" class="btn btn-primary" />
  </form>
</div>