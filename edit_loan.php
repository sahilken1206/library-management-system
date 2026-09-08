<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Loan ID missing.");
}

$id = $_GET["id"];

$stmt = mysqli_prepare(
    $conn,
    "SELECT loan_date, due_date FROM loans WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$loan = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$loan) {
    die("Loan not found.");
}

if (isset($_POST["submit"])) {

    $loan_date = $_POST["loan_date"];
    $due_date = $_POST["due_date"];

    if (empty($loan_date) || empty($due_date)) {

        echo "Please fill in all fields.";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE loans 
             SET loan_date = ?, due_date = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $loan_date,
            $due_date,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {

            echo "Loan updated successfully!";

        } else {

            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Loan</title>
</head>

<body>

<h2>Edit Loan</h2>

<form method="POST">

    Loan Date:
    <input
        type="date"
        name="loan_date"
        value="<?php echo $loan["loan_date"]; ?>"
    >

    <br><br>

    Due Date:
    <input
        type="date"
        name="due_date"
        value="<?php echo $loan["due_date"]; ?>"
    >

    <br><br>

    <button type="submit" name="submit">
        Update Loan
    </button>

</form>

</body>

</html>