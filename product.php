<?php
    // Include database connection file
    include_once 'db_connection.php';

    // Initialize variables for form inputs
    $productName = $stock = $price = '';

    // Check if the form for adding a product is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addProduct'])) {
        $productName = $_POST['productName'];
        $stock = $_POST['stock'];
        $price = $_POST['price'];
        $dateAdded = date('Y-m-d');

        // Insert product data into database
        $sql = "INSERT INTO products (product_name, stock, price, date_added) VALUES ('$productName', '$stock', '$price', '$dateAdded')";

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success" role="alert">Product added successfully!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error adding product: ' . $conn->error . '</div>';
        }

        // Redirect to products page
        header("Location: product.php");
        exit();
    }

    // Update Product
    if (isset($_POST['updateProduct'])) {
        $productId = $_POST['productId'];
        $productName = $_POST['updateProductName'];
        $stock = $_POST['updateStock'];
        $price = $_POST['updatePrice'];
    
        $sql = "UPDATE products SET product_name='$productName', stock='$stock', price='$price', date_updated=NOW() WHERE product_id='$productId'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product updated successfully!')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Redirect to products page
        header("Location: product.php");
        exit();
    }

    // Delete Product
    if (isset($_POST['deleteProduct'])) {
        $productId = $_POST['deleteProductId'];

        $sql = "DELETE FROM products WHERE product_id='$productId'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product deleted successfully!')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Redirect to products page
        header("Location: product.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Products</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	    <link rel="stylesheet" href="styles.css">

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>

    <body>
        <!-- Navbar -->
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

        <!-- Sidebar -->
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="dashboard.php">
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Store
                                </a>
                                    <ul class="nav flex-column ml-3">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Products</a>
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

                <!-- Main content -->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Customers</h1>
                        
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">Create/Add</button>
                    </div>

                    <!-- Filter and Print Buttons -->
                    <div class="row">
                        <!-- Filter Button -->
                        <div class="col-md-6">
                            <!-- Filter Button code goes here -->
                        </div>
                    
                        <!-- Sort and Print Buttons -->
                        <div class="col-md-6 text-right">
                            <!-- Sort Button -->
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#sortModal">Sort</button>
                        
                            <!-- Print Button -->
                            <button class="btn btn-success" id="printButton">Print</button>
                        </div>
                    </div>

                    <!-- Product Table -->
                    <table class="table table-striped" id="productTable">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Display product data here -->
                            <?php
                                $sql = "SELECT * FROM products";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                            echo '<td>' . $row['product_id'] . '</td>';
                                            echo '<td>' . $row['product_name'] . '</td>';
                                            echo '<td>' . $row['stock'] . '</td>';
                                            echo '<td>' . $row['price'] . '</td>';
                                            echo '<td>' . $row['date_added'] . '</td>';
                                            echo '<td>' . $row['date_updated'] . '</td>';
                                            echo '<td>';
                                                echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateProductModal" data-productid="' . $row['product_id'] . '">Update</button>';

                                                echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteProductModal" data-productid="' . $row['product_id'] . '">Delete</button>';
                                            echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="11">No Products found</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>

        <!-- Footer -->
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

        <!-- Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Add Product Form -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="productName">Product Name:</label>
                                <input type="text" class="form-control" id="productName" name="productName" required>
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock:</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="number" class="form-control" id="price" name="price" required>    
                            </div>

                            <button type="submit" class="btn btn-primary" name="addProduct">Done</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Product Modal -->
        <div class="modal fade" id="updateProductModal" tabindex="-1" role="dialog" aria-labelledby="updateProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
                
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Update Product Form -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" id="productId" name="productId">

                            <div class="form-group">
                                <label for="updateProductName">Product Name:</label>
                                <input type="text" class="form-control" id="updateFirstName" name="updateFirstName" required>
                            </div>

                            <div class="form-group">
                                <label for="updateStock">Stock:</label>
                                <input type="number" class="form-control" id="updateStock" name="updateStock" required>
                            </div>

                            <div class="form-group">
                                <label for="updatePrice">Price:</label>
                                <input type="number" class="form-control" id="updatePrice" name="updatePrice" required>    
                            </div>

                            <button type="submit" class="btn btn-primary" name="updateProduct">Update</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Product Modal -->
        <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure you want to delete this product?</p>
                    </div>

                    <div class="modal-footer">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" id="deleteProductId" name="deleteProductId">

                            <button type="submit" class="btn btn-danger" name="deleteProduct">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sort Modal -->
        <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="sortModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sortModalLabel">Sort Products</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="sortForm">
                            <div class="form-group">
                                <label for="sortBy">Sort By:</label>
                                <select class="form-control" id="sortBy">
                                    <option value="product_name">Product Name</option>
                                    <option value="date_added">Date Added</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sortOrder">Sort Order:</label>
                                <select class="form-control" id="sortOrder">
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="applySort">Apply Sort</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript for Modals and Other Functionality -->
        <script>
            // Update Product Modal
            $('#updateProductModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var productId = button.data('productid'); // Extract info from data-* attributes
                var productName = button.closest('tr').find('td:nth-child(2)').text();
                var stock = button.closest('tr').find('td:nth-child(3)').text();
                var price = button.closest('tr').find('td:nth-child(4)').text();

                var modal = $(this);

                modal.find('.modal-body #productId').val(productId);
                modal.find('.modal-body #updateProductName').val(productName);
                modal.find('.modal-body #updateStock').val(stock);
                modal.find('.modal-body #updatePrice').val(price);
            });

            // Delete Product Modal
            $('#deleteProductModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var productId = button.data('productid'); // Extract info from data-* attributes
        
                var modal = $(this);

                modal.find('.modal-footer #deleteProductId').val(productId);
            });

            // Sort Button
            $('#applySort').click(function () {
                var sortBy = $('#sortBy').val();
                var sortOrder = $('#sortOrder').val();

                var sortColumnIndex = 0; // Default sort by the first column (Product ID)
    
                if (sortBy === 'product_name') {
                    sortColumnIndex = 1; // Product Name column
                } else if (sortBy === 'date_added') {
                    sortColumnIndex = 4; // Date Added column
                }

                var rows = $('#productTable tbody').find('tr').get();

                rows.sort(function (a, b) {
                    var aValue = $(a).find('td:nth-child(' + (sortColumnIndex + 1) + ')').text();
                    var bValue = $(b).find('td:nth-child(' + (sortColumnIndex + 1) + ')').text();

                    if (sortOrder === 'asc') {
                        return aValue.localeCompare(bValue);
                    } else {
                        return bValue.localeCompare(aValue);
                    }
                });

                $.each(rows, function (index, row) {
                    $('#productTable tbody').append(row);
                });

                $('#sortModal').modal('hide'); // Close the modal after applying sort
            });

            $(document).ready(function () {
                // Print Button
                $('#printButton').click(function () {
                    var printContents = document.getElementById('productTable').outerHTML;
                    var originalContents = document.body.innerHTML;
                    
                    document.body.innerHTML = '<h2 class="text-center">List of Products</h2><p class="text-center">As of ' + new Date().toLocaleDateString() + '</p><br>' + printContents;
        
                    window.print();
        
                    document.body.innerHTML = originalContents;
                    location.reload();
                });
            });
        </script>
    </body>
</html>
