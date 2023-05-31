<?php layout('layout', ['title' => 'Suppliers']) ?>

<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Supplier</h2>

    <a class="btn btn-primary"
       href="<?= url('/supplier/create') ?>">
      Create
    </a>
  </div>

  <?php if (session_has('success')): ?>
    <div class="alert alert-success">
      <?= session_pop('success') ?>
    </div>
  <?php endif; ?>

  <?php if (session_has('error')): ?>
    <div class="alert alert-danger">
      <?= session_pop('error') ?>
    </div>
  <?php endif; ?>

  <table class="table table-bordered align-middle">
    <thead>
      <tr>
        <th>Id</th>
        <th>Supplier Code</th>
        <th>Supplier Name</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($suppliers as $supplier): ?>
        <tr>
          <td>
            <?= $supplier['id'] ?>
          </td>

          <td>
            <?= $supplier['supplier_code'] ?>
          </td>

          <td>
            <?= $supplier['name'] ?>
          </td>

          <td>
            <a class="btn btn-link"
               href="<?= url('/supplier/edit/' . $supplier['id']) ?>">
              Edit
            </a>

            <form style="display: inline-block"
                  action="<?= url("/supplier/delete/$supplier->id") ?>"
                  method="post">

              <input type="hidden"
                     name="_method"
                     value="DELETE">

              <button type="submit"
                      onclick="confirmDelete(event)"
                      class="btn btn-link">
                Delete
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  function confirmDelete(event) {
    if (!confirm('Are you sure?')) {
      event.preventDefault();
    }
  }
</script>