// reports.php
<?php
require_once 'config.php';

if (isset($_POST['download_report'])) {
    $report_type = $_POST['report_type'];
    $filter = $_POST['filter'];

    if ($report_type == 'tasks') {
        $query = "SELECT * FROM tasks";
        if ($filter == 'status') {
            $status = $_POST['status'];
            $query .= " WHERE status = '$status'";
        } elseif ($filter == 'user') {
            $user_id = $_POST['user_id'];
            $query .= " WHERE assigned_to = '$user_id'";
        }
    } elseif ($report_type == 'rentals') {
        $query = "SELECT * FROM rentals";
        if ($filter == 'customer') {
            $customer_id = $_POST['customer_id'];
            $query .= " WHERE customer_id = '$customer_id'";
        } elseif ($filter == 'rental_status') {
            $rental_status = $_POST['rental_status'];
            $query .= " WHERE rental_status = '$rental_status'";
        }
    }

    $result = $conn->query($query);

    $fp = fopen('report.csv', 'w');
    while ($row = $result->fetch_assoc()) {
        fputcsv($fp, $row);
    }
    fclose($fp);

    header('Content-Type: application/csv');
   