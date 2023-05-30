<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and process the form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $examName = $_POST['exam_name'];
    $university = $_POST['university'];
    $trainingName = $_POST['training_name'];
    $trainingDetails = $_POST['training_details'];

    try {
        // Update the record in the database
        // Adjust the code to match your database structure and query method

        $conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "
        UPDATE applicants 
        LEFT JOIN exam_infos ON applicants.exam_infos = exam_infos.id
        LEFT JOIN training ON applicants.training_id = training.id
        SET 
            applicants.name = :name, 
            applicants.email = :email,
            exam_infos.exam_name = :examName,
            exam_infos.university = :university,
            training.training_name = :trainingName,
            training.training_details = :trainingDetails
        WHERE applicants.id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':examName', $examName);
        $stmt->bindParam(':university', $university);
        $stmt->bindParam(':trainingName', $trainingName);
        $stmt->bindParam(':trainingDetails', $trainingDetails);
        $stmt->execute();

        $success = true;
        $message = 'Record updated successfully';
    } catch (PDOException $e) {
        // Handle any errors that occur during the database update
        $success = false;
        $message = 'Error updating record: ' . $e->getMessage();
    }

    // Return the response
    if ($success) {
        echo $message;
    } else {
        echo $message;
    }
}
?>
