<?php

include "auth.php";
include "db.php";

$message = "";
$message_type = "";

if (!isset($_GET["id"])) {
    die("Loan ID not found.");
}

$id = $_GET["id"];

/* Get loan details */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM loans WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$loan = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$loan) {
    die("Loan not found.");
}


/* Update loan */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $book_id = $_POST["book_id"];
    $member_id = $_POST["member_id"];
    $loan_date = $_POST["loan_date"];
    $due_date = $_POST["due_date"];

    if ($due_date < $loan_date) {

        $message = "Due date cannot be before loan date.";
        $message_type = "error";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE loans
             SET book_id = ?, member_id = ?, loan_date = ?, due_date = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iissi",
            $book_id,
            $member_id,
            $loan_date,
            $due_date,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_close($stmt);

            header("Location: loans.php");
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

    <title>Edit Loan</title>

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

    <h1>📖 Edit Loan</h1>

    <p>Update the details of an existing book loan</p>

</div>

<div class="container">

    <div class="card">

        <h2>Loan Details</h2>

        <?php if ($message != "") { ?>

            <div class="message <?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>

        <form method="POST">

            <div class="form-group">

                <label>Book ID</label>

                <input
                    type="number"
                    name="book_id"
                    value="<?php echo htmlspecialchars($loan["book_id"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Member ID</label>

                <input
                    type="number"
                    name="member_id"
                    value="<?php echo htmlspecialchars($loan["member_id"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Loan Date</label>

                <input
                    type="date"
                    name="loan_date"
                    value="<?php echo htmlspecialchars($loan["loan_date"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Due Date</label>

                <input
                    type="date"
                    name="due_date"
                    value="<?php echo htmlspecialchars($loan["due_date"]); ?>"
                    required
                >

            </div>

            <div class="buttons">

                <button
                    type="submit"
                    class="btn btn-blue"
                >
                    Update Loan
                </button>

                <a
                    href="loans.php"
                    class="btn btn-red"
                >
                    Back to Loans
                </a>

            </div>

        </form>

    </div>

</div>

</body>

</html>