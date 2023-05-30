<?php
$conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');
$stmt = $conn->query("SELECT COUNT(*) as total FROM applicants");
$totalRows = $stmt->fetchColumn();

$perPage = 10;
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

$stmt = $conn->prepare("
    SELECT 
        applicants.id,
        applicants.name,
        applicants.email,
        -- applicants.mailing_address,
        applicants.division,
        applicants.district,
        -- applicants.upazila,
        applicants.address_details,
        -- applicants.language_proficiency,
        exam_infos.exam_name,
        exam_infos.university,
        exam_infos.board,
        exam_infos.result,
        training.training_name,
        training.training_details
    FROM applicants
    LEFT JOIN exam_infos ON applicants.id = exam_infos.applicant_id
    LEFT JOIN training ON applicants.id = training.applicant_id
    ORDER BY applicants.id DESC
    LIMIT :offset, :perPage
");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['PHP_SELF'] === '/api/edit') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mailingAddress = $_POST['mailing_address'];
    $division = $_POST['division'];
    $district = $_POST['district'];
    $upazila = $_POST['upazila'];
    $addressDetails = $_POST['address_details'];
    $languageProficiency = $_POST['language_proficiency'];

    $stmt = $conn->prepare("UPDATE applicants SET name = ?, email = ?, mailing_address = ?, division = ?, district = ?, upazila = ?, address_details = ?, language_proficiency = ? WHERE id = ?");
    $stmt->execute([$name, $email, $mailingAddress, $division, $district, $upazila, $addressDetails, $languageProficiency, $id]);

    $response = array('message' => 'Edit operation successful');
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['PHP_SELF'] === '/api/delete') {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM applicants WHERE id = ?");
    $stmt->execute([$id]);

    $response = array('message' => 'Delete operation successful');
    echo json_encode($response);
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <title>Data Table with Pagination</title>
    
   <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px;
        border: 1px solid black;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 8px 16px;
        text-decoration: none;
        color: #000;
        background-color: #f2f2f2;
        border: 1px solid #ddd;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    /* Modal Styles */
    #edit-modal {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(3, auto);
        grid-gap: 10px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    #edit-modal h3 {
        color: #333;
    }

    #edit-modal form {
        background-color: #fff;
        padding: 20px;
        width: 700px;
        margin: 10px auto;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    #edit-modal label {
        display: block;
        margin-bottom: 5px;
        color: #333;
        grid-column: 1 / 2;
    }

    #edit-modal input[type="text"] {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        grid-column: 2 / 3;
    }

    #edit-modal button[type="submit"] {
        background-color: #333;
        color: #fff;
        padding: 8px 16px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        grid-column: 1 / 5;
    }
</style>

</head>
<body>
    
  <h2 style="text-align: center;">Student Registration List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <!-- <th>mailing</th> -->
            <th>division</th>
            <th>district</th>
            <!-- <th>upazilla</th> -->
            <th>address</th>
            <!-- <th>language</th> -->
            <th>Exam Name</th>
            <th>University</th>
            <th>Board</th>
            <th>Result</th>
            <th>Training Name</th>
            <th>Training Details</th>
            <th>Action</th>
        </tr>
        <?php foreach ($rows as $row) : ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['email']; ?></td>
                <!-- <td><?= $row['mailing_address']; ?></td> -->
                <td><?= $row['division']; ?></td>
                <td><?= $row['district']; ?></td>
                <!-- <td><?= $row['upazilla']; ?></td> -->
                <td><?= $row['address_details']; ?></td>
                <!-- <td><?= $row['language_proficiency']; ?></td> -->
                <td><?= $row['exam_name']; ?></td>
                <td><?= $row['university']; ?></td>
                <td><?= $row['board']; ?></td>
                <td><?= $row['result']; ?></td>
                <td><?= $row['training_name']; ?></td>
                <td><?= $row['training_details']; ?></td>
                <td>
                    <button class="edit-btn" data-id="<?= $row['id']; ?>">Edit</button>
                    <button class="delete-btn" data-id="<?= $row['id']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="?page=<?= $i; ?>" <?= ($i === $currentPage) ? 'class="active"' : ''; ?>><?= $i; ?></a>
        <?php endfor; ?>
    </div>

  <div id="edit-modal" style="display: none;">
