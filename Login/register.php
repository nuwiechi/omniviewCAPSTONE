<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="styles.css" />

        <title>Sign-Up</title>
    </head>

    <body>
        <div class="container">
            <div class="box form-box">
                <?php
                    include ("config.php");
                    if (isset($_POST['submit'])) {
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $age = $_POST['age'];
                        $password = $_POST['password'];

                        $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

                        if (mysqli_num_rows($verify_query) !=0) {
                            echo "<div class='message'><p>This email is already in used, Please try a new one!</p></div><br>";
                            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                        }
                            else {
                                mysqli_query($con,"INSERT INTO users(Username,Email,Age,Password) VALUES('$username','$email','$age','$password')") or die("Error Occured!");

                                echo "<div class='message'><p>Registration Successful!</p></div><br>";
                                echo "<a href='index.php'><button class='btn'>Login Now</button>";
                            }
                    } else {
                ?>

                <header>Sign-Up</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" required/>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" autocomplete="off" required/>
                    </div>

                    <div class="field input">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" autocomplete="off" required/>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required/>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register" required/>
                    </div>

                    <div class="links">
                        Already have an account? <a href="index.php">Login</a>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </body>
</html>