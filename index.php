<?php

include "auth.php";
include "db.php";

$books_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM books"
);

$books = mysqli_fetch_assoc($books_result);

$members_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM members"
);

$members = mysqli_fetch_assoc($members_result);

$loans_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM loans"
);

$loans = mysqli_fetch_assoc($loans_result);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Library Management System</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #172033;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
            background: #172033;
            padding: 25px 18px;
        }

        .sidebar h2 {
            color: white;
            text-align: center;
            margin-bottom: 35px;
            font-size: 21px;
        }

        .sidebar a {
            display: block;
            color: #d8deea;
            text-decoration: none;
            padding: 14px 16px;
            margin-bottom: 9px;
            border-radius: 9px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #e63946;
            color: white;
        }

        /* MAIN */

        .main {
            margin-left: 240px;
            padding: 45px;
        }

        .main h1 {
            font-size: 34px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }

        /* CARDS */

        .cards {
            display: flex;
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            flex: 1;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
            border-top: 6px solid #e63946;
        }

        .card:nth-child(2) {
            border-top-color: #f4c430;
        }

        .card:nth-child(3) {
            border-top-color: #2563eb;
        }

        .card h3 {
            margin-bottom: 18px;
            font-size: 18px;
        }

        .number {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* BUTTONS */

        .button {
            display: inline-block;
            padding: 11px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.2s;
        }

        .button:hover {
            background: #1749b5;
        }

        .card:nth-child(1) .button {
            background: #e63946;
        }

        .card:nth-child(1) .button:hover {
            background: #c92f3b;
        }

        .card:nth-child(2) .button {
            background: #d9a900;
        }

        .card:nth-child(2) .button:hover {
            background: #b88f00;
        }

        /* QUICK ACTIONS */

        .quick-actions {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
        }

        .quick-actions h2 {
            margin-bottom: 8px;
        }

        .quick-actions .subtitle {
            margin-bottom: 22px;
        }

        .quick-actions .button {
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .quick-actions .button:nth-of-type(1) {
            background: #e63946;
        }

        .quick-actions .button:nth-of-type(2) {
            background: #d9a900;
        }

        .quick-actions .button:nth-of-type(3) {
            background: #2563eb;
        }

        /* MOBILE */

        @media (max-width: 800px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 25px;
            }

            .cards {
                flex-direction: column;
            }

        }

    </style>

</head>

<body>

<div class="sidebar">

    <h2>📚 Library System</h2>

    <a href="index.php">🏠 Dashboard</a>

    <a href="book.php">📖 Books</a>

    <a href="members.php">👥 Members</a>

    <a href="loans.php">📋 Loans</a>

    <a href="add_book.php">➕ Add Book</a>

    <a href="add_member.php">👤 Add Member</a>

    <a href="add_loan.php">🔄 Loan a Book</a>

    <a href="logout.php">🚪 Logout</a>

</div>


<div class="main">

    <h1>Welcome to the Library 👋</h1>

    <p class="subtitle">
        Manage your books, members and loans from one place.
    </p>


    <div class="cards">

        <div class="card">

            <h3>📚 Total Books</h3>

            <div class="number">
                <?php echo htmlspecialchars($books["total"]); ?>
            </div>

            <a class="button" href="book.php">
                View Books
            </a>

        </div>


        <div class="card">

            <h3>👥 Total Members</h3>

            <div class="number">
                <?php echo htmlspecialchars($members["total"]); ?>
            </div>

            <a class="button" href="members.php">
                View Members
            </a>

        </div>


        <div class="card">

            <h3>📋 Total Loans</h3>

            <div class="number">
                <?php echo htmlspecialchars($loans["total"]); ?>
            </div>

            <a class="button" href="loans.php">
                View Loans
            </a>

        </div>

    </div>


    <div class="quick-actions">

        <h2>⚡ Quick Actions</h2>

        <p class="subtitle">
            Quickly access the most common library operations.
        </p>

        <a class="button" href="add_book.php">
            ➕ Add Book
        </a>

        <a class="button" href="add_member.php">
            👤 Add Member
        </a>

        <a class="button" href="add_loan.php">
            🔄 Loan a Book
        </a>

    </div>

</div>

</body>

</html>