<h3>Edit Applicant</h3>
    <form id="update-form" method="POST">
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-name" style="width: 12%;">Name:</label>
            <input type="text" name="name" id="edit-name" class="form-control" style="flex: 2;">
            <label for="edit-email" style="width: 15%;">Email:</label>
            <input type="text" name="email" id="edit-email" class="form-control" style="flex: 2;">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-mailing-address" style="width: 25%;">Mailing Address:</label>
            <input type="text" name="mailing_address" id="edit-mailing-address" class="form-control" style="flex: 2;">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-division" style="width: 10%;">Division:</label>
            <input type="text" name="division" id="edit-division" class="form-control" style="flex: 2;">
            <label for="edit-district" style="width: 10%;">District:</label>
            <input type="text" name="district" id="edit-district" class="form-control" style="flex: 2;">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-upazila" style="width: 10%;">Upazila:</label>
            <input type="text" name="upazila" id="edit-upazila" class="form-control" style="flex: 2;">
            <label for="edit-address-details" style="width: 10%;">Address Details:</label>
            <input type="text" name="address_details" id="edit-address-details" class="form-control" style="flex: 2;">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-language-proficiency" style="width: 10%;">Language:</label>
            <input type="text" name="language_proficiency" id="edit-language-proficiency" class="form-control" style="flex: 2;">
            <label for="edit-exam-name" style="width: 10%;">Exam Name:</label>
            <input type="text" name="exam_name" id="edit-exam-name" class="form-control" style="flex: 2;">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-university" style="width: 10%;">University:</label>
            <input type="text" name="university" id="edit-university" class="form-control" style="flex: 2;">
            <label for="edit-board" style="width: 10%;">Board:</label>
            <input type="text" name="board" id="edit-board" class="form-control" style="flex: 2;">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-result" style="width: 10%;">Result:</label>
            <input type="text" name="result" id="edit-result" class="form-control" style="flex: 2;">
            <label for="edit-training-name" style="width: 10%;">Training Name:</label>
            <input type="text" name="training_name" id="edit-training-name" class="form-control" style="flex: 2;">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-training-details" style="width: 10%;">Training Details:</label>
            <input type="text" name="training_details" id="edit-training-details" class="form-control" style="flex: 2;">
        </div>
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="edit-photo" style="width: 10%;">Photo:</label>
            <input type="file" name="photo" id="edit-photo" class="form-control" style="flex: 2;">
            <label for="edit-cv-attachment" style="width: 10%;">CV :</label>
            <input type="file" name="cv_attachment" id="edit-cv-attachment" class="form-control" style="flex: 2;">
        </div>
        <button type="submit">Update</button>
    </form>
</div>

    <script>
       $(document).ready(function() {
    $(".edit-btn").click(function() {
        var id = $(this).data("id"); 
        $('#edit-modal').show();
        $.ajax({
            url: "update-applicants.php",
            method: "GET",
            data: { id: id },
            success: function(response) {
                var applicant = response.applicant;
                $("#edit-id").val(applicant.id);
                $("#edit-name").val(applicant.name);
                $("#edit-email").val(applicant.email);
                $("#edit-mailing-address").val(applicant.mailing_address);
                $("#edit-division").val(applicant.division);
                $("#edit-district").val(applicant.district);
                $("#edit-upazila").val(applicant.upazila);
                $("#edit-address-details").val(applicant.address_details);
                $("#edit-language-proficiency").val(applicant.language_proficiency);
                $("#edit-exam-name").val(applicant.exam_name);
                $("#edit-university").val(applicant.university);
                $("#edit-board").val(applicant.board);
                $("#edit-result").val(applicant.result);
                $("#edit-training-name").val(applicant.training_name);
                $("#edit-training-details").val(applicant.training_details);
                $("#edit-modal").show();
            }
        });
    });

    $("#edit-form").submit(function(e) {
        e.preventDefault();
        var id = $("#edit-id").val();
        var name = $("#edit-name").val();
        var email = $("#edit-email").val();
        var mailingAddress = $("#edit-mailing-address").val();
        var division = $("#edit-division").val();
        var district = $("#edit-district").val();
        var upazila = $("#edit-upazila").val();
        var addressDetails = $("#edit-address-details").val();
        var languageProficiency = $("#edit-language-proficiency").val();
        var examName = $("#edit-exam-name").val();
        var university = $("#edit-university").val();
        var board = $("#edit-board").val();
        var result = $("#edit-result").val();
        var trainingName = $("#edit-training-name").val();
        var trainingDetails = $("#edit-training-details").val();

        $.ajax({
            url: "update-applicants.php",
            method: "POST",
            data: {
                id: id,
                name: name,
                email: email,
                mailing_address: mailingAddress,
                division: division,
                district: district,
                upazila: upazila,
                address_details: addressDetails,
                language_proficiency: languageProficiency,
                exam_name: examName,
                university: university,
                board: board,
                result: result,
                training_name: trainingName,
                training_details: trainingDetails
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            }
        });
    });


    //ajax delete req

    $(".delete-btn").click(function() {
        var id = $(this).data("id");
        // alert(id);
        if (confirm("Are you sure you want to delete this applicant?")) {
            $.ajax({
                url: "delete-applicants.php",
                method: "POST",
                data: { id: id },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                }
            });
        }
    });
});

    </script>
</body>
</html>
