<?php
$conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');
$stmt = $conn->query("SELECT COUNT(*) as total FROM applicants");
$totalRows = $stmt->fetchColumn();

$perPage = 5;
$totalPages = ceil($totalRows / $perPage);

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}

if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

$offset = ($currentPage - 1) * $perPage;
if ($offset < 0) {
    $offset = 0;
}

$stmt = $conn->prepare("SELECT * FROM applicants LIMIT :offset, :perPage");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/edit') {
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $division = $_POST['division'];
    $district = $_POST['district'];
    $upazila = $_POST['upazila'];

   
    $stmt = $conn->prepare("UPDATE applicants SET name = ?, email = ?, division = ?, district = ?, upazila = ? WHERE id = ?");
    $stmt->execute([$name, $email, $division, $district, $upazila, $id]);

   
    $response = array('message' => 'Edit operation successful');
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/delete') {
    // Get the posted data
    $id = $_POST['id'];

    
    $stmt = $conn->prepare("DELETE FROM applicants WHERE id = ?");
    $stmt->execute([$id]);

    
    $response = array('message' => 'Delete operation successful');
    echo json_encode($response);
    exit;
}


?>
