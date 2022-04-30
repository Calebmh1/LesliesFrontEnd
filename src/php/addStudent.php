<?php
require_once "config.php";

$session = $_POST['session'];

session_id($session);
session_start();

$auth = $_SESSION['auth'];

$id = null;
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$gradYear = $_POST['gradYear'];
$gpa = $_POST['gpa'];
$major = $_POST['major'];
$registrations = json_decode($_POST['registrations'], true);

if ($auth) {
    $conn = new mysqli($hn, $un, $pw, $db);

    if ($conn->connect_error) {
        $res['status'] = "error";
        $res['message'] = "mySQL connection failed";
    } else {
        $stmt = $conn->prepare("INSERT INTO students VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $id, $fname, $lname, $gradYear, $gpa, $major);

        if ($stmt->execute()) {
            $studentID = $conn->insert_id;

            foreach ($registrations as $registration) {
                $id = null;
                $courseNumber = $registration['courseNumber'];
                $numberOfCredits = $registration['numberOfCredits'];
                $bookFormat = $registration['bookFormat'];
                $attendanceType = $registration['attendanceType'];

                $stmt = $conn->prepare("INSERT INTO registrations VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iisiss", $id, $studentID, $courseNumber, $numberOfCredits, $bookFormat, $attendanceType);

                if ($stmt->execute()) {
                    $res["status"] = "success";
                } else {
                    $res['status'] = "error 1";
                    $res['status_message'] = $stmt->error;
                }
            }
        } else {
            $res['status'] = "error 2";
            $res['status_message'] = $stmt->error;
        }
    }
} else {
    $res['status'] = "error 3";
    $res['status_message'] = "Not authenticated";
}

echo json_encode($res);
