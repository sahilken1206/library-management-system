```php
<?php

include "db.php";

$result = mysqli_query($conn, "SELECT * FROM members");

?>

<!DOCTYPE html>

<html>

<head>

    <title>Library Members</title>

</head>

<body>

<h2>Library Members</h2>

<table border="1" cellpadding="10">

    <tr>

        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>

    </tr>

<?php

while ($member = mysqli_fetch_assoc($result)) {

?>

    <tr>

        <td><?php echo $member["id"]; ?></td>

        <td><?php echo $member["name"]; ?></td>

        <td><?php echo $member["email"]; ?></td>

        <td><?php echo $member["phone"]; ?></td>

        <td>

            <a href="update_member.php?id=<?php echo $member["id"]; ?>">
                Edit
            </a>

            |

            <a href="delete_member.php?id=<?php echo $member["id"]; ?>">
                Delete
            </a>

        </td>

    </tr>

<?php

}

?>

</table>

</body>

</html>
```
