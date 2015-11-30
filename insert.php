<html>
<?php

require_once("SQLUtil.php"); 

if(isset($_POST['submit']))
{
	insert();
}
else
{
	display();
}

function insert()
{
	echo "<form action='form.html' method='post'>";

	$id = $_POST["Id"];
	$firstName = $_POST["FirstName"];
	$lastName = $_POST["LastName"];
	$title = $_POST["Title"];
	$hireDate = $_POST["HireDate"];

	$sql = "INSERT INTO employee_info
			VALUES (:id, :firstName, :lastName, :title, :hireDate)";

	$array = array(
	    ':id' => $id,
	    ':firstName' => $firstName,
	    ':lastName' => $lastName,
	    ':title' => $title,
	    ':hireDate' => $hireDate
	);

	if (!empty(SQLUtil::run($sql, $array, true)))
	{
		echo "\n - Insert Successful";
	}
	else
	{
		echo "\n - Insert Failed";		
	}

	echo "<tr>
		 <td width='100'> </td>
		 <td>
	   		<input name='back' type='submit' id='back' value='Back'>
		 </td>
		 </tr>
	     </form>";
}

function display()
{
	echo "<form action='insert.php' method='post'>";
	echo "<table style='border: solid 1px black;'>";
	echo "<tr>
			<th>Id</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Title</th>
			<th>Hire Date</th>
		  </tr>
		  <tr>
			<td style='width:150px;border:1px solid black;'>
	 		  <input type='text' name='Id'>
			</td>	  
			<td style='width:150px;border:1px solid black;'>
	 		  <input type='text' name='FirstName'>
			</td>	  
			<td style='width:150px;border:1px solid black;'>
	 		  <input type='text' name='LastName'>
			</td>	  
			<td style='width:150px;border:1px solid black;'>
	 		  <input type='text' name='Title'>
			</td>	  
			<td style='width:150px;border:1px solid black;'>
	 		  <input type='text' name='HireDate'>
			</td>	  
		  </tr>
		  </table>
		  <tr>
			<td width='100'>
			  <td>
				<input name='submit' type='submit' id='submit' value='Submit'>
			  </td>
			</td>
		  </tr>
		  </form>";
}
?>