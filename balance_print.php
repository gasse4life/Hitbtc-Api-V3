<?php
 include "connect.php"; 
///// 
 
 
 // Attempt select query execution
//$sql = "SELECT * FROM `balance` WHERE available > 0 OR reserved > 0 ORDER BY `currency` ASC";
$hidezero = $_GET['hidezero'];
$reserved = $_GET['reserved'];
if($hidezero=='1'){
$sql = "SELECT * FROM `balance` WHERE available>0 ORDER BY `currency` ASC";
}elseif($reserved=='1'){
  $sql = "SELECT * FROM `balance` WHERE reserved>0 ORDER BY `currency` ASC";
  }else{
    $sql = "SELECT * FROM `balance` WHERE available>0 ORDER BY `currency` ASC";
}
if($result = mysqli_query($connection, $sql)){
    if(mysqli_num_rows($result) > 0){
	 echo "<table>
          <tr>
          <td>";
           
   echo  "</td>
          <td>";
          
   echo  "</td>
          </tr>
        </table>";
        echo "<table border='0'>";
            echo "<tr>";
                echo "<th> Currency </th>";
                echo "<th> Availble </th>";
                echo "<th> Reserved </th>";
                 echo "</tr>";
        while($row = mysqli_fetch_array($result)){
 		 
            echo "<tr>";
                echo "<td>" . $row['currency'] . "</td>";
                echo "<td>" . $row['available'] . "</td>";
                echo "<td>" . $row['reserved'] . "</td>";
             echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
 
 
?>