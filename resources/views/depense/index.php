<?php layout('layout', ['title' => 'Depenses']) ?>

<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Depenses</h2>

    <a class="btn btn-primary"
       href="<?= url('/depense/create') ?>">
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
        <th>Supplier</th>
        <th>Invoice</th>
        <th>Date</th>
        <th>Amount</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($depenses as $depense): ?>
        <tr>
          <td>
            <?= $depense['id'] ?>
          </td>

          <td>
            <?= $depense['name'] ?>
          </td>

          <td>
            <a href="<?= url("/supplier/edit/$depense->supplier_id") ?>">
              <?= $depense->supplier_name ?>
            </a>
          </td>

          <td>
            <?= $depense['invoice'] ?>
          </td>

          <td>
            <?= $depense['depense_date'] ?>
          </td>

          <td>
            <?= $depense['amount'] ?>
          </td>

          <td>
            <a class="btn btn-link"
               href="<?= url("/depense/edit/$depense->id") ?>">
              Edit
            </a>

            <a class="btn btn-link"
               href="<?= url("/depense-detail/index?depense=$depense->id") ?>">
              Details
            </a>

            <form style="display: inline-block"
                  action="<?= url("/depense/delete/$depense->id") ?>"
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

        <tr>
          <td colspan="7">
            <table class="table table-bordered align-middle mb-0">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($depense->depense_details as $item): ?>
                  <tr>
                    <td>
                      <?= $item->id ?>
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