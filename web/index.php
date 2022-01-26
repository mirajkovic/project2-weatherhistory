<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}

table {
  width: 70%;
  border: 1px solid black;
  border-collapse: collapse;
  overflow: auto;
  margin-top:  20px;
  
}

th {
  height: 40px;
  background-color: #CAAEA8;
  color: black;
}
tr:nth-child(even) {background-color: #D8CFCF;}

.header {
  background-color: #B88A8A;
  text-align: center;
  padding: 5px;
  border: 1px solid black;
}

body {
  background-color: #F6F3F3;
  
}

</style>
</head>
<body>

<div class="header">
<center><h1>Weather history</h1></center>
</div>

<?php

$hostname = "mariadb";
$username = "root";
$password = "root";
$db = "testdb";

$dbconnect=mysqli_connect($hostname,$username,$password,$db);

if ($dbconnect->connect_error) {
  die("Database connection failed: " . $dbconnect->connect_error);
}

?>

<?php
$cityErr = "";
$city = "";
$sql = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["city"])) {
    $cityErr = "City is required";
  } else {
    $city = test_input($_POST["city"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<center>
<p>Welcome to the weather history website, you can see the weather conditions of several cities.</p>
<p>If you want to see the results for a particular city, please select your desired city and click the "Submit" button </p>
<p>You will see the weather information for your selected City, have fun!</p>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

   Cities:
  <input type="radio" name="city" <?php if (isset($city) && $city=="Frankfurt") echo "checked";?> value="Frankfurt">Frankfurt
  <input type="radio" name="city" <?php if (isset($city) && $city=="Tokio") echo "checked";?> value="Tokio">Tokio
  <input type="radio" name="city" <?php if (isset($city) && $city=="Duesseldorf") echo "checked";?> value="Duesseldorf">Duesseldorf
  <input type="radio" name="city" <?php if (isset($city) && $city=="Buenos Aires") echo "checked";?> value="Buenos Aires">Buenos Aires
  <input type="radio" name="city" <?php if (isset($city) && $city=="Longyearbyen") echo "checked";?> value="Longyearbyen">Longyearbyen
  <span class="error">* <?php echo $cityErr;?></span>
  
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>
</center>


<?php
 echo "<h2>Your selection is:</h2>";
 echo $city;
?>

<table border="1" align="center">
<tr>
  <th><b>City</b></th>
  <th><b>Wind Speed in MPH</b></th>
  <th><b>Temperature in °C</b></th>
  <th><b>Pressure in inches Hg</b></th>
  <th><b>Time</b></th>
</tr>


<?php
if($city == 'Tokio'){
  $sql = "SELECT * FROM WeatherData WHERE City='Tokio'";
}elseif($city == 'Frankfurt'){
  $sql = "SELECT * FROM WeatherData WHERE City='Frankfurt'";
}elseif($city == 'Duesseldorf'){
  $sql = "SELECT * FROM WeatherData WHERE City='Duesseldorf'";
}elseif($city == 'Longyearbyen'){
  $sql = "SELECT * FROM WeatherData WHERE City='Longyearbyen'";
}elseif($city == 'Buenos Aires'){
  $sql = "SELECT * FROM WeatherData WHERE City='Buenos Aires'";
}else{
  $sql = "SELECT * FROM WeatherData";
}
?>

<?php
$query = mysqli_query($dbconnect, $sql)
   or die (mysqli_error($dbconnect));

while ($row = mysqli_fetch_array($query)) {
  echo
   "<tr>
    <td>{$row['City']}</td>
    <td>{$row['Wind']}</td>
    <td>{$row['Temperature']}</td>
    <td>{$row['Pressure']}</td>
    <td>{$row['MeasureTime']}</td>
   </tr>\n";
}
?>

</table>
</body>
</html>
