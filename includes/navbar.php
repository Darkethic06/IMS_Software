<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
include('config/config.php');
?>

<header class="header">
    <div class="header__container">
        <img src="https://piccomassimo.in/wp-content/uploads/2023/01/cropped-picco-massimo-logo-512-192x192.png" alt="" class="header__img">
        <a href="#" class="header__logo">SIMA INTERNATIONAL</a>
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
    </div>
</header>
<div class="nav" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="#" class="nav__link nav__logo">
            <i class='bx bx-menu-alt-left'></i>
                <span class="nav__logo-name">SIMA INTERNATIONAL</span>
            </a>

            <div class="nav__list">
                <div class="nav__items">
                    <h3 class="nav__subtitle">Products</h3>

                    <a href="index.php" class="nav__link active">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>

                    <div class="nav__dropdown">
                        <a href="#" class="nav__link">
                        <i class='bx bx-box nav__icon'></i>
                            <span class="nav__name">Inventory</span>
                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="leather.php" class="nav__dropdown-item">Leather</a>
                                <a href="linning.php" class="nav__dropdown-item">Linning</a>
                                <a href="puller.php" class="nav__dropdown-item">Puller</a>
                                <a href="puller.php" class="nav__dropdown-item">Zipper</a>
                                <a href="backing.php" class="nav__dropdown-item">Backing</a>
                                <a href="adhesive.php" class="nav__dropdown-item">Adhesive</a>
                                <a href="tape.php" class="nav__dropdown-item">Weaving Tape</a>
                                <a href="fittings.php" class="nav__dropdown-item">Metal Fittings</a>
                                <a href="packing.php" class="nav__dropdown-item">Packing</a>
                                <a href="thread.php" class="nav__dropdown-item">Thread</a>
                            </div>
                        </div>
                    </div>

                    <div class="nav__dropdown">
                        <a href="#" class="nav__link">
                        <i class='bx bxs-shopping-bags nav__icon'></i>
                            <span class="nav__name">Sampling</span>
                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="create-style.php" class="nav__dropdown-item">Add Style</a>
                                <a href="all-style.php" class="nav__dropdown-item">All Styles</a>
                                <a href="all-costing.php" class="nav__dropdown-item">All Costing</a>
                            </div>
                        </div>
                    </div>
                    <div class="nav__dropdown">
                        <a href="#" class="nav__link">
                        <i class='bx bx-cart-alt nav__icon'></i>
                            <span class="nav__name">Order Management</span>
                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                            
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="create-bo.php" class="nav__dropdown-item">Create Buyers Order </a>
                                <a href="create-po.php" class="nav__dropdown-item">Create Purchase Order </a>
                                <a href="all-bo.php" class="nav__dropdown-item">View Orders</a>
                                <a href="all-po.php" class="nav__dropdown-item">View Purchase Orders</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav__items">
                    <h3 class="nav__subtitle">Admin Activity</h3>

                    <div class="nav__dropdown">
                        <a href="#" class="nav__link">
                        <i class='bx bxs-spreadsheet nav__icon'></i>
                            <span class="nav__name">Default Actions</span>
                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="users.php" class="nav__dropdown-item">Users</a>
                                <a href="buyers.php" class="nav__dropdown-item">Buyers</a>
                                <a href="labours.php" class="nav__dropdown-item">Labours</a>
                                <a href="suppliers.php" class="nav__dropdown-item">Suppliers</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <a href="logout.php" class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Log Out</span>
        </a>
    </nav>
</div>