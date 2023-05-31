<?php layout('layout', ['title' => 'Update Depense Details']) ?>

<div class="container mt-3">
  <h2>Update Depense Details</h2>

  <form action="<?= url("depense-detail/update/$depenseDetail->id") ?>"
        method="post">
      
    <input type="hidden"
           name="id"
           value="<?= $depenseDetail->id ?>" />

    <input type="hidden"
           name="_method"
           value="PUT" />

    <div class="mb-3">
      <label class="form-label"
             for="depense">
        Depense
      </label>

      <select id="depense"
              name="depense"
              class="form-select <?= has_errors('depense') ? 'is-invalid' : '' ?>">
        <?php foreach ($depenses as $depense): ?>
          <option <?php if (old('depense', $depenseDetail->depense_id) === $depense->id): ?>
                    selected
                  <?php endif; ?>

                  value="<?= $depense->id ?>"><?= $depense->name ?></option>
        <?php endforeach; ?>
      </select>

      <?php if (has_errors('depense')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('depense') as $error): ?>
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
             value="<?= old('amount', $depenseDetail->amount) ?>"
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
             name="depense_detail_date"
             value="<?= old('depense_detail_date', $depenseDetail->depense_detail_date) ?>"
             class="form-control <?= has_errors('depense_detail_date') ? 'is-invalid' : '' ?>"
             placeholder="Date">

      <?php if (has_errors('depense_detail_date')): ?>
        <div class="invalid-feedback">
          <?php foreach (errors('depense_detail_date') as $error): ?>
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