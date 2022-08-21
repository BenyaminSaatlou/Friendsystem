
<?php
include "functions/header.php";

echo "
<h1> My Friend System Assignment About Page</h1>
         <div class='about'>
   <h2>About This Assignment</h2>

   <p3>*All html code has been validated*</p3>
   <p><strong>What tasks you have not attempted or not completed?</strong></p>
   <ul>
      <li> All of the tasks have been compeleted and tested</li>
   </ul>
   <br>
   <p><strong>What special features have you done, or attempted, in creating the site that we should
      know about?</strong>
   </p>
   <ul>
   <li>The footer and header are sperated in files you can just include them </li>
      <li>User information does not disappear if they refresh or get an error</li>
      <li>The user is not directed to another page if there is any error, so they don't need to click the back button</li>
      <li>All the error are clearly and neatly shown </li>
   </ul>
   <br>
   <p><strong>Which parts did you have trouble with?</strong>
   </p>
   <ul>
   <li>Displaying mutual friends was a bit dificualt</li>
</ul>
   <br>
   <p><strong> What would you like to do better next time?</strong>
   </p>
   <ul>
      <li>I think i did a pretty good job I am happy with what I have already, so would not change much</li>
   </ul>
   <br>
  
   <a class='button' href='friendlist.php'>Show Friend List</a>
   <a class='button' href='friendadd.php'>Add Friends</a>
   <a class='button' href='index.php'> Home</a>
</div>
<br><br><img src='img/Ss.png' alt='Guestion answer' width='800' height='300'>
         ";
echo "<br> <a class='button' href='index.php'>Return Home</a>";
include "functions/footer.php";
?>
