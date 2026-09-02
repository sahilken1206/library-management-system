```php
<?php

include "db.php";

$search = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}

$sql = "SELECT * FROM books";

if ($search != "") {
    $search = mysqli_real_escape_string($conn, $search);

    $sql = "SELECT * FROM books
            WHERE title LIKE '%$search%'
            OR author LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Book Catalogue</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .search-box {
            text-align: center;
            margin-bottom: 30px;
        }

        input {
            width: 300px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        .clear {
            margin-left: 10px;
            text-decoration: none;
            color: #333;
        }

        .books {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .book-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .book-card h2 {
            margin-top: 0;
            color: #222;
        }

        .book-card p {
            color: #555;
            margin: 8px 0;
        }

        .quantity {
            font-weight: bold;
            color: #222;
        }

        @media (max-width: 700px) {
            .books {
                grid-template-columns: 1fr;
            }
        }

    </style>

</head>

<body>

<div class="container">

    <h1>📚 Book Catalogue</h1>

    <div class="search-box">

        <form method="GET">

            <input
                type="text"
                name="search"
                placeholder="Search by title or author"
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button type="submit">Search</button>

            <a class="clear" href="book.php">Clear Search</a>

        </form>

    </div>

    <div class="books">

        <?php

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
                    Quantity:
                    <?php echo htmlspecialchars($book["quantity"]); ?>
                </p>

            </div>

        <?php

        }

        ?>

    </div>

</div>

</body>
</html>
```
