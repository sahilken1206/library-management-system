<?php

include "db.php";

$sql = "SELECT 
            loans.id,
            books.title,
            members.name,
            loans.loan_date,
            loans.return_date
        FROM loans
        JOIN books ON loans.book_id = books.id
        JOIN members ON loans.member_id = members.id";

$result = mysqli_query($conn, $sql);

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
        <th>Return Date</th>
    </tr>

<?php

while ($loan = mysqli_fetch_assoc($result)) {

?>

    <tr>
        <td><?php echo $loan["id"]; ?></td>
        <td><?php echo $loan["title"]; ?></td>
        <td><?php echo $loan["name"]; ?></td>
        <td><?php echo $loan["loan_date"]; ?></td>
        <td>
            <?php 
            echo $loan["return_date"] ?? "Not returned";
            ?>
        </td>
    </tr>

<?php

}

?>

</table>

</body>
</html> 