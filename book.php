<?php

include "auth.php";
include "db.php";

$search = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}

if ($search != "") {

    $sql = "SELECT * FROM books
            WHERE title LIKE ?
            OR author LIKE ?";

    $stmt = mysqli_prepare($conn, $sql);

    $search_term = "%" . $search . "%";

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $search_term,
        $search_term
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

} else {

    $sql = "SELECT * FROM books";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Book Catalogue</title>

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

.container {
    max-width: 1150px;
    margin: auto;
    padding: 45px 30px;
}

h1 {
    text-align: center;
    font-size: 34px;
    margin-bottom: 10px;
}

.subtitle {
    text-align: center;
    color: #6b7280;
    margin-bottom: 30px;
}

/* SEARCH */

.search-box {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.08);
    text-align: center;
    margin-bottom: 35px;
    border-top: 5px solid #e63946;
}

input {
    width: 320px;
    max-width: 90%;
    padding: 13px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 15px;
    outline: none;
}

input:focus {
    border-color: #2563eb;
}

button {
    padding: 13px 22px;
    border: none;
    border-radius: 8px;
    background: #2563eb;
    color: white;
    cursor: pointer;
    font-weight: bold;
    margin-left: 8px;
}

button:hover {
    background: #1749b5;
}

.clear {
    margin-left: 12px;
    text-decoration: none;
    color: #e63946;
    font-weight: bold;
}

.clear:hover {
    text-decoration: underline;
}

/* BOOK GRID */

.books {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.book-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.08);
    border-top: 6px solid #2563eb;
    transition: 0.2s;
}

.book-card:nth-child(3n + 2) {
    border-top-color: #f4c430;
}

.book-card:nth-child(3n + 3) {
    border-top-color: #e63946;
}

.book-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(0,0,0,0.12);
}

.book-card h2 {
    margin-bottom: 18px;
    color: #172033;
    font-size: 21px;
}

.book-card p {
    color: #555;
    margin: 11px 0;
}

.quantity {
    font-weight: bold;
    color: #172033 !important;
}

.availability {
    font-weight: bold;
}

.availability strong {
    color: #172033;
}

.book-card .availability {
    color: #16a34a;
}

/* ACTION BUTTONS */

.actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px solid #e5e7eb;
}

.action-btn {
    flex: 1;
    text-align: center;
    padding: 10px 12px;
    border-radius: 7px;
    text-decoration: none;
    color: white;
    font-size: 14px;
    font-weight: bold;
}

.edit-btn {
    background: #2563eb;
}

.edit-btn:hover {
    background: #1749b5;
}

.delete-btn {
    background: #e63946;
}

.delete-btn:hover {
    background: #c92f3b;
}

@media (max-width: 850px) {

    .books {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .container {
        padding: 25px 15px;
    }

    .books {
        grid-template-columns: 1fr;
    }

    input {
        width: 100%;
        margin-bottom: 10px;
    }

    button {
        margin-left: 0;
    }

    .clear {
        display: inline-block;
        margin-top: 12px;
    }

}

</style>

</head>

<body>

<div class="container">

<h1>📚 Book Catalogue</h1>

<p class="subtitle">
Browse, search and check the availability of library books.
</p>

<div class="search-box">

<form method="GET">

<input
    type="text"
    name="search"
    placeholder="Search by title or author"
    value="<?php echo htmlspecialchars($search); ?>"
>

<button type="submit">
    🔍 Search
</button>

<a class="clear" href="book.php">
    Clear Search
</a>

</form>

</div>

<div class="books">

<?php

if (mysqli_num_rows($result) == 0) {

    echo "<p>No books found.</p>";

}

while ($book = mysqli_fetch_assoc($result)) {

?>

<div class="book-card">

<h2>
<?php echo htmlspecialchars($book["title"]); ?>
</h2>

<p>

<strong>Author:</strong>

<?php echo htmlspecialchars($book["author"]); ?>

</p>

<p>

<strong>Category:</strong>

<?php echo htmlspecialchars($book["category"]); ?>

</p>

<p class="quantity">

<strong>Quantity:</strong>

<?php echo htmlspecialchars($book["quantity"]); ?>

</p>

<p class="availability">

<strong>Availability:</strong>

<?php

if ($book["quantity"] > 0) {
    echo "Available";
} else {
    echo "Unavailable";
}

?>

</p>

<div class="actions">

<a
    href="update_book.php?id=<?php echo (int)$book["id"]; ?>"
    class="action-btn edit-btn"
>
    ✏️ Edit
</a>

<a
    href="delete_book.php?id=<?php echo (int)$book["id"]; ?>"
    class="action-btn delete-btn"
    onclick="return confirm('Are you sure you want to delete this book?');"
>
    🗑️ Delete
</a>

</div>

</div>

<?php

}

?>

</div>

</div>

</body>

</html>