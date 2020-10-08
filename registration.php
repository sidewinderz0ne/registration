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
        <div>
            <?php

            ?>
        </div>
        <div>
            <form action="registration.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1>Registration</h1><br>
                            <input class="form-control" type="tel" id="mobile" name="mobile" placeholder="Mobile Number" pattern="[0][8][0-9]{10}" oninvalid="this.setCustomValidity('Please enter valid Indonesian phone number')" required><br>
                            <input class="form-control" type="text" id="firstname" name="firstname" placeholder="First Name" required><br>
                            <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Last Name" required><br>
                            Date of Birth<br>
                            <select name="month">
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
                            <select name="date">
                                <option value="Date">Date</option>
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>
                            </select>&nbsp;
                            <select name="year">
                                <option value="Year">Year</option>
                                <?php
                                for ($i = 2021; $i >= 1950; $i--) {
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>
                            </select><br><br>
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="male">&nbsp;Male&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female">&nbsp;Female
                            <br><br>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Email" required><br>
                            <input class="btn btn-primary btn-sm btn-block" type="submit" id="register" name="register" value="Register">
                        </div>
                    </div>
                </div>
            </form>
            <div>
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
                </script>
    </body>

    </html>