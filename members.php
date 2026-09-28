<?php

include "auth.php";
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM members");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Library Members</title>

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
            max-width: 1100px;
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

        /* ADD MEMBER BUTTON */

        .add-member {
            display: inline-block;
            margin-bottom: 25px;
            padding: 13px 20px;
            background: #e63946;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.2s;
        }

        .add-member:hover {
            background: #c92f3b;
        }

        /* TABLE */

        .table-box {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
            border-top: 6px solid #2563eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #172033;
            color: white;
            padding: 16px;
            text-align: left;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover td {
            background: #f8fafc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* ACTIONS */

        .edit {
            display: inline-block;
            color: white;
            background: #2563eb;
            padding: 8px 13px;
            border-radius: 6px;
            text-decoration: none;
            margin-right: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        .edit:hover {
            background: #1749b5;
        }

        .delete {
            display: inline-block;
            color: white;
            background: #e63946;
            padding: 8px 13px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .delete:hover {
            background: #c92f3b;
        }

        /* MOBILE */

        @media (max-width: 700px) {

            .container {
                padding: 25px 15px;
            }

            .table-box {
                overflow-x: auto;
            }

            table {
                min-width: 700px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h2>👥 Library Members</h2>

    <p class="subtitle">
        Manage registered library members and their information.
    </p>

    <a class="add-member" href="add_member.php">
        ➕ Add Member
    </a>

    <div class="table-box">

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
                           href="update_member.php?id=<?php echo htmlspecialchars($member["id"]); ?>">
                            Edit
                        </a>

                        <a class="delete"
                           href="delete_member.php?id=<?php echo htmlspecialchars($member["id"]); ?>"
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

</div>

</body>

</html>