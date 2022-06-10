<nav class="navbar navbar-expand-md navbar-dark nav-back">
      <div class="container">
            <a class="navbar-brand" href="<?= url(); ?>">VTES</a>
           <!-- <img src="cdn/media/images/site/navbar/part_navbar.png" alt="" class="img-fluid" id="img-navbar"> -->

            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="<?= url(); ?>">Principal</a>
                        </li>
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Painel
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?= url('login'); ?>">Login</a></li>
                                    <li><a class="dropdown-item" href="<?= url('register'); ?>">Registro</a></li>
                              </ul>
                        </li>
                  </ul>
            </div>
      </div>
</nav>
