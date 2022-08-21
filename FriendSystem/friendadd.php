<?php
include ("functions/header.php");
echo"<h1> My Friend System Assignment Friend Add Page</h1>";
include ("functions/setting.php");
include ("functions/functions.php");

if (!isset($_SESSION['login']))
{
    header("Location: index.php");
    exit();
}
$friendid = isset($_POST['btn_add']) ? $_POST['btn_add'] : null;

if (isset($friendid))
{

    addfriend($conn, $_SESSION['id'], $friendid);

}
update_noOfFriends($conn, $_SESSION['id']);
echo "
<p1> <strong>" . $_SESSION['name'] . "</strong> Add Friend Page</p1>
<p>Total number of friends is " . $_SESSION['noOfFriends'] . "</p>
";

display_nonfriends($conn, $_SESSION['id']);

echo "<div class= 'centerlinks'>   <a class='a' href='friendlist.php'>My Friends </a> <a class='a' href='logout.php'>Logout </a></div>";


include ("functions/footer.php"); ?>
