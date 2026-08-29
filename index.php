```php
<?php

include "db.php";

$books_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
$books = mysqli_fetch_assoc($books_result);

$members_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM members");
$members = mysqli_fetch_assoc($members_result);

$loans_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM loans");
$loans = mysqli_fetch_assoc($loans_result);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Library Management System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="sidebar">

        <h2>📚 Library</h2>

        <a href="index.php">🏠 Dashboard</a>

        <a href="book.php">📚 Books</a>

        <a href="members.php">👥 Members</a>

        <a href="loans.php">📖 Loans</a>

    </div>


    <div class="main">

        <h1>Library Management System</h1>

        <p class="subtitle">
            Manage books, members and loans from one place.
        </p>


        <div class="cards">

            <div class="card">

                <h3>📚 Books</h3>

                <div class="number">
                    <?php echo $books["total"]; ?>
                </div>

                <a class="button" href="book.php">
                    View Books
                </a>

            </div>


            <div class="card">

                <h3>👥 Members</h3>

                <div class="number">
                    <?php echo $members["total"]; ?>
                </div>

                <a class="button" href="members.php">
                    View Members
                </a>

            </div>


            <div class="card">

                <h3>📖 Loans</h3>

                <div class="number">
                    <?php echo $loans["total"]; ?>
                </div>

                <a class="button" href="loans.php">
                    View Loans
                </a>

            </div>

        </div>


        <div class="quick-actions">

            <h2>Quick Actions</h2>

            <a class="button" href="add_book.php">
                ➕ Add Book
            </a>

            <a class="button" href="add_member.php">
                ➕ Add Member
            </a>

            <a class="button" href="add_loan.php">
                📖 Issue Loan
            </a>

        </div>

    </div>

</body>

</html>
```
