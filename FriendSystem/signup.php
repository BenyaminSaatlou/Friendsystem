<?php
//includes everything that is needed
include 'functions/functions.php';
include 'functions/setting.php';

//declaring all the variables
$Email = isset($_POST['email']) ? $_POST['email'] : null;
$Email = str_replace(' ', '', $Email);
$Pname = isset($_POST['Pname']) ? $_POST['Pname'] : null;
$passwd = isset($_POST['password']) ? $_POST['password'] : null;
$repassword = isset($_POST['repassword']) ? $_POST['repassword'] : null;
$submit = isset($_POST['submit']) ? $_POST['submit'] : null;
$reset = isset($_POST['reset']) ? $_POST['reset'] : null;

if (isset($submit))
{
    /*START OF EMAIL ERRORS*/
    if (empty($Email))
    {
        $error[0] = "Email can not be empty";

    }
    elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL))
    {
        $error[0] = "Wrong email format";

    }
    elseif (checkifitexist($conn, $Email))
    {

        $error[0] = "Email already in use";
    }

    /*END OF EMAIL ERRORS*/

    /*START OF PROFILE NAME ERRORS*/
    if (empty($Pname))
    {
        $error[1] = "Profile name can not be empty";

    }
    if( ! ctype_alpha( str_replace(' ', '', $Pname)))
    {
    
        $error[1] = 'Profile name can only conatain letters';

    }
    if(strlen($Pname) > 30){

        $error[1] = 'Profile name can not be more than 30 letters';
    }

    /*END OF PROFILE ERRORS*/

    /*START OF PASS ERRORS*/
    if (empty($passwd))
    {
        $error[2] = "Password can not be empty";

    }
    elseif (!preg_match("/^[a-zA-Z0-9]+$/", $passwd))
    {
        $error[2] = 'Password can only conatain letters and numbers';

    }
    elseif ($passwd != $repassword)
    {
        $error[2] = 'Password did not match';

    }

    /*END OF PASS ERRORS*/

    //if there is no error then takes the user info and insterts into the sql table
    if ($error == null)
    {

        include 'functions/setting.php';

        if ($conn)
        {
            $curr_date = date("Y/m/d");
            $query = "INSERT INTO friends 
                (friend_email, password, profile_name, date_started) 
                VALUES ('$Email', '$passwd', '$Pname', '$curr_date')
                ";
            $insert = mysqli_query($conn, $query);

            if ($insert)
            {
                $query = "SELECT * FROM friends";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result))
                {

                    $_SESSION['name'] = $row['profile_name'];
                    $_SESSION['id'] = $row['friend_id'];
                    $_SESSION['login'] = "success";
                    header("Location: friendlist.php");

                }

            }
            else
            {
                $error[3] = "Faild to  sign up, please try again later";
            }
        }
        mysqli_close($conn);
    }

}

/* RESETS EVERYTHIG */
if (isset($reset))
{
    $Email = null;
    $Pname = null;
}
?>

<?php include "functions/header.php";

?>
<h1> My Friend System Assignment Sign Up Page</h1>

<form class="form" method="POST" action="signup.php">

    <div class="input-container">
    <label for="email">Email:</label>
    <input type="text" placeholder="Example@gmail.com" name="email" value="<?php echo htmlspecialchars($Email) ?> " > <?php if (isset($error[0]))
{ ?>
            <?php
    echo "<p class=\"error\">" . $error[0] . "</p>"

?>
        <?php
} ?>
    </div>


    <div class="input-container">
	<label for="Pname">Profile Name:</label>
    <input type="text" name="Pname" value="<?php echo htmlspecialchars($Pname) ?> "  ><?php if (isset($error[1]))
{ ?>
            <?php
    echo "<p class=\"error\">" . $error[1] . "</p>"
?>
        <?php
} ?>
    </div>


    <div class="input-container">
	<label for="password">Password:</label>
    <input type="password" name="password" ><?php if (isset($error[2]))
{ ?>
	<?php
    echo "<p class=\"error\">" . $error[2] . "</p>"
?>
        <?php
} ?>
    <br>
    
    <label for="password">Confirm Password:</label>
    <input type="password" name="repassword" >
    </div>

<br>
<button class="button" type="submit"  name= "submit" >REGISTER</button>
    <button class="button" type="submit" name= "reset" > CLEAR</button><br><br>
     

     <br><br><a class='a' href="index.php" > Home </a> 
     
</form>






<?php include ("functions/footer.php");?>
