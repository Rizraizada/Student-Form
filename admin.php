<?php
$applicantName = '';
$emailAddress = '';
$selectedDivision = '';
$selectedDistrict = '';
$selectedUpazila = '';

$districtOptions = array(
    'Dhaka' => array('Dhaka District 1', 'Dhaka District 2', 'Dhaka District 3'),
    'Chittagong' => array('Chittagong District 1', 'Chittagong District 2', 'Chittagong District 3'),
    'Rajshahi' => array('Rajshahi District 1', 'Rajshahi District 2', 'Rajshahi District 3'),
    'Barisal' => array('Barisal District 1', 'Barisal District 2', 'Barisal District 3'),
    'Sylhet' => array('Sylhet District 1', 'Sylhet District 2', 'Sylhet District 3'),
    'Khulna' => array('Khulna District 1', 'Khulna District 2', 'Khulna District 3'),
    'Mymensingh' => array('Mymensingh District 1', 'Mymensingh District 2', 'Mymensingh District 3'),
    'Rangpur' => array('Rangpur District 1', 'Rangpur District 2', 'Rangpur District 3'),
);

$upazilaOptions = array(
    'Dhaka District 1' => array('Upazila 1', 'Upazila 2', 'Upazila 4'),
    'Dhaka District 2' => array('Upazila 4', 'Upazila 5', 'Upazila 6'),
    'Dhaka District 3' => array('Upazila 7', 'Upazila 8', 'Upazila 9'),
    'Chittagong District 1' => array('Upazila 13', 'Upazila 14', 'Upazila 15'),
);

function generateOptions($options, $selectedValue = '')
{
    $html = '<option value="">Select an option</option>';
    foreach ($options as $option) {
        $selected = ($selectedValue === $option) ? 'selected' : '';
        $html .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
    }
    return $html;
}




?>

<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .form-container {
            width: 488px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        .btn-primary {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        .error-message {
            text-align: center;
            margin-top: 20px;
            color: red;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }


        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .data-table th,
        .data-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .data-table th {
            background-color: #4CAF50;
            color: white;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .data-table tr:hover {
            background-color: #ddd;
        }
        
        .photo {
            width: 50px;
        }
        
        .download-link {
            text-decoration: none;
            color: blue;
        }
        
        .edit-link,
        .delete-link {
            text-decoration: none;
            color: green;
            margin-right: 5px;
        }
        
        .delete-link {
            color: red;
        }

        #popup {
        display: none;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        padding: 20px;
        width: 800px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    #popup h3 {
        margin-top: 0;
    }

    #popup label {
        display: block;
        margin-top: 10px;
    }

    #popup input[type="text"] {
        width: 100%;
        padding: 5px;
        margin-top: 5px;
        box-sizing: border-box;
    }

    #popup button[type="submit"] {
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    </style>
    </head>
