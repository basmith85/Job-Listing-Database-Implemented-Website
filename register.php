<?php include('db_config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="password"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register an Account</h1>
        <!-- User type selection -->
        <label for="user_type">Select User Type:</label>
        <select name="user_type" id="user_type" required>
            <option value="">Select User Type</option>
            <option value="user">Applicant</option>
            <option value="company">Employer</option>
        </select>

        <!-- Applicant registration form -->
        <div id="applicant_fields" style="display: none;">
            <form action="register_process.php" method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="text" name="firstname" placeholder="First Name">
                <input type="text" name="lastname" placeholder="Last Name">
                <input type="tel" name="phone" placeholder="Phone Number" required pattern="[0-9 ()-]+">
                <input type="hidden" name="user_type" value="user">
                <input type="submit" value="Register">
            </form>
        </div>

        <!-- Employer registration form -->
        <div id="company_fields" style="display: none;">
            <form action="register_process.php" method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="text" name="c_name" placeholder="Company Name">
                <input type="text" name="location" placeholder="Location">
                <input type="text" name="industry" placeholder="Industry">
                <input type="hidden" name="user_type" value="company">
                <input type="submit" value="Register">
            </form>
        </div>

        <!-- Script to show/hide fields based on user type selection -->
        <script>
            document.getElementById('user_type').addEventListener('change', function() {
                var applicantFields = document.getElementById('applicant_fields');
                var companyFields = document.getElementById('company_fields');
                if (this.value === 'user') {
                    applicantFields.style.display = 'block';
                    companyFields.style.display = 'none';
                } else if (this.value === 'company') {
                    applicantFields.style.display = 'none';
                    companyFields.style.display = 'block';
                } else {
                    applicantFields.style.display = 'none';
                    companyFields.style.display = 'none';
                }
            });
        </script>
    </div>
</body>
</html>
