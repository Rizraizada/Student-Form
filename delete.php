<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve the ID from the URL parameter
        $id = $_GET['id'];

        // Prepare and execute the delete statement
        $stmt = $conn->prepare('DELETE FROM applicants WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Close the prepared statement and database connection
        $stmt->closeCursor();
        $conn = null;

        // Redirect back to the page where the delete link was clicked
        header('Location: admin.php');
        exit();
    } catch (PDOException $e) {
        $errorMessage = "Connection failed: " . $e->getMessage();
    }
} else {
    header('HTTP/1.0 404 Not Found');
    echo '404 Not Found';
    exit();
}
?>