<body>
<h2>Admin Panel</h2>
<div class="form-container">
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group" style="display: flex; align-items: center;">
            <label for="name" style="width: 10%;">Name:</label>
            <input type="text" id="name" name="name" class="form-control" style="flex:2;" value="<?php echo isset($applicantName) ? htmlspecialchars($applicantName) : ''; ?>">
            <label for="email" style="width: 10%;">Email:</label>
            <input type="email" id="email" name="email" class="form-control" style="flex:2;" value="<?php echo isset($emailAddress) ? htmlspecialchars($emailAddress) : ''; ?>">
        </div>

        <div class="form-group" style="display: flex; align-items: center;">
            <label for="division" style="width: 25%;">Division:</label>
            <select id="division" name="division" class="form-control" onchange="updateDistrictOptions(this)">
                <?php echo generateOptions(array_keys($districtOptions ?? []), isset($selectedDivision) ? $selectedDivision : ''); ?>
            </select>
        </div>

        <div class="form-group" style="display: flex; align-items: center;">
            <label for="district" style="width: 25%;">District:</label>
            <select id="district" name="district" class="form-control" onchange="updateUpazilaOptions(this)">
                <?php
                if (isset($selectedDivision) && isset($districtOptions[$selectedDivision])) {
                    echo generateOptions($districtOptions[$selectedDivision], isset($selectedDistrict) ? $selectedDistrict : '');
                }
                ?>
            </select>
        </div>

        <div class="form-group" style="display: flex; align-items: center;">
            <label for="upazila" style="width: 25%;">Upazila:</label>
            <select id="upazila" name="upazila" class="form-control">
                <?php
                if (isset($selectedDistrict) && isset($upazilaOptions[$selectedDistrict])) {
                    echo generateOptions($upazilaOptions[$selectedDistrict], isset($selectedUpazila) ? $selectedUpazila : '');
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn-primary">Search</button>
    </form>
</div>



<div id="popup" style="display: none;">
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
    function updateDistrictOptions(divisionSelect) {
        const selectedDivision = divisionSelect.value;
        const districtSelect = document.getElementById('district');
        districtSelect.innerHTML = generateOptions(<?php echo json_encode($districtOptions); ?>[selectedDivision]);
        updateUpazilaOptions(districtSelect);
    }

    function updateUpazilaOptions(districtSelect) {
        const selectedDistrict = districtSelect.value;
        const upazilaSelect = document.getElementById('upazila');
        upazilaSelect.innerHTML = generateOptions(<?php echo json_encode($upazilaOptions); ?>[selectedDistrict]);
    }
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = new PDO('mysql:host=localhost;dbname=bigm', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        function checkDataExists($conn, $applicantName, $emailAddress, $selectedDivision, $selectedDistrict, $selectedUpazila)
        {
            $query = "SELECT applicants.*, exam_infos.exam_name, exam_infos.board, exam_infos.university, exam_infos.result, training.training_name, training.training_details
                  FROM applicants
                  LEFT JOIN exam_infos ON applicants.id = exam_infos.applicant_id
                  LEFT JOIN training ON applicants.id = training.applicant_id
                  WHERE applicants.name = :name
                  OR applicants.email = :email
                  OR applicants.division = :division
                  OR applicants.district = :district
                  OR applicants.upazila = :upazila";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $applicantName);
            $stmt->bindParam(':email', $emailAddress);
            $stmt->bindParam(':division', $selectedDivision);
            $stmt->bindParam(':district', $selectedDistrict);
            $stmt->bindParam(':upazila', $selectedUpazila);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }

        // Retrieve form inputs
        $applicantName = $_POST['name'] ?? '';
        $emailAddress = $_POST['email'] ?? '';
        $selectedDivision = $_POST['division'] ?? '';
        $selectedDistrict = $_POST['district'] ?? '';
        $selectedUpazila = $_POST['upazila'] ?? '';
        

        // Check if data exists
        $data = checkDataExists($conn, $applicantName, $emailAddress, $selectedDivision, $selectedDistrict, $selectedUpazila);

        if (!empty($data)) {
            echo '<table class="data-table">';
            echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Division</th><th>District</th><th>Upazila</th><th>Exam Name</th><th>Board</th><th>University</th><th>Result</th><th>Training Name</th><th>Training Details</th><th>Photo</th><th>CV Attachment</th><th>Edit</th><th>Delete</th></tr>';

            foreach ($data as $row) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['division'] . '</td>';
                echo '<td>' . $row['district'] . '</td>';
                echo '<td>' . $row['upazila'] . '</td>';
                echo '<td>' . $row['exam_name'] . '</td>';
                echo '<td>' . $row['board'] . '</td>';
                echo '<td>' . $row['university'] . '</td>';
                echo '<td>' . $row['result'] . '</td>';
                echo '<td>' . $row['training_name'] . '</td>';
                echo '<td>' . $row['training_details'] . '</td>';
                echo '<td><img src="uploads/' . htmlspecialchars($row['photo']) . '" alt="Photo" class="photo"></td>';
                echo '<td><a href="uploads/' . htmlspecialchars($row['cv_attachment']) . '" class="download-link">Download</a></td>';
                echo '<td><a href="#" class="edit-link" data-id="' . $row['id'] . '">Edit</a></td>';
                echo '<td><a href="delete.php?id=' . $row['id'] . '" class="delete-link">Delete</a></td>';
                echo '</tr>';
            }
            
            echo '</table>';
            

        } else {
            $errorMessage = "No data found.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Connection failed: " . $e->getMessage();
    }
} 
?>


 <script>


