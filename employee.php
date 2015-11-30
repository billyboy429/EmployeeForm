<html>
<?php

if(isset($_POST['update']))
{
	update();
}
else
{
	display();
}

function runSQL($sql, $array, $update)
{	
	$result = [];

	try 
	{
		if (is_null($conn))
		{
			$servername = "localhost";
			$username = "root";
			$password = "Red65pot!@#$";
			$dbname = "employees";

		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
		}

		$stmt = $conn->prepare($sql);

		$stmt->execute($array);

		if (!$update)
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		else
			$result = "true";
	}
	catch(PDOException $e)
	{
	    echo "Error: " . $e->getMessage();
	}

	return $result;
}

function update()
{
	echo "<form action='form.html' method='post'>";

	$id = $_POST["Id"];
	$firstName = $_POST["FirstName"];
	$lastName = $_POST["LastName"];
	$title = $_POST["Title"];
	$hireDate = $_POST["HireDate"];

	$sql = "UPDATE employee_info
			SET FirstName = :firstName, LastName = :lastName, Title = :title, HireDate = :hireDate
			WHERE Id = :id";

	$array = array(
	    ':firstName' => $firstName,
	    ':lastName' => $lastName,
	    ':title' => $title,
	    ':hireDate' => $hireDate,
	    ':id' => $id,
	);

	if (!is_null(runSQL($sql, $array, true)))
	{
		echo "Update Successful";
	}
	else
	{
		echo "Update Failed";		
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
	if (empty($_POST["id"]))
		echo "Please enter an employee ID";
	else
	{
		echo "<form action='employee.php' method='post'>";
		echo "<table style='border: solid 1px black;'>";
		echo "<tr>
				<th>Id</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Title</th>
				<th>Hire Date</th>
			  </tr>
			  <tr>
			  	<td>
			  </tr>";


		class TableRows extends RecursiveIteratorIterator
		{
		    function __construct($it)
		    {
		        parent::__construct($it, self::LEAVES_ONLY); 
		    }

		    function current()
		    {
		    	$current = parent::current();
		    	$key = parent::key();

		    	$retValue = "<td style='width:150px;border:1px solid black;'>
			        		   	<input ";

		    	if ($key == 'Id')
		    	{
		    		$retValue .= "readonly ";
		    	}

			    $retValue .= "type='text' name='" . htmlspecialchars($key). "' value='" . htmlspecialchars($current). "'>
			        		</td>";

		    	return $retValue;
		    }

		    function beginChildren()
		    {
		        echo "<tr>"; 
		    } 

		    function endChildren() 
		    { 
		        echo "</tr></table>" . "\n";
				echo "<tr>
					 <td width='100'> </td>
					 <td>
				   		<input name='update' type='submit' id='update' value='Update'>
					 </td>
					 </tr>
				     </form>";
		    } 
		} 

		$sql = "SELECT * FROM employee_info
				WHERE id = :id";

		$array = array(
		    ':id' => $_POST["id"]
		);

	    $result = runSQL($sql, $array, false);
	    foreach(new TableRows(new RecursiveArrayIterator($result)) as $key=>$value) 
	    {
	    	echo $value;
		}

		echo "</table>";
	}	
}
?>