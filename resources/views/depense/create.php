<?php layout('layout', ['title' => 'Depense Create']) ?>

<div class="container mt-3">
  <h2>Create Depense</h2>

  <form action="store"
        method="post">
    <div class="mb-3">
      <label class="form-label"
             for="name">Depense Name</label>
      <input type="text"
             name="name"
             value="<?= old('name') ?>"
             class="form-control <?= has_errors('name') ? 'is-invalid' : '' ?>"
             placeholder="Name">

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

    <div class="mb-3">
      <label class="form-label"
             for="supplier">
        Supplier
      </label>

      <select id="supplier"
              name="supplier"
              class="form-select <?= has_errors('supplier') ? 'is-invalid' : '' ?>">
        <?php foreach ($suppliers as $supplier): ?>
          <option <?php if (old('supplier') === $supplier->id): ?>
                    selected
                  <?php endif; ?>

                  value="<?= $supplier->id ?>"><?= $supplier->name ?></option>
        <?php endforeach; ?>
      </select>

      <?php if (has_errors('supplier')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('supplier') as $error): ?>
            <div>
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label"
             for="name">Amount</label>
      <input type="number"
             name="amount"
             value="<?= old('amount') ?>"
             class="form-control <?= has_errors('amount') ? 'is-invalid' : '' ?>"
             placeholder="Amount">

      <?php if (has_errors('amount')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('amount') as $error): ?>
            <div>
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label"
             for="name">Date</label>
      <input type="date"
             name="depense_date"
             value="<?= old('depense_date') ?>"
             class="form-control <?= has_errors('depense_date') ? 'is-invalid' : '' ?>"
             placeholder="Date">

      <?php if (has_errors('depense_date')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('depense_date') as $error): ?>
            <div>
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label"
             for="name">Invoice</label>
      <input type="text"
             name="invoice"
             value="<?= old('invoice') ?>"
             class="form-control <?= has_errors('invoice') ? 'is-invalid' : '' ?>"
             placeholder="Invoice">

      <?php if (has_errors('invoice')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('invoice') as $error): ?>
            <div>
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label"
             for="nature">Nature</label>
      <input type="text"
             name="nature"
             value="<?= old('nature') ?>"
             class="form-control <?= has_errors('nature') ? 'is-invalid' : '' ?>"
             placeholder="Nature">

      <?php if (has_errors('nature')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('nature') as $error): ?>
            <div>
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label"
             for="type">Type</label>
      <input type="text"
             name="type"
             value="<?= old('type') ?>"
             class="form-control <?= has_errors('type') ? 'is-invalid' : '' ?>"
             placeholder="Type">

      <?php if (has_errors('type')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('type') as $error): ?>
            <div>
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <input type="submit"
           value="Save"
           class="btn btn-primary" />
  </form>
</div>