const divisionDropdown = document.getElementById('division');
    const districtDropdown = document.getElementById('district');
    const upazilaDropdown = document.getElementById('upazila');

    const options = {
        Dhaka: {
            'Dhaka District 1': ['Upazila 1', 'Upazila 2', 'Upazila 3'],
            'Dhaka District 2': ['Upazila 4', 'Upazila 5', 'Upazila 6'],
            'Dhaka District 3': ['Upazila 7', 'Upazila 8', 'Upazila 9'],
        },
        Chittagong: {
            'Chittagong District 1': ['Upazila 10', 'Upazila 11', 'Upazila 12'],
            'Chittagong District 2': ['Upazila 13', 'Upazila 14', 'Upazila 15'],
            'Chittagong District 3': ['Upazila 16', 'Upazila 17', 'Upazila 18'],
        },
        Rajshahi: {
            'Rajshahi District 1': ['Upazila 19', 'Upazila 20', 'Upazila 21'],
            'Rajshahi District 2': ['Upazila 22', 'Upazila 23', 'Upazila 24'],
            'Rajshahi District 3': ['Upazila 25', 'Upazila 26', 'Upazila 27'],
        },
    };

    function updateOptions() {
        const selectedDivision = divisionDropdown.value;
        const selectedDistrict = districtDropdown.value;

        // Clear existing options
        districtDropdown.innerHTML = '';
        upazilaDropdown.innerHTML = '';

        // Add new district options
        Object.keys(options[selectedDivision]).forEach(district => {
            const option = document.createElement('option');
            option.value = district;
            option.textContent = district;
            districtDropdown.appendChild(option);
        });

        // Add new upazila options
        const selectedUpazilas = options[selectedDivision][selectedDistrict] || [];
        selectedUpazilas.forEach(upazila => {
            const option = document.createElement('option');
            option.value = upazila;
            option.textContent = upazila;
            upazilaDropdown.appendChild(option);
        });
    }

    divisionDropdown.addEventListener('change', updateOptions);
    districtDropdown.addEventListener('change', updateOptions);
</script>

<script>
    $(document).on('click', '.edit-link', function(event) {
        event.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: 'fetch_data.php',
            method: 'GET',
            data: { id: id },
            success: function(response) {
                openPopupWithData(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    function openPopupWithData(data) {
        var record = JSON.parse(data);

        $('#edit-id').val(record.id);
        $('#edit-name').val(record.name);
        $('#edit-email').val(record.email);
        $('#edit-mailing-address').val(record.mailing_address);
        $('#edit-division').val(record.division);
        $('#edit-district').val(record.district);
        $('#edit-upazila').val(record.upazila);
        $('#edit-address-details').val(record.address_details);
        $('#edit-language-proficiency').val(record.language_proficiency);
        $('#edit-exam-name').val(record.exam_name);
        $('#edit-university').val(record.university);
        $('#edit-board').val(record.board);
        $('#edit-result').val(record.result);
        $('#edit-training-name').val(record.training_name);
        $('#edit-training-details').val(record.training_details);

        $('#popup').show();
    }

    $('#update-form').submit(function(event) {
    event.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        url: 'update_data.php',
        method: 'POST',
        data: formData,
        success: function(response) {
            console.log(response);
            // Display the response message
            alert(response);
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
});

</script>



<?php
if (isset($errorMessage)) {
    echo '<div class="error-message">' . $errorMessage . '</div>';
}
?>


</body>
</html>
