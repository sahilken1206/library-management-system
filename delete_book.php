
<?php

include "auth.php";
include "db.php";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    die("Invalid book ID.");
}

$id = (int) $_GET["id"];

// Check whether the book exists
$stmt = mysqli_prepare(
    $conn,
    "SELECT id, title FROM books WHERE id = ?"
);

if (!$stmt) {
    error_log("Book lookup failed: " . mysqli_error($conn));
    die("A database error occurred. Please try again later.");
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$book) {
    die("Book not found.");
}

// Check whether this book has any loan history
$stmt = mysqli_prepare(
    $conn,
    "SELECT COUNT(*) AS total FROM loans WHERE book_id = ?"
);

if (!$stmt) {
    error_log("Loan check failed: " . mysqli_error($conn));
    die("A database error occurred. Please try again later.");
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if ((int) $row["total"] > 0) {
    http_response_code(409);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cannot Delete Book</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f5f7fb;
                color: #172033;
                text-align: center;
                padding: 60px 20px;
            }
            .box {
                max-width: 500px;
                margin: auto;
                padding: 30px;
                background: white;
                border-radius: 12px;
                box-shadow: 0 5px 18px rgba(0,0,0,0.08);
            }
            h2 { color: #e63946; }
            a {
                display: inline-block;
                margin-top: 15px;
                padding: 12px 20px;
                background: #2563eb;
                color: white;
                text-decoration: none;
                border-radius: 7px;
            }
        </style>
    </head>
    <body>
        <div class="box">
            <h2>Cannot Delete This Book</h2>
            <p>
                <strong><?php echo htmlspecialchars($book["title"]); ?></strong>
                has existing loan records.
            </p>
            <p>
                The book cannot be deleted because its loan history
                must be preserved.
            </p>
            <a href="book.php">Return to Books</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Delete the book if no loan records reference it
$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM books WHERE id = ?"
);

if (!$stmt) {
    error_log("Book delete preparation failed: " . mysqli_error($conn));
    die("Unable to delete the book. Please try again later.");
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: book.php");
    exit();
}

$error = mysqli_stmt_error($stmt);
error_log("Book deletion failed for ID $id: " . $error);

mysqli_stmt_close($stmt);

die("Unable to delete this book. Please check the database constraints.");

?>
