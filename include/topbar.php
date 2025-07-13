<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-1 static-top">
    <ul class="navbar-nav ml-auto align-items-center">
        <!-- Search Dropdown (hidden) -->
        <li class="nav-item dropdown no-arrow d-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?" aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- User Info - Responsive Display -->
        <li class="nav-item no-arrow mx-1">
            <div class="nav-link">
                <!-- Desktop View (lg and up) -->
                <div class="d-none d-lg-flex align-items-center bg-white rounded-pill px-3 py-1 " style="gap: 1rem;">
                    <div class="d-flex flex-column text-center px-2 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">USER ID</span>
                        <span class="text-sm text-dark"><?php echo $_SESSION['user_id'] ?></span>
                    </div>
                    <div class="d-flex flex-column text-center px-2 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">STATE</span>
                        <span class="text-sm text-dark"><?php echo $_SESSION['state'] ?></span>
                    </div>
                    <div class="d-flex flex-column text-center px-2 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">DISTRICT</span>
                        <span class="text-sm text-dark"><?php echo $_SESSION['district_name'] ?></span>
                    </div>
                    <div class="d-flex flex-column text-center px-2 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">BLOCK</span>
                        <span class="text-sm text-dark"><?php echo $_SESSION['block_name'] ?></span>
                    </div>
                    <div class="d-flex flex-column text-center px-2 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">PANCHAYAT</span>
                        <span class="text-sm text-dark"><?php echo $_SESSION['panchayat_name'] ?></span>
                    </div>
                    <div class="d-flex flex-column text-center px-2 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">VILLAGE</span>
                        <span class="text-sm text-dark"><?php echo $_SESSION['village_name'] ?></span>
                    </div>
                    <div class="d-flex flex-column text-center px-2">
                        <span class="text-xs font-weight-bold text-muted">LGD CODE</span>
                        <span class="text-sm text-dark"><?php echo $_SESSION['panchayat_code'] ?></span>
                    </div>
                </div>
                
                <!-- Tablet View (md) -->
                <div class="d-none d-md-flex d-lg-none align-items-center bg-white rounded-pill px-2 py-1" style="gap: 0.5rem;">
                    <div class="d-flex flex-column text-center px-1 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">USER</span>
                        <span class="text-xs text-dark"><?php echo substr($_SESSION['user_id'], 0, 6) ?>..</span>
                    </div>
                    <div class="d-flex flex-column text-center px-1 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">STATE</span>
                        <span class="text-xs text-dark"><?php echo substr($_SESSION['state'], 0, 10) ?>..</span>
                    </div>
                    <div class="d-flex flex-column text-center px-1 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">DIST</span>
                        <span class="text-xs text-dark"><?php echo substr($_SESSION['district_name'], 0, 8) ?>..</span>
                    </div>
                    <div class="d-flex flex-column text-center px-2 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">BLOCK</span>
                        <span class="text-xs text-dark"><?php echo $_SESSION['block_name'] ?></span>
                    </div>
                    <div class="d-flex flex-column text-center px-1">
                        <span class="text-xs font-weight-bold text-muted">PANCH</span>
                        <span class="text-xs text-dark"><?php echo substr($_SESSION['panchayat_name'], 0, 8) ?>..</span>
                    </div>
                     <div class="d-flex flex-column text-center px-2 border-end border-light">
                        <span class="text-xs font-weight-bold text-muted">VILLAGE</span>
                        <span class="text-xs text-dark"><?php echo $_SESSION['village_name'] ?></span>
                    </div>
                    <div class="d-flex flex-column text-center px-2">
                        <span class="text-xs font-weight-bold text-muted">LGD CODE</span>
                        <span class="text-xs text-dark"><?php echo $_SESSION['panchayat_code'] ?></span>
                    </div>
                </div>
                
                <!-- Mobile View (sm and down) - Icon with dropdown -->
                <div class="d-flex d-md-none">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="mobileInfoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-info-circle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-3" style="min-width: 250px;" aria-labelledby="mobileInfoDropdown">
                            <div class="row small">
                                <div class="col-6 mb-2">
                                    <div class="font-weight-bold text-uppercase">User ID</div>
                                    <div><?php echo $_SESSION['user_id'] ?></div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="font-weight-bold text-uppercase">State</div>
                                    <div><?php echo $_SESSION['state'] ?></div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="font-weight-bold text-uppercase">District</div>
                                    <div><?php echo $_SESSION['district_name'] ?></div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="font-weight-bold text-uppercase">Block</div>
                                    <div><?php echo $_SESSION['block_name'] ?></div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="font-weight-bold text-uppercase">Panchayat</div>
                                    <div><?php echo $_SESSION['panchayat_name'] ?></div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="font-weight-bold text-uppercase">Village</div>
                                    <div><?php echo $_SESSION['village_name'] ?></div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="font-weight-bold text-uppercase">LGD Code</div>
                                    <div><?php echo $_SESSION['panchayat_code'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>

        <!-- Alerts (hidden) -->
        <li class="nav-item dropdown no-arrow d-none mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts Center</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2019</div>
                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account!
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: We've noticed unusually high spending for your account.
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Profile -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 40px; height: 40px;">
                <span class="ml-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['user_name']; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" style="position: absolute; z-index:3;">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<?php include('./include/logoutModal.php'); ?>