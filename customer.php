<?php
    // Include database connection file
    include_once 'db_connection.php';

    // Initialize variables for form inputs
    $firstName = $middleName = $lastName = $address = $contact = $sales = $status = '';

    // Check if the form for adding a customer is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addCustomer'])) {
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $sales = $_POST['sales'];
        $status = $_POST['status'];
        $dateAdded = date('Y-m-d');

        // Insert customer data into database
        $sql = "INSERT INTO customer (firstname, middlename, lastname, address, contact_number, customer_sales, status, date_added) VALUES ('$firstName', '$middleName', '$lastName', '$address', '$contact', '$sales', '$status', '$dateAdded')";

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success" role="alert">Customer added successfully!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error adding customer: ' . $conn->error . '</div>';
        }

        // Redirect to customers page
        header("Location: customer.php");
        exit();
    }

    // Update Customer
    if (isset($_POST['updateCustomer'])) {
        $customerId = $_POST['customerId'];
        $firstName = $_POST['updateFirstName'];
        $middleName = $_POST['updateMiddleName'];
        $lastName = $_POST['updateLastName'];
        $address = $_POST['updateAddress'];
        $contact = $_POST['updateContact'];
        $sales = $_POST['updateSales'];
        $status = $_POST['updateStatus'];
    
        $sql = "UPDATE customer SET firstname='$firstName', middlename='$middleName', lastname='$lastName', address='$address', contact_number='$contact', customer_sales='$sales', status='$status', date_updated=NOW() WHERE customer_id='$customerId'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Customer updated successfully!')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Redirect to customers page
        header("Location: customer.php");
        exit();
    }

    // Delete Customer
    if (isset($_POST['deleteCustomer'])) {
        $customerId = $_POST['deleteCustomerId'];

        $sql = "DELETE FROM customer WHERE customer_id='$customerId'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Customer deleted successfully!')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Redirect to customers page
        header("Location: customer.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Customers</title>

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
                                            <a class="nav-link" href="product.php">Products</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Customers</a>
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
                            <button class="btn btn-info" data-toggle="modal" data-target="#filterModal">Filter</button>
                        </div>
                    
                        <!-- Sort and Print Buttons -->
                        <div class="col-md-6 text-right">
                            <!-- Sort Button -->
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#sortModal">Sort</button>
                        
                            <!-- Print Button -->
                            <button class="btn btn-success" id="printButton">Print</button>
                        </div>
                    </div>

                    <!-- Customer Table -->
                    <table class="table table-striped" id="customerTable">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Sale</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Display customer data here -->
                            <?php
                                $sql = "SELECT * FROM customer";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                            echo '<td>' . $row['customer_id'] . '</td>';
                                            echo '<td>' . $row['firstname'] . '</td>';
                                            echo '<td>' . $row['middlename'] . '</td>';
                                            echo '<td>' . $row['lastname'] . '</td>';
                                            echo '<td>' . $row['address'] . '</td>';
                                            echo '<td>' . $row['contact_number'] . '</td>';
                                            echo '<td>' . $row['customer_sales'] . '</td>';
                                            echo '<td>' . $row['status'] . '</td>';
                                            echo '<td>' . $row['date_added'] . '</td>';
                                            echo '<td>' . $row['date_updated'] . '</td>';
                                            echo '<td>';
                                                echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateCustomerModal" data-customerid="' . $row['customer_id'] . '">Update</button>';

                                                echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCustomerModal" data-customerid="' . $row['customer_id'] . '">Delete</button>';
                                            echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="11">No customers found</td></tr>';
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

        <!-- Add Customer Modal -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Add Customer Form -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="firstName">First Name:</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>

                            <div class="form-group">
                                <label for="middleName">Middle Name:</label>
                                <input type="text" class="form-control" id="middleName" name="middleName">
                            </div>

                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>

                            <div class="form-group">
                                <label for="contact">Contact:</label>
                                <input type="number" class="form-control" id="contact" name="contact" required>
                            </div>

                            <div class="form-group">
                                <label for="sales">Sales Amount:</label>
                                <input type="number" class="form-control" id="sales" name="sales" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" name="addCustomer">Done</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Customer Modal -->
        <div class="modal fade" id="updateCustomerModal" tabindex="-1" role="dialog" aria-labelledby="updateCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateCustomerModalLabel">Update Customer</h5>
                
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Update Customer Form -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" id="customerId" name="customerId">

                            <div class="form-group">
                                <label for="updateFirstName">First Name:</label>
                                <input type="text" class="form-control" id="updateFirstName" name="updateFirstName" required>
                            </div>

                            <div class="form-group">
                                <label for="updateMiddleName">Middle Name:</label>
                                <input type="text" class="form-control" id="updateMiddleName" name="updateMiddleName">
                            </div>

                            <div class="form-group">
                                <label for="updateLastName">Last Name:</label>
                                <input type="text" class="form-control" id="updateLastName" name="updateLastName" required>
                            </div>

                            <div class="form-group">
                                <label for="updateAddress">Address:</label>
                                <input type="text" class="form-control" id="updateAddress" name="updateAddress" required>
                            </div>

                            <div class="form-group">
                                <label for="updateContact">Contact:</label>
                                <input type="number" class="form-control" id="updateContact" name="updateContact" required>
                            </div>

                            <div class="form-group">
                                <label for="updateSales">Sales Amount:</label>
                                <input type="number" class="form-control" id="updateSales" name="updateSales" required>
                            </div>

                            <div class="form-group">
                                <label for="updateStatus">Status:</label>
                                <select class="form-control" id="updateStatus" name="updateStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" name="updateCustomer">Update</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Customer Modal -->
        <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCustomerModalLabel">Delete Customer</h5>
                    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure you want to delete this customer?</p>
                    </div>

                    <div class="modal-footer">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" id="deleteCustomerId" name="deleteCustomerId">

                            <button type="submit" class="btn btn-danger" name="deleteCustomer">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Customers</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="filterForm">
                            <div class="form-group">
                                <label for="filterStatus">Status:</label>
                                <select class="form-control" id="filterStatus">
                                    <option value="">All</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="applyFilter">Apply Filter</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sort Modal -->
        <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="sortModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sortModalLabel">Sort Customers</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="sortForm">
                            <div class="form-group">
                                <label for="sortBy">Sort By:</label>
                                <select class="form-control" id="sortBy">
                                    <option value="firstname">First Name</option>
                                    <option value="lastname">Last Name</option>
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
            // Update Customer Modal
            $('#updateCustomerModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var customerId = button.data('customerid'); // Extract info from data-* attributes
                var firstName = button.closest('tr').find('td:nth-child(2)').text();
                var middleName = button.closest('tr').find('td:nth-child(3)').text();
                var lastName = button.closest('tr').find('td:nth-child(4)').text();
                var address = button.closest('tr').find('td:nth-child(5)').text();
                var contact = button.closest('tr').find('td:nth-child(6)').text();
                var status = button.closest('tr').find('td:nth-child(7)').text();

                var modal = $(this);

                modal.find('.modal-body #customerId').val(customerId);
                modal.find('.modal-body #updateFirstName').val(firstName);
                modal.find('.modal-body #updateMiddleName').val(middleName);
                modal.find('.modal-body #updateLastName').val(lastName);
                modal.find('.modal-body #updateAddress').val(address);
                modal.find('.modal-body #updateContact').val(contact);
                modal.find('.modal-body #updateSales').val(sales);
                modal.find('.modal-body #updateStatus').val(status);
            });

            // Delete Customer Modal
            $('#deleteCustomerModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var customerId = button.data('customerid'); // Extract info from data-* attributes
        
                var modal = $(this);

                modal.find('.modal-footer #deleteCustomerId').val(customerId);
            });

            // Filter Button
            $('#applyFilter').click(function () {
                var filterStatus = $('#filterStatus').val();

                $('#customerTable tbody tr').each(function () {
                    var status = $(this).find('td:nth-child(8)').text();

                    if (filterStatus === '' || status === filterStatus) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                $('#filterModal').modal('hide'); // Close the modal after applying filter
            });

            // Sort Button
            $('#applySort').click(function () {
                var sortBy = $('#sortBy').val();
                var sortOrder = $('#sortOrder').val();

                var sortColumnIndex = 0; // Default sort by the first column (Customer ID)
    
                if (sortBy === 'firstname') {
                    sortColumnIndex = 1; // First Name column
                } else if (sortBy === 'lastname') {
                    sortColumnIndex = 3; // Last Name column
                } else if (sortBy === 'date_added') {
                    sortColumnIndex = 8; // Date Added column
                }

                var rows = $('#customerTable tbody').find('tr').get();

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
                    $('#customerTable tbody').append(row);
                });

                $('#sortModal').modal('hide'); // Close the modal after applying sort
            });

            $(document).ready(function () {
                // Print Button
                $('#printButton').click(function () {
                    var printContents = document.getElementById('customerTable').outerHTML;
                    var originalContents = document.body.innerHTML;
                    
                    document.body.innerHTML = '<h2 class="text-center">List of Customers</h2><p class="text-center">As of ' + new Date().toLocaleDateString() + '</p><br>' + printContents;
        
                    window.print();
        
                    document.body.innerHTML = originalContents;
                    location.reload();
                });
            });
        </script>
    </body>
</html>
