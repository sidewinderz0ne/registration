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
            <form action="login.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1>Registration</h1><br>
                            <input class="form-control" type="text" id="mobile" name="mobile" placeholder="Mobile Number" pattern="(\()?(\+62|62|0)(\d{2,3})?\)?[ .-]?\d{2,4}[ .-]?\d{2,4}[ .-]?\d{2,4}" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Please enter valid Indonesian phone number')" required><br>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password" required><br>
                            <input class="btn btn-primary btn-sm btn-block" type="submit" id="login" name="login" value="login">
                        </div>
                    </div>
                </div>
            </form>
            <div>
    </body>

    </html>