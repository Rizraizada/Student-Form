<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        $response = array('message' => 'Invalid request');
        echo json_encode($response);
        exit;
    }

    $id = $_POST['id'];

    $conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');

    $stmt = $conn->prepare("DELETE FROM applicants WHERE id = ?");
    $stmt->execute([$id]);

    $response = array('message' => 'Delete operation successful');
    echo json_encode($response);
    exit;
}
?>
