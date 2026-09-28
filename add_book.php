
<?php

include "auth.php";
include "db.php";

$message = "";
$message_type = "";

if (isset($_POST["submit"])) {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];

    if (
        empty($title) ||
        empty($author) ||
        empty($category) ||
        empty($quantity)
    ) {

        $message = "Please fill in all fields.";
        $message_type = "error";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO books (title, author, category, quantity)
             VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $title,
            $author,
            $category,
            $quantity
        );

        if (mysqli_stmt_execute($stmt)) {

            $message = "Book added successfully!";
            $message_type = "success";

        } else {

            $message = "Error: " . mysqli_stmt_error($stmt);
            $message_type = "error";
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Book | Library Management System</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f4f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .page-container {
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .header {
            background: #071426;
            color: white;
            padding: 28px 35px;
            border-bottom: 5px solid #e63946;
        }

        .header h1 {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .header p {
            color: #cbd5e1;
            font-size: 14px;
        }

        .form-section {
            padding: 40px 45px;
        }

        .form-title {
            color: #071426;
            font-size: 22px;
            margin-bottom: 25px;
            border-left: 5px solid #f4c430;
            padding-left: 12px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #243447;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 2px solid #e2e8f0;
            border-radius: 9px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #2878c8;
            box-shadow: 0 0 0 3px rgba(40, 120, 200, 0.12);
        }

        .message {
            padding: 13px 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: bold;
        }

        .success {
            background: #fff8d8;
            color: #7a5c00;
            border-left: 5px solid #f4c430;
        }

        .error {
            background: #fff1f2;
            color: #c62828;
            border-left: 5px solid #e63946;
        }

        .button-area {
            margin-top: 30px;
            display: flex;
            gap: 12px;
        }

        .add-button {
            background: #2878c8;
            color: white;
            border: none;
            padding: 13px 25px;
            border-radius: 9px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .add-button:hover {
            background: #1f64a8;
        }

        .back-button {
            background: #e63946;
            color: white;
            text-decoration: none;
            padding: 13px 25px;
            border-radius: 9px;
            font-size: 15px;
            font-weight: bold;
        }

        .back-button:hover {
            background: #c92836;
        }

        .hint {
            margin-top: 25px;
            padding: 13px 15px;
            background: #f8fafc;
            border-left: 4px solid #2878c8;
            color: #64748b;
            font-size: 13px;
            border-radius: 5px;
        }

        @media (max-width: 650px) {

            body {
                padding: 15px;
            }

            .form-section {
                padding: 30px 25px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .button-area {
                flex-direction: column;
            }

            .add-button,
            .back-button {
                text-align: center;
                width: 100%;
            }
        }

    </style>

</head>

<body>

<div class="page-container">

    <div class="header">

        <h1>📚 Add New Book</h1>

        <p>
            Add a new book to the library catalogue.
        </p>

    </div>


    <div class="form-section">

        <h2 class="form-title">Book Information</h2>


        <?php if ($message != "") { ?>

            <div class="message <?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>


        <form method="POST">

            <div class="form-grid">

                <div class="form-group full">

                    <label>Book Title</label>

                    <input
                        type="text"
                        name="title"
                        placeholder="Enter book title"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Author</label>

                    <input
                        type="text"
                        name="author"
                        placeholder="Enter author name"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Category</label>

                    <input
                        type="text"
                        name="category"
                        placeholder="e.g. Fiction, Science, History"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Quantity</label>

                    <input
                        type="number"
                        name="quantity"
                        min="0"
                        placeholder="Enter quantity"
                        required
                    >

                </div>

            </div>


            <div class="button-area">

                <button
                    type="submit"
                    name="submit"
                    class="add-button"
                >
                    Add Book
                </button>

                <a
                    href="book.php"
                    class="back-button"
                >
                    Back to Books
                </a>

            </div>

        </form>


        <div class="hint">
            Make sure all book details are filled in before adding the book.
        </div>

    </div>

</div>

</body>

</html>
