<?php
declare(strict_types=1); // Strict Typing
echo "<html>";
echo "<head><title>Mod16 Companion Helper</title>";
echo "<script src=\"index.js\"></script>";
echo "</head>"; ?>
<body style="background:url('img/dragon.jpg') no-repeat; background-size:100%">
<div style="background-color:rgba(67, 244, 244, 0.6); width:100% height:9000px">
<?php
// int multiply(int x, int y) {} becomes - function multiply(int $x, int $y) : int {}
$sql = "SELECT Name, \"Bolster Class\", Type FROM Companions";
$conn = connect();
$result = $conn->query($sql); //Actuall send query


if($result->num_rows > 0) {
	//Output data of each row
	$htmlinsert = "\n<form name=\"companion\" action=\"index.php\" method=\"post\">\n<b>Name: </b><select onChange=\"disable('name')\" id=\"Names\" name=\"Names\"><option value=\"\"></option>";
	$namearray = array();
	while($row = $result->fetch_assoc()) {
		array_push($namearray, $row["Name"]);
	}
	sort($namearray);
	foreach($namearray as $name){
		$htmlinsert.="<option value=\"".$name."\">".$name."</option>\n";
	}
	$htmlinsert.="</select>";
	echo $htmlinsert;
	echo "<br><b>Bolster Class: </b><select onChange=\"disable('not')\" name=\"Bolster\" id=\"Bolster\"><option value=\"\"></option><option value=\"Mystical\">Mystical</option>
		<option value=\"Beast\">Beast</option>
		<option value=\"Creature\">Creature</option>
		<option value=\"Invokers\">Invokers</option>
		<option value=\"Fighter\">Fighter</option></select>";
	echo "<br><b>Type: </b><select onChange=\"disable('not')\" name=\"Type\" id=\"Type\"><option value=\"\"></option><option value=\"Offensive\">Offensive</option>
		<option value=\"Defensive\">Defensive</option>
		<option value=\"Utility\">Utility</option>
		<option value=\"Offense/Utility\">Offense/Utility</option>
		<option value=\"Defense/Utility\">Defense/Utility</option></select>";
}
else {
	echo "0 results";
}
$conn->close(); //Close connection
//echo "Connected successfully";
function connect() {
$servername = "localhost";
$username = "neverwinteruser";
$password = "isitgeeseorgooses";
$dbname = "neverwinter";
$names = array();

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if($conn->connect_error) {
	die("Connection failed : " . $conn->connect_error);
}
return $conn;
}
?>
<input type="submit" value="Lookup"><br />
<input type="checkbox" id="powers" onClick="disable()">Search By Player Bonus Power <b><font color="red">(Maximum 2)</font></b><br />
<fieldset style="display:inline">
<input type="checkbox" name="bonus[]" value="Power" disabled>Power
<input type="checkbox" name="bonus[]" value="Critical Avoidance" disabled>Critical Avoidance
<input type="checkbox" name="bonus[]" value="Deflection" disabled>Deflection
<input type="checkbox" name="bonus[]" value="Defense" disabled>Defense<br />
<input type="checkbox" name="bonus[]" value="Combat Advantage" disabled>Combat Advantage
<input type="checkbox" name="bonus[]" value="Damage" disabled>Damage
<input type="checkbox" name="bonus[]" value="Awareness" disabled>Awareness
<input type="checkbox" name="bonus[]" value="Accuracy" disabled>Accuracy<br />
<input type="checkbox" name="bonus[]" value="Debuff" disabled>Debuff
<input type="checkbox" name="bonus[]" value="Stamina" disabled>Stamina
<input type="checkbox" name="bonus[]" value="Armor Penetration" disabled>Armor Penetration
<input type="checkbox" name="bonus[]" value="Critical Resist" disabled>Critical Resist<br />
<input type="checkbox" name="bonus[]" value="Buff" disabled>Buff
<input type="checkbox" name="bonus[]" value="Hit Points" disabled>Hit Points
<input type="checkbox" name="bonus[]" value="Critical Strike" disabled>Critical Strike
<input type="checkbox" name="bonus[]" value="Deflect" disabled>Deflect<br />
<input type="checkbox" name="bonus[]" value="Incoming Healing" disabled>Incoming Healing
<input type="checkbox" name="bonus[]" value="Critical Severity" disabled>Critical Severity
<input type="checkbox" name="bonus[]" value="XP Bonus" disabled>XP Bonus
<input type="checkbox" name="bonus[]" value="Damage Bonus" disabled>Damage Bonus<br />
<input type="checkbox" name="bonus[]" value="Damage Taken" disabled>Damage Taken
<input type="checkbox" name="bonus[]" value="Movement" disabled>Movement
<input type="checkbox" name="bonus[]" value="Damage Reduced" disabled>Damage Reduced
</b></fieldset>
</form>
<?php
	$color = array("25"=>"green", "50"=>"blue", "75"=>"purple", "100"=>"orange");
	if($_SERVER["REQUEST_METHOD"] == "POST") { // If post method used
		if(!isset($_POST["Names"])) {
			$sql = "SELECT Name, `Item Level` FROM Companions WHERE ";
			if(isset($_POST["Bolster"]) && $_POST["Bolster"] != "")
				$sql.="`Bolster Class`=\"".$_POST["Bolster"]."\"";
			if($_POST["Bolster"] != "" && $_POST["Type"] != "")
				$sql.= " AND ";
			if(isset($_POST["Type"]) && $_POST["Type"] != "")
				$sql .="`Type`=\"".$_POST["Type"]."\"";
			if(($_POST["Bolster"] != "" || $_POST["Type"] != "") && !empty($_POST["bonus"]))
				$sql.= " AND ";
			if(!empty($_POST["bonus"])){
				$sql.="`Companion Stats` LIKE ";
				$powers = "";
				foreach($_POST["bonus"] as $bonus) {
					if($powers != "")
						$powers.=" AND `Companion Stats` LIKE ";
					$powers.="\"%".$bonus."%\"";
				}
				$sql.=$powers;
			}
			$conn = connect();
			$result = $conn->query($sql);
			$listcandidates = "<ul>\n";
			$arraycandidates = array();
			if($result->num_rows > 0) { //Always have to check if query has 0 results
				while($row = $result->fetch_assoc()) { //Pulls rows one by one from result
					$arraycandidates[$row["Name"]] = $row["Item Level"];
				}
				ksort($arraycandidates); // Sort by key
				foreach($arraycandidates as $candidate => $colorlevel)
					$listcandidates.="<li><a href=\"javascript: submitForm('".$candidate."')\"><font color=\"".$color[$colorlevel]."\">".$candidate."</font></a></li>\n";
				echo $listcandidates."</ul>";
			}
			$conn->close;
		}
		else {
			$conn = connect();
			$sql = "SELECT * FROM Companions WHERE Name=\"".$_POST["Names"]."\"";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc(); //Only 1 result so don't have to loop through
		;
			$img = ($row["Picture"] == null) ? "img/coming-soon-icon.png" : "data:image/png;base64, ".base64_encode($row["Picture"]);
			echo "<fieldset style=\"display:inline;\">";
			echo "<legend><h3><i><font color=\"".$color[$row["Item level"]]."\">".$_POST["Names"]." [".$row["Bolster Class"]."]</font></i></h3></legend>";
			echo "<p align=\"right\"><i><b>".$row["Type"]."</b></i></p>\n";
			echo "<img style=\"position:relative; object-fit:contain; height:100px; width:100px;\" src=\"".$img."\">";
			echo "<h4><u>Enhancement Power:</u></h4>";
			echo "<i><font size=\"3\"><b>".$row["Enhancement Power"]."</font></b></i>";
			echo "<h4><u>Player Bonus Power:</u></h4>";
			echo "<i><font size=\"3\"><b>".$row["Player Bonus Power"]."</b></font></i>";
			echo "</fieldset>";

			$conn->close();
		}
	}
?>
<br /><b><font color="purple">COMING SOON: <a href="artifacts.php">Artifacts</a></b>
</div>
</body>
</html>