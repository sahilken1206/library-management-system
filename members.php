```php
<?php

include "db.php";

$result = mysqli_query($conn, "SELECT * FROM members");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Library Members</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .add-member {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .add-member:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #333;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .edit {
            color: #2563eb;
            text-decoration: none;
            margin-right: 10px;
        }

        .delete {
            color: #dc2626;
            text-decoration: none;
        }

        .edit:hover,
        .delete:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

<div class="container">

    <h2>👥 Library Members</h2>

    <a class="add-member" href="add_member.php">
        + Add Member
    </a>

    <table>

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

                <td>
                    <?php echo htmlspecialchars($member["id"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($member["name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($member["email"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($member["phone"]); ?>
                </td>

                <td>

                    <a class="edit"
                       href="update_member.php?id=<?php echo $member["id"]; ?>">
                        Edit
                    </a>

                    <a class="delete"
                       href="delete_member.php?id=<?php echo $member["id"]; ?>"
                       onclick="return confirm('Are you sure you want to delete this member?');">
                        Delete
                    </a>

                </td>

            </tr>

        <?php

        }

        ?>

    </table>

</div>

</body>

</html>
```
