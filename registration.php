<?php
require_once('config.php');
?>
<DOCTYPE html>
    <html>

    <head>
        <title>Registration</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    </head>
    <body>
        <?php 
        $_SESSION['message'] = ''; 
        $_GRAYED['value'] = '';
        $_VISIBILITY['class'] = 'btn invisible';
        if (isset($_POST['register'])) {

            $_GRAYED['value'] = 'disabled';

            $mobile     = $_POST['mobile'];
            $firstname  = $_POST['firstname'];
            $lastname   = $_POST['lastname'];
            if ($_POST['month'] == 'Month' || $_POST['date'] == 'Date' || $_POST['year'] == 'Year'){
                $birth      = 'na';
            } else {
                $birth      = $_POST['month'] . "-" . $_POST['date'] . "-" . $_POST['year'];
            }
            if (empty($_POST['gender'])){
                $gender      = 'na';
            } else {
                $gender      = $_POST['gender'];;
            }
            $email      = $_POST['email'];
        
            $stmt = $db->prepare('SELECT COUNT(email) AS EmailCount FROM users WHERE email = :email');
            $stmt->execute(array('email' => $email));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $stmtm = $db->prepare('SELECT COUNT(mobile) AS MobileCount FROM users WHERE mobile = :mobile');
            $stmtm->execute(array('mobile' => $mobile));
            $resultm = $stmtm->fetch(PDO::FETCH_ASSOC);
        
            if ($result['EmailCount'] == 0 && $resultm['MobileCount'] == 0) {
                $sql = "INSERT INTO users (mobile, firstname, lastname, birth, gender, email) VALUES (?,?,?,?,?,?)";
                $stmtinsert = $db->prepare($sql);
                $result = $stmtinsert->execute([$mobile, $firstname, $lastname, $birth, $gender, $email]);
                $_VISIBILITY['class'] = 'btn btn-primary btn-sm btn-block';
            } else if($result['EmailCount'] != 0 && $resultm['MobileCount'] != 0){
                $_SESSION['message'] = 'E-mail and mobile already registered!';
                $_GRAYED['value'] = '';
            } else if($result['EmailCount'] != 0){
                $_SESSION['message'] = 'E-mail already registered!';
                $_GRAYED['value'] = '';
            } else if($resultm['MobileCount'] != 0){
                $_SESSION['message'] = 'Mobile already registered!';
                $_GRAYED['value'] = '';
            } else {
                $_SESSION['message'] = 'Data error!';
                $_GRAYED['value'] = '';
            }
        }
        ?>
        <div>
            <form action="registration.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1>Registration</h1><br>
                            <input class="form-control" type="tel" id="mobile" name="mobile" placeholder="Mobile Number" pattern="(\()?(\+62|62|0)(\d{2,3})?\)?[ .-]?\d{2,4}[ .-]?\d{2,4}[ .-]?\d{2,4}" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Please enter valid Indonesian phone number')" required <?php echo $_GRAYED['value']; ?>><br>
                            <input class="form-control" type="text" id="firstname" name="firstname" placeholder="First Name" required <?php echo $_GRAYED['value']; ?>><br>
                            <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Last Name" required <?php echo $_GRAYED['value']; ?>><br>
                            Date of Birth<br>
                            <select name="month" <?php echo $_GRAYED['value']; ?>>
                                <option value="Month">Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>&nbsp;
                            <select name="date" <?php echo $_GRAYED['value']; ?>>
                                <option value="Date">Date</option>
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>
                            </select>&nbsp;
                            <select name="year" <?php echo $_GRAYED['value']; ?>>
                                <option value="Year">Year</option>
                                <?php
                                for ($i = 2021; $i >= 1950; $i--) {
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>
                            </select><br><br>
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="male" <?php echo $_GRAYED['value']; ?>>&nbsp;Male&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female" <?php echo $_GRAYED['value']; ?>>&nbsp;Female
                            <br><br>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Email" required <?php echo $_GRAYED['value']; ?>><br>
                            <div class="text-danger"><?php 
                            if (isset($_SESSION['message']))
                            {
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                            ?></div>
                            <input class="btn btn-primary btn-sm btn-block" type="submit" id="register" name="register" value="Register" <?php echo $_GRAYED['value']; ?>>
                            <input class="btn btn-primary btn-sm btn-block" type="submit" id="login" name="login" value="Login" onClick="Javascript:window.location.href = 'login.php';">
                        </div>
                    </div>
                </div>
            </form>
            <div>
                <!-- IF WE WANT TO USE JQUERY
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
                <script type="text/javascript">
                    $(function() {
                        $('#register').click(function(e) {

                            var valid = this.form.checkValidity();
                            if (valid) {

                                var mobile = $('#mobile').val();
                                var firstname = $('#firstname').val();
                                var lastname = $('#lastname').val();
                                var email = $('#email').val();

                                e.preventDefault();

                                $.ajax({
                                    type: 'POST',
                                    url: 'process.php',
                                    data: {
                                        mobile: mobile,
                                        firstname: firstname,
                                        lastname: lastname,
                                        email: email
                                    },
                                    success: function(data) {
                                        if(data == 'success'){
                                            Swal.fire({
                                            'title': 'Success!',
                                            'text': 'Successfully saved!',
                                            'type': 'success'
                                        })
                                        }else{
                                            Swal.fire({
                                            'title': 'Maybe you are already registered?',
                                            'text': data,
                                            'type': 'error'
                                        })   
                                        }
                                    },
                                    error: function(data) {
                                        Swal.fire({
                                            'title': 'Something went wrong!',
                                            'text': 'Unfortunately you caught an error',
                                            'type': 'error'
                                        })
                                    }
                                });

                            } else {

                            }
                        });
                    });
                </script> -->
    </body>

    </html>