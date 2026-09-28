<?php

include "auth.php";
include "db.php";

$sql = "SELECT 
            loans.id,
            books.title,
            members.name,
            loans.loan_date,
            loans.due_date,
            loans.return_date

        FROM loans

        JOIN books ON loans.book_id = books.id
        JOIN members ON loans.member_id = members.id

        ORDER BY loans.id DESC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Library Loans</title>

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
            max-width: 1200px;
            margin: auto;
            padding: 45px 30px;
        }

        h2 {
            text-align: center;
            font-size: 34px;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 30px;
        }

        /* TABLE CONTAINER */

        .table-box {
            background: white;
            border-radius: 15px;
            overflow-x: auto;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
            border-top: 6px solid #e63946;
        }

        table {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        th {
            background: #172033;
            color: white;
            padding: 16px;
            text-align: left;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover td {
            background: #f8fafc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* STATUS */

        .status {
            font-weight: bold;
        }

        .active {
            color: #2563eb;
        }

        .overdue {
            color: #e63946;
        }

        .returned {
            color: #16a34a;
        }

        /* ACTION BUTTONS */

        .action {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            margin: 2px;
        }

        .return {
            background: #f4c430;
            color: #172033;
        }

        .return:hover {
            background: #d9a900;
        }

        .edit {
            background: #2563eb;
            color: white;
        }

        .edit:hover {
            background: #1749b5;
        }

        .delete {
            background: #e63946;
            color: white;
        }

        .delete:hover {
            background: #c92f3b;
        }

        .already-returned {
            color: #16a34a;
            font-weight: bold;
            margin-right: 5px;
        }

        @media (max-width: 700px) {

            .container {
                padding: 25px 15px;
            }

            h2 {
                font-size: 28px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h2>📋 Library Loans</h2>

    <p class="subtitle">
        Track borrowed books, due dates and returns.
    </p>

    <div class="table-box">

        <table>

            <tr>

                <th>Loan ID</th>

                <th>Book</th>

                <th>Member</th>

                <th>Loan Date</th>

                <th>Due Date</th>

                <th>Return Date</th>

                <th>Status</th>

                <th>Action</th>

            </tr>

            <?php

            while ($loan = mysqli_fetch_assoc($result)) {

            ?>

            <tr>

                <td>
                    <?php echo htmlspecialchars($loan["id"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($loan["title"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($loan["name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($loan["loan_date"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($loan["due_date"]); ?>
                </td>

                <td>

                    <?php

                    if ($loan["return_date"] == NULL) {

                        echo "Not returned";

                    } else {

                        echo htmlspecialchars($loan["return_date"]);

                    }

                    ?>

                </td>

                <td class="status">

                    <?php

                    if ($loan["return_date"] == NULL) {

                        if (date("Y-m-d") > $loan["due_date"]) {

                            $today = new DateTime();

                            $due_date = new DateTime($loan["due_date"]);

                            $days_overdue = $due_date->diff($today)->days;

                            echo '<span class="overdue">Overdue by '
                                . htmlspecialchars($days_overdue)
                                . ' days</span>';

                        } else {

                            echo '<span class="active">Active</span>';

                        }

                    } else {

                        $return_date = new DateTime($loan["return_date"]);

                        $due_date = new DateTime($loan["due_date"]);

                        if ($return_date > $due_date) {

                            $days_late = $due_date->diff($return_date)->days;

                            echo '<span class="overdue">Returned late by '
                                . htmlspecialchars($days_late)
                                . ' days</span>';

                        } else {

                            echo '<span class="returned">Returned on time</span>';

                        }

                    }

                    ?>

                </td>

                <td>

                    <?php

                    if ($loan["return_date"] == NULL) {

                    ?>

                        <a
                            class="action return"
                            href="return_loan.php?id=<?php echo htmlspecialchars($loan["id"]); ?>"
                        >
                            ↩ Return
                        </a>

                    <?php

                    } else {

                        echo '<span class="already-returned">✓ Returned</span>';

                    }

                    ?>

                    <a
                        class="action edit"
                        href="edit_loan.php?id=<?php echo htmlspecialchars($loan["id"]); ?>"
                    >
                        ✏ Edit
                    </a>

                    <a
                        class="action delete"
                        href="delete_loan.php?id=<?php echo htmlspecialchars($loan["id"]); ?>"
                        onclick="return confirm('Are you sure you want to delete this loan?');"
                    >
                        🗑 Delete
                    </a>

                </td>

            </tr>

            <?php

            }

            mysqli_stmt_close($stmt);

            ?>

        </table>

    </div>

</div>

</body>

</html>