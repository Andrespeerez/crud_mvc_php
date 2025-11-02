    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= URLSITE ?>">Inicio</a>
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" 
                           href="#"
                           id="ClientesDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Clientes
                        </a>
                        <ul class="dropdown-menu"
                            aria-labelledby="clientesDropdown">
                            <li><a class="drowpdown-item" href="<?= URLSITE . 'index.php?c=cliente' ?>">Clientes...</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="drowpdown-item" href="<?= URLSITE . 'index.php?c=factura' ?>">Facturas...</a></li>
                        </ul>
                    </li>
                </ul>
                <span class="navbar-text">
                    <a class="nav-item nav-link active"
                       href="<?= URLSITE . '?c=ayuda' ?>">Ayuda</a>
                </span>
            </div>
        </div>
    </nav>