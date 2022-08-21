<?php
include ("functions/header.php");
echo"<h1> My Friend System Assignment Friend List Page</h1>";
include ("functions/setting.php");
include ("functions/functions.php");

$friendid = isset($_POST['btn']) ? $_POST['btn'] : null;

if (isset($friendid))
{

    removefriend($conn, $_SESSION['id'], $friendid);

}

if (!isset($_SESSION['login']))
{
    header("Location: index.php");
    exit();
}

update_noOfFriends($conn, $_SESSION['id']);
echo "
<p1> <strong>" . $_SESSION['name'] . "</strong> Friend List Page</p1>
<p>Total number of friends is " . $_SESSION['noOfFriends'] . "</p>
";

if ($_SESSION['noOfFriends'] == 0)
{

    echo "<p>You have no friends, You can add more friends by clicking the page add friends :)</p>";
}

display_friends($conn, $_SESSION['id']);

echo " <div class= 'centerlinks'> <a class='a' href='friendadd.php'>Add Friends </a>
 <a class='a' href='logout.php'>Logout </a></div>";


include ("functions/footer.php"); ?>
