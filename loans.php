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

</head>

<body>

<h2>Library Loans</h2>

<table border="1" cellpadding="10">

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

        <td>

            <?php

            /* Check loan status */

            if ($loan["return_date"] == NULL) {

                if (date("Y-m-d") > $loan["due_date"]) {

                    $today = new DateTime();

                    $due_date = new DateTime($loan["due_date"]);

                    $days_overdue = $due_date->diff($today)->days;

                    echo "Overdue by " . htmlspecialchars($days_overdue) . " days";

                } else {

                    echo "Active";

                }

            } else {

                $return_date = new DateTime($loan["return_date"]);

                $due_date = new DateTime($loan["due_date"]);

                if ($return_date > $due_date) {

                    $days_late = $due_date->diff($return_date)->days;

                    echo "Returned late by " . htmlspecialchars($days_late) . " days";

                } else {

                    echo "Returned on time";

                }

            }

            ?>

        </td>

        <td>

            <?php

            if ($loan["return_date"] == NULL) {

            ?>

                <a href="return_loan.php?id=<?php echo htmlspecialchars($loan["id"]); ?>">

                    Return

                </a>

                |

            <?php

            } else {

                echo "Returned | ";

            }

            ?>

            <a href="edit_loan.php?id=<?php echo htmlspecialchars($loan["id"]); ?>">

                Edit

            </a>

            |

            <a href="delete_loan.php?id=<?php echo htmlspecialchars($loan["id"]); ?>">

                Delete

            </a>

        </td>

    </tr>

<?php

}

mysqli_stmt_close($stmt);

?>

</table>

</body>

</html>