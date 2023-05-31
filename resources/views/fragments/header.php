<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand"
       href="#">
      <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg"
           alt=""
           width="30"
           height="24"
           class="d-inline-block align-text-top">
    </a>

    <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse"
         id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= is_active('/supplier') ? 'active' : '' ?>"
             aria-current="page"
             href="<?= url('/supplier') ?>">
            Suppliers
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?= is_active('/depense') ? 'active' : '' ?>"
             href="<?= url('/depense') ?>">
            Depenses
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>