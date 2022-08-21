<?php
//includes everything that is needed
include ("functions/setting.php");
include ("functions/functions.php");

?>




<?php
$Email = isset($_POST['loginEmail']) ? $_POST['loginEmail'] : null;
$Email = str_replace(' ', '', $Email);
$Pass = isset($_POST['loginPass']) ? $_POST['loginPass'] : null;
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
      /*END OF EMAIL ERRORS*/

       /*START OF PASS ERRORS*/
    if (empty($Pass))
    {
        $error[1] = "Password can not be empty";

    }
    elseif (!preg_match("/^[a-zA-Z0-9]+$/", $Pass))
    {
        $error[1] = 'Password can only conatain letters and numbers';

    }
    /*END OF PASS ERRORS*/

    create_table($conn);
    $query = "SELECT * FROM friends";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result))
    {

        if ($row["friend_email"] == $Email && $row["password"] == $Pass)
        {

            $_SESSION['name'] = $row['profile_name'];
            $_SESSION['id'] = $row['friend_id'];
            $_SESSION['login'] = "success";
            header("Location: friendlist.php");

        }

     

    }

  

        $notloggedin = "Sorry wrong email or password, <br>if you don't have an account you can signup <a href='signup.php'>HERE</a>";

    

}

if (isset($reset))
{
    $Email = null;

}
?>

<h1> My Friend System Assignment Login Page</h1>
<?php
include ("functions/header.php");
if (!isset($_POST['submit']))
{
    $Email = null;
    $notloggedin = null;
}
?>


<form method="POST" class="form" action="login.php">
<div class="input-container">                  
<label for= "loginEmail">Email</label>
<input type="text" name="loginEmail"  value="<?php echo htmlspecialchars($Email) ?> "><?php if (isset($error[0]))
{ ?>
            <?php
    echo "<p class=\"error\">" . $error[0] . "</p>"

?>
        <?php
} ?><br>
</div>
<div class="input-container">
<label for="loginPass">Password</label>              
<input type="password" name="loginPass"><?php if (isset($error[1]))
{ ?>
            <?php
    echo "<p class=\"error\">" . $error[1] . "</p>"

?>
        <?php
} ?><br>
</div>


        <input type="submit" name="submit" class= "button" value="Login">
        <input type="submit" name="reset" class= "button" value="Clear">
        <br><br>

        <a class="a" href="index.php" >HOME</a>
      
    </form>
 
<?php
echo "<p>$notloggedin</p>";
include ("functions/footer.php"); ?>
