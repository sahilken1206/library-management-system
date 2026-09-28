
<?php

include "auth.php";
include "db.php";

$message = "";
$message_type = "";

if (isset($_POST["submit"])) {

    $book_id = $_POST["book_id"];
    $member_id = $_POST["member_id"];
    $loan_date = $_POST["loan_date"];
    $due_date = $_POST["due_date"];

    if (
        empty($book_id) ||
        empty($member_id) ||
        empty($loan_date) ||
        empty($due_date)
    ) {

        $message = "Please fill in all fields.";
        $message_type = "error";

    } elseif ($due_date < $loan_date) {

        $message = "Due date cannot be before loan date.";
        $message_type = "error";

    } else {

        /* Check if book exists */

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id FROM books WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $book_id
        );

        mysqli_stmt_execute($stmt);

        $book_result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);

        if (mysqli_num_rows($book_result) == 0) {

            $message = "Book not found.";
            $message_type = "error";

        } else {

            /* Check if member exists */

            $stmt = mysqli_prepare(
                $conn,
                "SELECT id FROM members WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $member_id
            );

            mysqli_stmt_execute($stmt);

            $member_result = mysqli_stmt_get_result($stmt);

            mysqli_stmt_close($stmt);

            if (mysqli_num_rows($member_result) == 0) {

                $message = "Member not found.";
                $message_type = "error";

            } else {

                /* Check if book is already loaned */

                $stmt = mysqli_prepare(
                    $conn,
                    "SELECT id FROM loans
                     WHERE book_id = ?
                     AND return_date IS NULL"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "i",
                    $book_id
                );

                mysqli_stmt_execute($stmt);

                $active_loan_result = mysqli_stmt_get_result($stmt);

                mysqli_stmt_close($stmt);

                if (mysqli_num_rows($active_loan_result) > 0) {

                    $message = "This book is already loaned out.";
                    $message_type = "error";

                } else {

                    /* Create loan */

                    $stmt = mysqli_prepare(
                        $conn,
                        "INSERT INTO loans
                        (book_id, member_id, loan_date, due_date)
                        VALUES (?, ?, ?, ?)"
                    );

                    mysqli_stmt_bind_param(
                        $stmt,
                        "iiss",
                        $book_id,
                        $member_id,
                        $loan_date,
                        $due_date
                    );

                    if (mysqli_stmt_execute($stmt)) {

                        $message = "Loan created successfully!";
                        $message_type = "success";

                    } else {

                        $message = "Error: " . mysqli_stmt_error($stmt);
                        $message_type = "error";
                    }

                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Loan | Library Management System</title>

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
            border-bottom: 5px solid #2878c8;
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

        .info-box {
            margin-top: 25px;
            padding: 14px 16px;
            background: #f8fafc;
            border-left: 4px solid #2878c8;
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
            border-radius: 5px;
        }

        .button-area {
            margin-top: 30px;
            display: flex;
            gap: 12px;
        }

        .create-button {
            background: #2878c8;
            color: white;
            border: none;
            padding: 13px 25px;
            border-radius: 9px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .create-button:hover {
            background: #1f64a8;
            transform: translateY(-1px);
        }

        .back-button {
            background: #e63946;
            color: white;
            text-decoration: none;
            padding: 13px 25px;
            border-radius: 9px;
            font-size: 15px;
            font-weight: bold;
            transition: 0.2s;
        }

        .back-button:hover {
            background: #c92836;
            transform: translateY(-1px);
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

            .button-area {
                flex-direction: column;
            }

            .create-button,
            .back-button {
                width: 100%;
                text-align: center;
            }

        }

    </style>

</head>

<body>

<div class="page-container">

    <div class="header">

        <h1>📖 Create New Loan</h1>

        <p>
            Loan a book to a registered library member.
        </p>

    </div>


    <div class="form-section">

        <h2 class="form-title">Loan Information</h2>


        <?php if ($message != "") { ?>

            <div class="message <?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>


        <form method="POST">

            <div class="form-grid">

                <div class="form-group">

                    <label>Book ID</label>

                    <input
                        type="number"
                        name="book_id"
                        min="1"
                        placeholder="Enter book ID"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Member ID</label>

                    <input
                        type="number"
                        name="member_id"
                        min="1"
                        placeholder="Enter member ID"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Loan Date</label>

                    <input
                        type="date"
                        name="loan_date"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Due Date</label>

                    <input
                        type="date"
                        name="due_date"
                        required
                    >

                </div>

            </div>


            <div class="button-area">

                <button
                    type="submit"
                    name="submit"
                    class="create-button"
                >
                    Create Loan
                </button>

                <a
                    href="loans.php"
                    class="back-button"
                >
                    Back to Loans
                </a>

            </div>

        </form>


        <div class="info-box">
            Make sure the Book ID and Member ID exist before creating the loan.
            The system will also prevent a book from being loaned while it is
            already on an active loan.
        </div>

    </div>

</div>

</body>

</html>
