<?php
include ("header.php");
$error = array();
if (session_status() == PHP_SESSION_NONE) session_start();

//function for creating table if it does not exist already
function create_table($conn)
{
    if (!$conn)
    {
        echo "Could not connect to sql";
    }
    else
    {
        //Creating the two tables friends and myfriends
        $query = "CREATE TABLE IF NOT EXISTS friends (
        friend_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        friend_email varchar(50) NOT NULL,
        password varchar(20) NOT NULL,
        profile_name varchar(30) NOT NULL,
        date_started date NOT NULL,
        num_of_friends int(10) UNSIGNED NOT NULL
        );";
        mysqli_query($conn, $query);

        $query = "CREATE TABLE IF NOT EXISTS myfriends (
        friend_id1 int(10) UNSIGNED NOT NULL, 
        friend_id2 int(10) UNSIGNED NOT NULL,
        FOREIGN KEY (friend_id1) REFERENCES friends(friend_id),
        FOREIGN KEY (friend_id2) REFERENCES friends(friend_id)
        );";
        mysqli_query($conn, $query);
    }
}



// this goes through emails on sql if emails match then it will return true if not it will return false
function checkifitexist($conn, $userEmail)
{

    $query = "SELECT friend_email FROM friends";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result))
    {
        if ($row["friend_email"] == $userEmail)
        {
            return true;
        }
    }
    return false;
}
// get the number of friend from the database and updates the front end
function update_noOfFriends($conn, $id)
{
    $query = "UPDATE friends SET num_of_friends = (
        SELECT COUNT(*) FROM myfriends WHERE friend_id1 = $id
    ) WHERE friend_id = $id";

    $result = (mysqli_query($conn, $query));

    $query2 = "SELECT num_of_friends  FROM friends  WHERE friend_id = $id";
    $result2 = (mysqli_query($conn, $query2));

    while ($row2 = mysqli_fetch_assoc($result2))
    {

        $_SESSION['noOfFriends'] = $row2['num_of_friends'];
    }

}



// this functions displays the friends of the logged in user
function display_friends($conn, $id)
{
    //sets up the limites for the page
    $record_per_page = 5;
    $page = '';
    if (isset($_GET["page"]))
    {
        $page = $_GET["page"];
    }
    else
    {
        $page = 1;
    }
    $start_from = ($page - 1) * $record_per_page;
    // slectects all friends of the logged in user and displays with the limit of 5 item per page
    $query = "SELECT * FROM friends WHERE friend_id IN(
    SELECT friend_id2 FROM myfriends WHERE friend_id1 = $id ) LIMIT $start_from, $record_per_page";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result))
    {

        echo '
		<form action="friendlist.php" method="post">
     <table id="friendtable">
                <tr> 
                         <td>' . $row['profile_name'] . '</td> 
                          <td> <button class= "button" name="btn" value =' . $row['friend_id'] . '>Remove Friend</button></td> 	 			  
                        
                          
                      </tr></table> </form> ';

    }

    $page_query = "SELECT * FROM friends WHERE friend_id  IN(
                SELECT friend_id2 FROM myfriends WHERE friend_id1 = $id) ";
    $page_result = mysqli_query($conn, $page_query);
    $total_records = mysqli_num_rows($page_result);
    $total_pages = ceil($total_records / $record_per_page);

    echo" <div id='pagenum'>";
    for ($i = 1;$i <= $total_pages;$i++)
    {
        print "<a  href='friendlist.php?page=" . $i . "'>" . $i . "</a>   ";
    }
    
    echo '<br> </div>';
}



// removes the person from  database according to the button
function removefriend($conn, $userid, $friendid)
{

    $query = " DELETE FROM `myfriends` WHERE friend_id1 = $userid AND friend_id2= $friendid";

    $result = mysqli_query($conn, $query);

}
// adds the person to database according to the button
function addfriend($conn, $userid, $friendid)
{

    $query = " INSERT INTO `myfriends`(`friend_id1`, `friend_id2`) VALUES ('$userid','$friendid')";

    $result = mysqli_query($conn, $query);

}



// this functions displays the people that are not your friend and you could add
function display_nonfriends($conn, $id)
{
    $record_per_page = 5;
    $page = '';
    if (isset($_GET["page"]))
    {
        $page = $_GET["page"];
    }
    else
    {
        $page = 1;
    }
    $start_from = ($page - 1) * $record_per_page;
    // this one is the oposite it shows everybody else who is not friend with the current user with the limit of 5 per page
    $query = "SELECT * FROM friends WHERE friend_id NOT IN(
           SELECT friend_id2 FROM myfriends WHERE friend_id1 = $id)  AND friend_id !=$id LIMIT $start_from, $record_per_page";

    $result = mysqli_query($conn, $query);

    if ($result->num_rows == 0)
    {

        echo "There is no one to add sorry :(<br>";
    }

    while ($row = mysqli_fetch_assoc($result))
    {

        echo '
               <form action="friendadd.php" method="post">
            <table id="friendtable" >

                       <tr> 
                                <td>' . $row['profile_name'] . '</td> 
                             
                             ';
        $id2 = $row['friend_id'];

        $query2 = "SELECT COUNT(*) as Mutual_Friends
    FROM myfriends M
    WHERE friend_id1=$id AND
          EXISTS (SELECT $id
                  FROM myfriends X
                  WHERE X.friend_id1= $id2  AND
                        X.Friend_id2=M.Friend_id2)";

        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_assoc($result2);

        echo '   <td>' . $row2['Mutual_Friends'] . ' mutual friends</td> 
    <td> <button class= "button" name="btn_add" value =' . $row['friend_id'] . '>Add Friends</button></td> 	 			  
  
    </tr></table> </form>';
    }


//page numbers and selcetion
    $page_query = "SELECT * FROM friends WHERE friend_id NOT IN(
                 SELECT friend_id2 FROM myfriends WHERE friend_id1 = $id) ";
    $page_result = mysqli_query($conn, $page_query);
    $total_records = mysqli_num_rows($page_result);
    $total_pages = ceil($total_records / $record_per_page);

echo" <div id='pagenum'>";
    for ($i = 1;$i <= $total_pages;$i++)
    {
        print "<a  href='friendadd.php?page=" . $i . "'>" . $i . "</a>   ";
    }
    
    echo '<br> </div>';

}

