<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "
            SELECT applicants.*, exam_infos.exam_name, exam_infos.university, training.training_name, training.training_details
            FROM applicants
            LEFT JOIN exam_infos ON applicants.exam_info_id = exam_infos.id
            LEFT JOIN training ON applicants.training_id = training.id
            WHERE applicants.id = :id";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode($record);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Failed to fetch record: ' . $e->getMessage()]);
        }
    }
}
?>
