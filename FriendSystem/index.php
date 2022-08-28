<?php
include ("functions/header.php");
?>
<h1> My Friend System Assignment Home Page</h1>

<P>
    Name: Benyamin Saatlou<br>
    StudentID: 202432042<br>
    Email: <a href="mailto:10252224@student.edu.au">102542054@student.swin.edu.au</a><br>
</p>
<div class="declaration">
<p>I declare that this assignment is my individual work. I have not worked collaboratively  nor have I
    copied from any other student’s work or from any other source.<br><br><div>
    <div class= "centerlinks">
    <a class='a' href="signup.php">Sign-Up</a>
    <a class='a' href="login.php">Log-In</a>
    <a class='a' href="about.php">About </a>
</div>
</p>
<?php
include 'functions/setting.php';
include 'functions/functions.php';

create_table($conn);

include ("functions/footer.php");
?>

