<?php

require_once "config.php";

$sales = [];

$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error) {
    $res["status"] = "error";
    $res["status_message"] = "Connection failed";
} else {
    $stmt = $conn->prepare("SELECT * FROM students");
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        $row = $result->num_rows;

        if ($row >= 1) {
            foreach ($result as $student) {
                $id = $student["studentID"];

                $stmt = $conn->prepare("SELECT * FROM registrations WHERE studentID=$id");

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $row = $result->num_rows;
                    $registrations = [];
                    if ($row >= 1) {
                        foreach ($result as $registration) {
                            $registrations[] = $registration;
                        }
                    } else {
                        $registrations = [];
                        $res["status"] = "error";
                        $res["status_message"] = "No registrations found";
                    }
                    $students[] = $student;

                    $res["status"] = "success";
                    $res["students"] = $students;
                } else {
                    $res["status"] = "error";
                    $res["status_message"] = $stmt->error;
                }
            }
        } else {
            $res["status"] = "error";
            $res["status_message"] = "No students found";
        }
    } else {
        $res["status"] = "error";
        $res["status_message"] = $stmt->error;
    }
}

echo json_encode($res);
