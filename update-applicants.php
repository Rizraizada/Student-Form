<?php
$conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

   
    $stmt = $conn->prepare("SELECT * FROM applicants WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $applicant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode(array('applicant' => $applicant));
    } else {
        // Applicant not found
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Applicant not found'));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $id = $_POST['id'];
    $name = $_POST['name'];
    
   
    $stmt = $conn->prepare("UPDATE applicants SET name = :name WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

  
    if ($stmt->rowCount() > 0) {
        $response = array("message" => "Applicant updated successfully");
    } else {
        $response = array("message" => "Failed to update applicant");
    }

    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
