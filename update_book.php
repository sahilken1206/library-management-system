<?php

include "auth.php";
include "db.php";

$message = "";
$message_type = "";

if (!isset($_GET["id"])) {
    die("Book ID not found.");
}

$id = $_GET["id"];

/* Get book details */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM books WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$book = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$book) {
    die("Book not found.");
}


/* Update book */

if (isset($_POST["update"])) {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];

    if (
        empty($title) ||
        empty($author) ||
        empty($category) ||
        $quantity === ""
    ) {

        $message = "Please fill in all fields.";
        $message_type = "error";

    } elseif (!is_numeric($quantity) || $quantity < 0) {

        $message = "Quantity must be 0 or greater.";
        $message_type = "error";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE books
             SET title = ?,
                 author = ?,
                 category = ?,
                 quantity = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssii",
            $title,
            $author,
            $category,
            $quantity,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_close($stmt);

            header("Location: book.php");
            exit();

        } else {

            $message = "Error: " . mysqli_stmt_error($stmt);
            $message_type = "error";

            mysqli_stmt_close($stmt);
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Update Book</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0b1220;
            color: #ffffff;
            min-height: 100vh;
        }

        .header {
            background: #111827;
            border-bottom: 4px solid #2563eb;
            padding: 22px 35px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 6px 0 0;
            color: #cbd5e1;
        }

        .container {
            width: 90%;
            max-width: 700px;
            margin: 45px auto;
        }

        .card {
            background: #111827;
            border: 1px solid #334155;
            border-top: 5px solid #facc15;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #facc15;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #e2e8f0;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #475569;
            border-radius: 7px;
            background: #0f172a;
            color: #ffffff;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .message {
            padding: 13px 15px;
            border-radius: 7px;
            margin-bottom: 22px;
            font-weight: bold;
        }

        .error {
            background: #7f1d1d;
            border: 1px solid #ef4444;
            color: #fecaca;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 13px 22px;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-blue {
            background: #2563eb;
            color: white;
        }

        .btn-blue:hover {
            background: #1d4ed8;
        }

        .btn-red {
            background: #ef4444;
            color: white;
        }

        .btn-red:hover {
            background: #dc2626;
        }

        @media (max-width: 600px) {

            .header {
                padding: 20px;
            }

            .container {
                width: 94%;
                margin: 25px auto;
            }

            .card {
                padding: 25px 20px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                text-align: center;
                width: 100%;
            }
        }

    </style>

</head>

<body>

<div class="header">

    <h1>📚 Update Book</h1>

    <p>Edit the details of an existing book</p>

</div>

<div class="container">

    <div class="card">

        <h2>Book Details</h2>

        <?php if ($message != "") { ?>

            <div class="message <?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>

        <form method="POST">

            <div class="form-group">

                <label>Title</label>

                <input
                    type="text"
                    name="title"
                    value="<?php echo htmlspecialchars($book["title"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Author</label>

                <input
                    type="text"
                    name="author"
                    value="<?php echo htmlspecialchars($book["author"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Category</label>

                <input
                    type="text"
                    name="category"
                    value="<?php echo htmlspecialchars($book["category"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Quantity</label>

                <input
                    type="number"
                    name="quantity"
                    min="0"
                    value="<?php echo htmlspecialchars($book["quantity"]); ?>"
                    required
                >

            </div>

            <div class="buttons">

                <button
                    type="submit"
                    name="update"
                    class="btn btn-blue"
                >
                    Update Book
                </button>

                <a
                    href="book.php"
                    class="btn btn-red"
                >
                    Back to Books
                </a>

            </div>

        </form>

    </div>

</div>

</body>

</html>