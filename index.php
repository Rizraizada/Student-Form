<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mailingAddress = $_POST['mailing_address'];
    $division = $_POST['division'];
    $district = $_POST['district'];
    $upazila = $_POST['upazila'];
    $addressDetails = $_POST['address_details'];
    $languageProficiency = isset($_POST['language_proficiency']) ? implode(', ', $_POST['language_proficiency']) : '';
    $photo = $_FILES['photo']['name'];
    $cvAttachment = $_FILES['cv_attachment']['name'];

    $host = 'localhost';
    $dbname = 'bigm';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO applicants (name, email, mailing_address, division, district, upazila, address_details, language_proficiency, photo, cv_attachment) VALUES (:name, :email, :mailing_address, :division, :district, :upazila, :address_details, :language_proficiency, :photo, :cv_attachment)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mailing_address', $mailingAddress);
        $stmt->bindParam(':division', $division);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':upazila', $upazila);
        $stmt->bindParam(':address_details', $addressDetails);
        $stmt->bindParam(':language_proficiency', $languageProficiency);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':cv_attachment', $cvAttachment);
        $stmt->execute();

        $applicantId = $pdo->lastInsertId();

        $examNames = (array) $_POST['exam_name'];
        $universities = (array) $_POST['university'];
        $boards = (array) $_POST['board'];
        $results = (array) $_POST['result'];

        $stmt = $pdo->prepare("INSERT INTO exam_infos (applicant_id, exam_name, university, board, result) VALUES (:applicant_id, :exam_name, :university, :board, :result)");

        for ($i = 0; $i < count($examNames); $i++) {
            $examName = $examNames[$i];
            $university = $universities[$i];
            $board = $boards[$i];
            $result = $results[$i];

            $stmt->bindParam(':applicant_id', $applicantId);
            $stmt->bindParam(':exam_name', $examName);
            $stmt->bindParam(':university', $university);
            $stmt->bindParam(':board', $board);
            $stmt->bindParam(':result', $result);

            $stmt->execute();
        }

       if (isset($_POST['training']) && $_POST['training'] === 'yes') {
        $trainingData = isset($_POST['trainingData']) ? $_POST['trainingData'] : array();

        $stmt = $pdo->prepare("INSERT INTO training (applicant_id, training_name, training_details) VALUES (:applicant_id, :training_name, :training_details)");
        
        for ($i = 0; $i < count($trainingData); $i++) {
            $trainingName = $trainingData[$i]['trainingName'];
            $trainingDetail = $trainingData[$i]['details'];
        
            $stmt->bindValue(':applicant_id', $applicantId);
            $stmt->bindValue(':training_name', $trainingName);
            $stmt->bindValue(':training_details', $trainingDetail);
        
            $stmt->execute();
        }
        
}


        $targetDir = 'uploads/';
        move_uploaded_file($_FILES['photo']['tmp_name'], $targetDir . $photo);
        move_uploaded_file($_FILES['cv_attachment']['tmp_name'], $targetDir . $cvAttachment);

        $successMessage = 'Registration successful!';
    } catch (PDOException $e) {
        $errorMessage = 'Error: ' . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="container">
    <h2 style="text-align: center; color: #333; font-size: 24px; margin-top: 20px;">
        Student Registration Form
    </h2>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="name">Applicant's Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="mailing_address">Mailing Address:</label><br>
        <textarea name="mailing_address" id="mailing_address" required></textarea><br>

        <label for="division">Division:</label>
        <select name="division" id="division" required>
            <option value="">Select Division</option>
            <option value="Dhaka">Dhaka</option>
            <option value="Chittagong">Chittagong</option>
            <option value="Rajshahi">Rajshahi</option>
            <option value="Barisal">Barisal</option>
            <option value="Sylhet">Sylhet</option>
            <option value="Khulna">Khulna</option>
            <option value="Mymensingh">Mymensingh</option>
            <option value="Rangpur">Rangpur</option>
        </select><br><br>

        <label for="district">District:</label>
        <select name="district" id="district" required>
            <option value="">Select District</option>
        </select><br><br>

        <label for="upazila">Upazila / Thana:</label>
        <select name="upazila" id="upazila" required>
            <option value="">Select Upazila / Thana</option>
        </select><br><br>

        <label for="address_details">Address Details:</label><br>
        <textarea name="address_details" id="address_details" required></textarea><br><br>

        <label for="language_proficiency">Language Proficiency:</label><br>
        <input type="checkbox" name="language_proficiency[]" value="Bangla"> Bangla
        <input type="checkbox" name="language_proficiency[]" value="English"> English
        <input type="checkbox" name="language_proficiency[]" value="French"> French<br><br>

        <label>Education Qualification:</label><br>
        <table id="education_table">
            <thead>
                <tr>
                    <th>Exam Name</th>
                    <th>University</th>
                    <th>Board</th>
                    <th>Result</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="exam_name[]" required>
                            <option value="">Select Exam</option>
                            <option value="SSC">SSC</option>
                            <option value="HSC">HSC</option>
                            <option value="Bachelor">Bachelor</option>
                            <option value="Master">Master</option>
                        </select>
                    </td>
                    <td>
                        <select name="university[]" required>
                            <option value="">Select University</option>
                            <option value="University 1">University 1</option>
                            <option value="University 2">University 2</option>
                            <option value="University 3">University 3</option>
                        </select>
                    </td>
                    <td>
                        <select name="board[]" required>
                            <option value="">Select Board</option>
                            <option value="Board 1">Board 1</option>
                            <option value="Board 2">Board 2</option>
                            <option value="Board 3">Board 3</option>
                        </select>
                    </td>
                    <td><input type="number" name="result[]" required></td>
                    <td><button type="button" class="delete-button" onclick="deleteEducationRow(this)">Delete</button></td>
                </tr>
            </tbody>
        </table>
        <button id="add_education_button" type="button">Add More</button>

        

        <label for="photo">Photo:</label>
        <input type="file" name="photo" accept="image/*" required><br><br>

        <label for="cv_attachment">CV Attachment:</label>
        <input type="file" name="cv_attachment" accept=".doc, .docx, .pdf" required><br><br>

        <label for="training">Training:</label>
    <div id="trainingContainer">
        <input type="radio" name="training" value="yes" required onclick="toggleTrainingContainer(true)"> Yes
        <input type="radio" name="training" value="no" required onclick="toggleTrainingContainer(false)"> No
    </div>
   
    <div id="fillContainer" style="display: none;">
        <table id="trainingTable">
            <thead>
                <tr>
                    <th>Training Name</th>
                    <th>Details</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="fieldsContainer">
                <tr id="trainingRow_0">
                    <td><input type="text" name="trainingData[0][trainingName]" /></td>
                    <td><input type="text" name="trainingData[0][details]" /></td>
                    <td><button type="button" onclick="removeField(0)">Delete</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <button type="button" onclick="addMoreFields()">Add More</button><br><br>
        <button type="submit">Submit</button>
    </form>

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

    function updateOptions () {
        const selectedDivision = divisionDropdown.value;
        const selectedDistrict = districtDropdown.value;

        // Clear existing options
        districtDropdown.innerHTML = '';
        upazilaDropdown.innerHTML = '';
        if(!options[selectedDivision]) return 
        console.log(options[selectedDivision], "options log")
        // Add new district options
        Object?.keys(options[selectedDivision]).forEach(district => {
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

     updateOptions();

        let educationCounter = 1;
        let trainingCounter = 1;
        

        function deleteEducationRow(row) {
            console.log(row, "row...")
            row.parentNode.parentNode.remove();
        }

        // function deleteTrainingField(field) {
        //     field.parentNode.remove();
        // }

        // // let educationCounter = 1;
        // function addMoreFields() {
        //     const container = document.getElementById('trainingFields');
        //     const newField = container.cloneNode(true);
        //     const deleteButton = document.createElement('button');
        //     deleteButton.setAttribute('type', 'button');
        //     deleteButton.setAttribute('class', 'delete-button');
        //     deleteButton.setAttribute('onclick', 'deleteTrainingField(this)');
        //     deleteButton.textContent = 'Delete';
        //     newField.appendChild(deleteButton);
        //     document.getElementById('trainingContainer').appendChild(newField);
        //     trainingCounter++;
        // }

        // function toggleTrainingContainer(value) {
        //     const container = document.getElementById('fillContainer');
        //     container.style.display = value ? 'block' : 'none';
        // }  

        var fieldIndex = 1;

function addMoreFields() {
    var tableBody = document.getElementById('fieldsContainer');
    var newRow = document.createElement('tr');
    newRow.id = 'trainingRow_' + fieldIndex;
    newRow.innerHTML = '<td><input type="text" name="trainingData[' + fieldIndex + '][trainingName]" /></td><td><input type="text" name="trainingData[' + fieldIndex + '][details]" /></td><td><button type="button" onclick="removeField(' + fieldIndex + ')">Delete</button></td>';
    tableBody.appendChild(newRow);
    fieldIndex++;
}

function removeField(index) {
    var rowToRemove = document.getElementById('trainingRow_' + index);
    rowToRemove.parentNode.removeChild(rowToRemove);
}

function toggleTrainingContainer(showContainer) {
    var fillContainer = document.getElementById('fillContainer');
    fillContainer.style.display = showContainer ? 'block' : 'none';
}










        
        const addEducationButton = document.getElementById('add_education_button');
        const educationTable = document.getElementById('education_table');

        addEducationButton.addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <select name="exam_name[]" required>
                        <option value="">Select Exam</option>
                        <option value="SSC">SSC</option>
                        <option value="HSC">HSC</option>
                        <option value="Bachelor">Bachelor</option>
                        <option value="Master">Master</option>
                    </select>
                </td>
                <td>
                    <select name="university[]" required>
                        <option value="">Select University</option>
                        <option value="University 1">University 1</option>
                        <option value="University 2">University 2</option>
                        <option value="University 3">University 3</option>
                    </select>
                </td>
                <td>
                    <select name="board[]" required>
                        <option value="">Select Board</option>
                        <option value="Board 1">Board 1</option>
                        <option value="Board 2">Board 2</option>
                        <option value="Board 3">Board 3</option>
                    </select>
                </td>
                <td><input type="text" name="result[]" required></td>
                <td><button type="button" class="delete-button" onclick="deleteEducationRow(this)">Delete</button></td>
            `;

            educationTable.appendChild(newRow);
        });
    </script>
</body>
</html>





