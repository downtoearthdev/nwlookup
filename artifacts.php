<?php
    require "com/scorchedcode/artifacts/artifactfactory.php";
    $art = new ArtifactFactory();
?>
<?php if(!(isset($_GET["name"]) || isset($_GET["level"]))): ?>
<html>
<head><title>Mod16 Artifact Helper</title>
<link href="artifacts.css" rel="stylesheet">
</head>
<?php include 'header.html'; ?>
<body background="img/stargate.png" style="background-size: 100%">
<form name="artifact" action="artifacts.php" method="post">
<b>Name:</b><select name="Names" id="Names">
<?php foreach($art->listNames() as $name): ?>
<option value=<?= "\"".$name."\">".$name; ?></option>
<?php endforeach; ?>
</select>
<b>Rank:</b><select name="Levels" id="Levels">
<option value=""></option>
<?php foreach($art->levels as $level): ?>
<option value=<?= "\"".$level."\">".$level; ?></option>
<?php endforeach; ?>
</select>
<input type="submit" value="Lookup"><br />
<input type="checkbox" id="stats">Search By Stats <b><font color="red">(Maximum 3)</font></b><br />
<fieldset style="display:inline;">
<input type="checkbox" name="stat[]" value="Accuracy" disabled>Accuracy
<input type="checkbox" name="stat[]" value="Defense" disabled>Defense
<input type="checkbox" name="stat[]" value="Awareness" disabled>Awareness
<input type="checkbox" name="stat[]" value="Critical Strike" disabled>Critical Strike<br />
<input type="checkbox" name="stat[]" value="Armor Penetration" disabled>Armor Penetration
<input type="checkbox" name="stat[]" value="Combat Advantage" disabled>Combat Advantage
<input type="checkbox" name="stat[]" value="Critical Resist" disabled>Critical Resist
<input type="checkbox" name="stat[]" value="Deflection" disabled>Deflection<br />
<input type="checkbox" name="stat[]" value="Gold Gain" disabled>Gold Gain
<input type="checkbox" name="stat[]" value="Power" disabled>Power
<input type="checkbox" name="stat[]" value="Control Resistance" disabled>Control Resistance
<input type="checkbox" name="stat[]" value="Maximum Hit Points" disabled>Maximum Hit Points<br />
<input type="checkbox" name="stat[]" value="Stamina Regeneration" disabled>Stamina Regeneration
<input type="checkbox" name="stat[]" value="Companion Influence" disabled>Companion Influence
<input type="checkbox" name="stat[]" value="Control Strength" disabled>Control Strength
<input type="checkbox" name="stat[]" value="Stamina Generation" disabled>Stamina Generation<br />
<input type="checkbox" name="stat[]" value="Combat Advantage" disabled>Combat Advantage
</fieldset>
</form>
<?php if($_SERVER["REQUEST_METHOD"] == "POST"): ?>
<?php if((!isset($_POST["Names"]) || $_POST["Names"] == "") || (!isset($_POST["Levels"]) || $_POST["Levels"] == "")): ?>
<ul>
<?php
    $stat = (!empty($_POST["stat"]) ? $_POST["stat"] : "");
    $filteredartifacts = $art->filterArtifacts($stat);
?>
<?php foreach($filteredartifacts as $filteredartifact => $levelspresent): ?>
<?php
    $explodedlevels = explode(",", $levelspresent);
    $newlevelspresent = "";
    foreach($explodedlevels as $levelmod)
        $newlevelspresent.= "<a href=\"javascript: submitForm('".$art->javascriptFriendly($filteredartifact)."', '".$levelmod."');\"><font color=\"".$art->textsafecolors[$levelmod]."\">".$levelmod."</font></a> ";

?>
<li><?= $filteredartifact. " [".$newlevelspresent."]"; ?></li> 
<?php endforeach; ?>
<?php else: ?>
<?php $theartifact = $art->getArtifact($_POST["Names"], $_POST["Levels"]); ?>
<fieldset style="display:inline; background-color:<?= $art->colors[$theartifact->getLevel()] ?>;">
<legend><h4><i><?= $theartifact->getName(); ?></i></h4></legend>
<div class="setbonus"><i><b>
<?php foreach(explode("\n", $theartifact->getSet()) as $setline): ?>
<?= $setline; ?><br />
<?php endforeach; ?>
<?= $theartifact->getBonuses(); ?></b></i><br /></div>
<img style="position:relative; object-fit:contain; height:100px; width:100px;" src=<?= "\"".$theartifact->getPicture(). "\">"; ?>
<h5><u>Use Power:</u></h5>
<i><font size="3"><b><?= $theartifact->getUses(); ?></b></font></i>
<h5><u>Stats:</u></h5>
<i><font size="3"><b><?= $theartifact->getStat(); ?></b></i>
</fieldset>
<?php endif; ?>
<?php endif; ?>
<script src="artifacts.js"></script>    
</body>
</html>
<?php else: ?>
<?php header('Content-Type: application/json');
$lookupartifact = $art->getArtifact($_GET["name"], $_GET["level"]);
if($lookupartifact != null)
    echo json_encode(["status" => 200, "message" => $lookupartifact]);
else
    echo json_encode(["status" => 400, "message" => "Bad Request"]);
exit();
?>
<?php endif; ?>