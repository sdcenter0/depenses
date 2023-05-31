<?php layout('layout', ['title' => 'Supplier Edit']) ?>

<div class="container mt-3">
  <h2>Edit Supplier:
    <?= $supplier->name ?>
  </h2>

  <form action="<?= url("/supplier/update/$supplier->id") ?>"
        method="post">

    <input type="hidden"
           name="id"
           value="<?= $supplier->id ?>" />

    <input type="hidden"
           name="_method"
           value="PUT" />

    <div class="mb-3">
      <input type="text"
             name="supplier_code"
             value="<?= old('supplier_code', $supplier->supplier_code) ?>"
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
             value="<?= old('name', $supplier->name) ?>"
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

    <input class="btn btn-primary"
           value="Save"
           type="submit" />
  </form>
</div>