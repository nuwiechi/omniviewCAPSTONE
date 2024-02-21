
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Dashboard</title>
        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	    <link rel="stylesheet" href="styles.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="dashboard.php">
                Logo
            </a>
            <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>-->

            <!-- Update the navbar-toggler button to toggle the sidebar -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Add an id to the sidebar div for toggling -->
            <div id="sidebar" class="collapse d-lg-block">
                <!-- Your sidebar content -->
            </div>

            <script type="javascript">
                function toggleSidebar() {
                    document.getElementById("sidebar").classList.toggle("show");
                }
            </script>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            User
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">
                                Manage
                            </a>
                            
                            <a class="dropdown-item" href="#">
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Store
                                </a>
                                    <ul class="nav flex-column ml-3">
                                        <li class="nav-item">
                                            <a class="nav-link" href="product.php">Products</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="customer.php">Customers</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="supplier.php">Suppliers</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Transactions</a>
                                        </li>
                                    </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Books
                                </a>
                                    <ul class="nav flex-column ml-3">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Income</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Expense</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Cashflows</a>
                                        </li>
                                    </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Settings
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Customers</h5>
                                    <?php include_once 'cardCounts/customer_count.php'; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Suppliers</h5>
                                    <?php include_once 'cardCounts/supplier_count.php'; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Products</h5>
                                    <!-- Include products count -->
                                    <?php include_once 'cardCounts/products_count.php'; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Income</h5>
                                    <p class="card-text">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Expense</h5>
                                    <p class="card-text">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Cash Balance</h5>
                                    <p class="card-text">0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <footer class="footer mt-auto py-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <span>All Rights Reserved 2024</span>
                    </div>
                
                    <div class="col-md-6 text-right">
                        <span>Created by ZetoRo (Kodego [Batch {WD92P}])</span>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            // Update Customers and Products cards
            function updateCards() {
                // Update Customers card
                $.ajax({
                    url: 'cardCounts/customer_count.php',
                    success: function (data) {
                        $('#customersCount').text(data);
                    }
                });

                // Update Supplier card
                $.ajax({
                    url: 'cardCounts/supplier_count.php',
                    success: function (data) {
                        $('#supplierCount').text(data);
                    }
                });

                // Update Products card
                $.ajax({
                    url: 'cardCounts/products_count.php',
                    success: function (data) {
                        $('#productsCount').text(data);
                    }
                });
            }

            // Call the updateCards function initially
            updateCards();

            // Refresh the cards every 5 seconds
            setInterval(updateCards, 5000);
        </script>
    </body>
</html>
