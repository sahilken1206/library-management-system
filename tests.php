<?php

include "db.php";

$passed = 0;
$failed = 0;

function test_result($test_name, $condition)
{
    global $passed, $failed;

    if ($condition) {
        echo "<p style='color: green;'>PASS: "
            . htmlspecialchars($test_name)
            . "</p>";

        $passed++;

    } else {

        echo "<p style='color: red;'>FAIL: "
            . htmlspecialchars($test_name)
            . "</p>";

        $failed++;
    }
}

echo "<h1>Library Management System - Basic Tests</h1>";

/* Test 1: Database connection */

test_result(
    "Database connection",
    $conn !== false
);


/* Test 2: Books table */

$result = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'books'"
);

test_result(
    "Books table exists",
    $result && mysqli_num_rows($result) > 0
);


/* Test 3: Members table */

$result = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'members'"
);

test_result(
    "Members table exists",
    $result && mysqli_num_rows($result) > 0
);


/* Test 4: Loans table */

$result = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'loans'"
);

test_result(
    "Loans table exists",
    $result && mysqli_num_rows($result) > 0
);


/* Test 5: Users table */

$result = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'users'"
);

test_result(
    "Users table exists",
    $result && mysqli_num_rows($result) > 0
);


/* Test 6: Prepared statement */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id FROM books WHERE id = ?"
);

$test_id = 1;

if ($stmt) {

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $test_id
    );

    $executed = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

} else {

    $executed = false;
}

test_result(
    "Prepared statement works",
    $executed
);


/* Test 7: Loans can be read */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id FROM loans LIMIT 1"
);

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        $loan_read = $result !== false;

    } else {

        $loan_read = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $loan_read = false;
}

test_result(
    "Loans can be read",
    $loan_read
);


/* Test 8: Returned loans can be identified */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM loans
     WHERE return_date IS NOT NULL
     LIMIT 1"
);

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        $return_test = $result !== false;

    } else {

        $return_test = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $return_test = false;
}

test_result(
    "Returned loans can be checked",
    $return_test
);


/* Test 9: Active loans can be identified */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM loans
     WHERE return_date IS NULL
     LIMIT 1"
);

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        $active_loan_test = $result !== false;

    } else {

        $active_loan_test = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $active_loan_test = false;
}

test_result(
    "Active loans can be checked",
    $active_loan_test
);


/* Test 10: Loan and due dates can be read */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, loan_date, due_date
     FROM loans
     LIMIT 1"
);

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        $due_date_test = false;

        if ($result && mysqli_num_rows($result) > 0) {

            $loan = mysqli_fetch_assoc($result);

            $due_date_test =
                !empty($loan["loan_date"]) &&
                !empty($loan["due_date"]);
        }

    } else {

        $due_date_test = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $due_date_test = false;
}

test_result(
    "Loan and due dates can be read",
    $due_date_test
);


/* Test 11: Books and members are correctly connected to loans */

$stmt = mysqli_prepare(
    $conn,
    "SELECT loans.id
     FROM loans
     JOIN books ON loans.book_id = books.id
     JOIN members ON loans.member_id = members.id
     LIMIT 1"
);

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        $relationship_test = $result !== false;

    } else {

        $relationship_test = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $relationship_test = false;
}

test_result(
    "Loans correctly connect books and members",
    $relationship_test
);


/* Test 12: Active loan records do not have a return date */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM loans
     WHERE return_date IS NULL
     LIMIT 1"
);

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        $active_return_test = true;

        if ($result && mysqli_num_rows($result) > 0) {

            $loan = mysqli_fetch_assoc($result);

            $active_return_test =
                $loan["id"] !== null;
        }

    } else {

        $active_return_test = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $active_return_test = false;
}

test_result(
    "Active loans have no return date",
    $active_return_test
);


/* Test 13: Returned loan records contain a return date */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, return_date
     FROM loans
     WHERE return_date IS NOT NULL
     LIMIT 1"
);

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        $returned_date_test = true;

        if ($result && mysqli_num_rows($result) > 0) {

            $loan = mysqli_fetch_assoc($result);

            $returned_date_test =
                !empty($loan["return_date"]);
        }

    } else {

        $returned_date_test = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $returned_date_test = false;
}

test_result(
    "Returned loans contain a return date",
    $returned_date_test
);


/* Test 14: Loan due date is not before loan date */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, loan_date, due_date
     FROM loans"
);

$valid_dates = true;

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        while ($loan = mysqli_fetch_assoc($result)) {

            if ($loan["due_date"] < $loan["loan_date"]) {

                $valid_dates = false;
                break;
            }
        }

    } else {

        $valid_dates = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $valid_dates = false;
}

test_result(
    "Loan due dates are not before loan dates",
    $valid_dates
);


/* Test 15: Active loans can be identified for return flow */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM loans
     WHERE return_date IS NULL
     AND due_date IS NOT NULL
     LIMIT 1"
);

if ($stmt) {

    $executed = mysqli_stmt_execute($stmt);

    if ($executed) {

        $result = mysqli_stmt_get_result($stmt);

        $return_flow_test = $result !== false;

    } else {

        $return_flow_test = false;
    }

    mysqli_stmt_close($stmt);

} else {

    $return_flow_test = false;
}

test_result(
    "Return flow can identify active loans",
    $return_flow_test
);


/* Final result */

echo "<hr>";

echo "<h2>Tests Passed: " . $passed . "</h2>";

echo "<h2>Tests Failed: " . $failed . "</h2>";

if ($failed == 0) {

    echo "<h2 style='color: green;'>All tests passed.</h2>";

} else {

    echo "<h2 style='color: red;'>Some tests failed.</h2>";
}

?>