<?php

include "db.php";

$passed = 0;
$failed = 0;

function test_result($test_name, $condition)
{
    global $passed, $failed;

    if ($condition) {
        echo "<p style='color: green;'>PASS: " . htmlspecialchars($test_name) . "</p>";
        $passed++;
    } else {
        echo "<p style='color: red;'>FAIL: " . htmlspecialchars($test_name) . "</p>";
        $failed++;
    }
}

echo "<h1>Library Management System - Basic Tests</h1>";

/* Test 1: Database connection */
test_result(
    "Database connection",
    $conn && mysqli_ping($conn)
);

/* Test 2: Books table */
$result = mysqli_query($conn, "SHOW TABLES LIKE 'books'");
test_result(
    "Books table exists",
    mysqli_num_rows($result) > 0
);

/* Test 3: Members table */
$result = mysqli_query($conn, "SHOW TABLES LIKE 'members'");
test_result(
    "Members table exists",
    mysqli_num_rows($result) > 0
);

/* Test 4: Loans table */
$result = mysqli_query($conn, "SHOW TABLES LIKE 'loans'");
test_result(
    "Loans table exists",
    mysqli_num_rows($result) > 0
);

/* Test 5: Users table */
$result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
test_result(
    "Users table exists",
    mysqli_num_rows($result) > 0
);

/* Test 6: Prepared statement */
$stmt = mysqli_prepare($conn, "SELECT id FROM books WHERE id = ?");
$test_id = 1;

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $test_id);
    $executed = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    $executed = false;
}

test_result(
    "Prepared statement works",
    $executed
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