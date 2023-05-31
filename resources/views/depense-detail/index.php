<?php layout('layout', ['title' => 'Suppliers']) ?>

<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Depense Detail</h2>

    <a class="btn btn-primary"
       href="<?= url('/depense-detail/create') ?>">
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
        <th>Depense Name</th>
        <th>Amount</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($depenseDetails as $item): ?>
        <tr>
          <td>
            <?= $item->id ?>
          </td>

          <td>
            <a href="<?= url("/depense/edit/$item->depense_id") ?>">
              <?= $item->depense_name ?>
            </a>
          </td>

          <td>
            <?= $item->amount ?>
          </td>

          <td>
            <?= $item->depense_detail_date ?>
          </td>

          <td>
            <a class="btn btn-link"
               href="<?= url('/depense-detail/edit/' . $item['id']) ?>">
              Edit
            </a>

            <form style="display: inline-block"
                  action="<?= url("/depense-detail/delete/$item->id") ?>"
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