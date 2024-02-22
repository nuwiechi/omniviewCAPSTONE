<?php
    // Include database connection file
    include_once 'db_connection.php';

    // Initialize variables for form inputs
    $transactionDate = $description = $amount = $transactionType = '';

    // Check if the form for adding a transaction is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addTransaction'])) {
        $transactionDate = $_POST['transaction_date'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $transactionType = $_POST['transaction_type'];
        $dateAdded = date('Y-m-d');

        // Insert transaction data into database
        $sql = "INSERT INTO transaction_list (transaction_date, description, amount, transaction_type, date_added) VALUES ('$transactionDate', '$description', '$amount', '$transactionType', '$dateAdded')";

        // Update other tables based on transaction type
        switch ($transaction_type) {
            case 'cash_income':
                // Insert transaction data into income_list table
                $sql = "INSERT INTO income_list (transaction_date, description, amount, date_added, date_updated) VALUES ('$transactionDate', '$description', '$amount', NOW(), NOW())";
                break;
            case 'cash_expense':
                // Insert transaction data into expense_list table
                $sql = "INSERT INTO expense_list (transaction_date, description, amount, date_added, date_updated) VALUES ('$transactionDate', '$description', '$amount', NOW(), NOW())";
                break;
            case 'credit_receivable':
                // Insert transaction data into receivable_list table
                $sql = "INSERT INTO receivable_list (transaction_date, description, amount, date_added, date_updated) VALUES ('$transactionDate', '$description', '$amount', NOW(), NOW())";
                break;
            case 'credit_payable':
                // Insert transaction data into payable_list table
                $sql = "INSERT INTO payable_list (transaction_date, description, amount, date_added, date_updated) VALUES ('$transactionDate', '$description', '$amount', NOW(), NOW())";
                break;
            default:
                break;
        }

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success" role="alert">Transaction added successfully!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error adding transaction: ' . $conn->error . '</div>';
        }

        // Redirect to transaction page
        header("Location: transaction.php");
        exit();
    }

    // Update Transaction
    if (isset($_POST['updateTransaction'])) {
        $transactionId = $_POST['transactionId'];
        $transactionDate = $_POST['updateTransactionDate'];
        $description = $_POST['updateDescription'];
        $amount = $_POST['updateAmount'];
        $transactionType = $_POST['updateTransactionType'];
        
        $sql = "UPDATE transaction_list SET transaction_date='$transactionDate', description='$description', amount='$amount', transaction_type='$transactionType', date_updated=NOW() WHERE transaction_id='$transactionId'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Transaction updated successfully!')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Redirect to transaction page
        header("Location: transaction.php");
        exit();
    }

    // Delete Transaction
    if (isset($_POST['deleteTransaction'])) {
        $transactionId = $_POST['deleteTransactionId'];

        $sql = "DELETE FROM transaction_list WHERE transaction_id='$transactionId'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Transaction deleted successfully!')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Redirect to transaction page
        header("Location: transaction.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Transactions</title>

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
                                <hr>
                                    Store
                                </hr>
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
                                <hr>
                                    Books
                                </hr>
                                <ul class="nav flex-column ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="income.php">Income</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="expense.php">Expense</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="receivable.php">Receivables</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="payable.php">Payables</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="cashflow.php">Cashflows</a>
                                    </li>
                                </ul>
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
                        <h1 class="h2">Transactions</h1>
                        
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addTransactionModal">Create/Add</button>
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

                    <!-- Transaction Table -->
                    <table class="table table-striped" id="transactionTable">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Transaction Date</th>
                                <th>Description</th>
                                <th>Total Amount</th>
                                <th>Transaction Type</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Display transaction data here -->
                            <?php
                                // Fetch data from database
                                $sql = "SELECT * FROM transaction_list";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                            echo "<td>" . $row["transaction_id"] . "</td>";
                                            echo "<td>" . $row["transaction_date"] . "</td>";
                                            echo "<td>" . $row["description"] . "</td>";
                                            echo "<td>" . $row["amount"] . "</td>";
                                            echo "<td>" . $row["transaction_type"] . "</td>";
                                            echo "<td>" . $row["date_added"] . "</td>";
                                            echo "<td>" . $row["date_updated"] . "</td>";
                                            echo '<td>';
                                                echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateTransactionModal" data-transactionid="' . $row['transaction_id'] . '">Update</button>';

                                                echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteTransactionModal" data-transactionid="' . $row['transaction_id'] . '">Delete</button>';
                                            echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="11">No transactions found</td></tr>';
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

        <!-- Add Transaction Modal -->
        <div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTransactionModalLabel">Add Transaction</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="transaction_date">Transaction Date</label>
                                <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>

                            <div class="form-group">
                                <label for="amount">Total Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>

                            <div class="form-group">
                                <label for="transaction_type">Transaction Type</label>
                                <select class="form-control" id="transaction_type" name="transaction_type" required>
                                    <option value="cash_income">cash_income</option>
                                    <option value="cash_expense">cash_expense</option>
                                    <option value="credit_receivable">credit_receivable</option>
                                    <option value="credit_payable">credit_payable</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" name="addTransaction">Done</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Transaction Modal -->
        <div class="modal fade" id="updateTransactionModal" tabindex="-1" role="dialog" aria-labelledby="updateTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateTransactionModalLabel">Update Transaction</h5>
                
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Update Transaction Form -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" id="transactionId" name="transactionId">

                            <div class="form-group">
                                <input type="text" class="form-control" id="updateFirstName" name="updateFirstName" required>
                                <label for="updateTransactionDate">Transaction Date</label>
                                <input type="date" class="form-control" id="updateTransactionDate" name="updateTransactionDate" required>
                            </div>

                            <div class="form-group">
                                <label for="updateDescription">Description</label>
                                <input type="text" class="form-control" id="updateDescription" name="updateDescription" required>
                            </div>

                            <div class="form-group">
                                <label for="updateAmount">Total Amount</label>
                                <input type="number" class="form-control" id="updateAmount" name="updateAmount" required>
                            </div>

                            <div class="form-group">
                                <label for="updateTransactionType">Transaction Type</label>
                                <select class="form-control" id="updateTransactionType" name="updateTransactionType" required>
                                    <option value="cash_income">cash_income</option>
                                    <option value="cash_expense">cash_expense</option>
                                    <option value="credit_receivable">credit_receivable</option>
                                    <option value="credit_payable">credit_payable</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" name="updateTransaction">Update</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Transaction Modal -->
        <div class="modal fade" id="deleteTransactionModal" tabindex="-1" role="dialog" aria-labelledby="deleteTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteTransactionModalLabel">Delete Transaction</h5>
                    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure you want to delete this transaction?</p>
                    </div>

                    <div class="modal-footer">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" id="deleteTransactionId" name="deleteTransactionId">

                            <button type="submit" class="btn btn-danger" name="deleteTransaction">Delete</button>
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
                                    <option value="cash_income">cash_income</option>
                                    <option value="cash_expense">cash_expense</option>
                                    <option value="credit_receivable">credit_receivable</option>
                                    <option value="credit_payable">credit_payable</option>
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
                                    <option value="transaction_date">Transaction Date</option>
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
            // Update Transaction Modal
            $('#updateTransactionModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var transactionId = button.data('transactionid'); // Extract info from data-* attributes
                var transactionDate = button.closest('tr').find('td:nth-child(2)').text();
                var description = button.closest('tr').find('td:nth-child(3)').text();
                var amount = button.closest('tr').find('td:nth-child(4)').text();
                var transactionType = button.closest('tr').find('td:nth-child(5)').text();
                
                var modal = $(this);

                modal.find('.modal-body #transactionId').val(transactionId);
                modal.find('.modal-body #updateTransactionDate').val(transactionDate);
                modal.find('.modal-body #updateDescription').val(description);
                modal.find('.modal-body #updateAmount').val(amount);
                modal.find('.modal-body #updateTransactionType').val(transactionType);
            });

            // Delete Transaction Modal
            $('#deleteTransactionModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var transactionId = button.data('transactionid'); // Extract info from data-* attributes
        
                var modal = $(this);

                modal.find('.modal-footer #deleteTransactionId').val(transactionId);
            });

            // Filter Button
            $('#applyFilter').click(function () {
                var filterStatus = $('#filterStatus').val();

                $('#transactionTable tbody tr').each(function () {
                    var status = $(this).find('td:nth-child(5)').text();

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

                var sortColumnIndex = 0; // Default sort by the first column (Transaction ID)
    
                if (sortBy === 'transaction_date') {
                    sortColumnIndex = 1; // Transaction Date column
                }  else if (sortBy === 'date_added') {
                    sortColumnIndex = 5; // Date Added column
                }

                var rows = $('#transactionTable tbody').find('tr').get();

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
                    $('#transactionTable tbody').append(row);
                });

                $('#sortModal').modal('hide'); // Close the modal after applying sort
            });

            $(document).ready(function () {
                // Print Button
                $('#printButton').click(function () {
                    var printContents = document.getElementById('transactionTable').outerHTML;
                    var originalContents = document.body.innerHTML;
                    
                    document.body.innerHTML = '<h2 class="text-center">List of Transaction</h2><p class="text-center">As of ' + new Date().toLocaleDateString() + '</p><br>' + printContents;
        
                    window.print();
        
                    document.body.innerHTML = originalContents;
                    location.reload();
                });
            });
        </script>
    </body>
</html>
