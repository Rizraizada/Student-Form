<?php
$conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');
<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];


    $name = $_POST['name'];
    $email = $_POST['email'];
    $division = $_POST['division'];
    $district = $_POST['district'];
    $address = $_POST['address'];
    $examName = $_POST['exam_name'];
    $university = $_POST['university'];
    $board = $_POST['board'];
    $result = $_POST['result'];
    $trainingName = $_POST['training_name'];
    $trainingDetails = $_POST['training_details'];

    $stmt = $conn->prepare("UPDATE applicants SET name = ?, email = ?, division = ?, district = ?, address = ?, exam_name = ?, university = ?, board = ?, result = ?, training_name = ?, training_details = ? WHERE id = ?");
    $stmt->execute([$name, $email, $division, $district, $address, $examName, $university, $board, $result, $trainingName, $trainingDetails, $id]);

    $response = array('message' => 'Applicant updated successfully');
    echo json_encode($response);
    exit;
}

$response = array('error' => 'Unsupported request method');
echo json_encode($response);
exit;
?>



