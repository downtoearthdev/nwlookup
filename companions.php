<?php
    require "com/scorchedcode/companions/companionfactory.php";
    $comp = new CompanionFactory();
?>
<?php if(!isset($_GET["name"])): ?>
<html>
<head><title>Mod16 Companion Helper</title>
<script src="index.js"></script>
<style>
    nav {font-size: 20px; }
</style>
</head>
<?php include 'header.html'; ?>
<body style="background:url('img/dragoncomp.jpg') no-repeat; background-size:100%">
<div style="background-color:rgba(255, 255, 0, 0.6); width:100% height:9000px">
<form name="companion" action="companions.php" method="post">
<b>Name: </b><select onChange="disable('name')" id="Names" name="Names">
<option value=""></option>
<?php foreach($comp->listNames() as $name): ?>
<option value=<?= "\"".$name."\">".$name; ?></option>
<?php endforeach; ?></select>
<br><b>Bolster Class: </b><select onChange="disable('not')" name="Bolster" id="Bolster"><option value=""></option>
<option value="Mystical">Mystical</option>
<option value="Beast">Beast</option>
<option value="Creature">Creature</option>
<option value="Invokers">Invokers</option>
<option value="Fighter">Fighter</option></select>
<br><b>Type: </b><select onChange="disable('not')" name="Type" id="Type"><option value=""></option>
<option value="Offensive">Offensive</option>
<option value="Defensive">Defensive</option>
<option value="Utility">Utility</option>
<option value="Offense/Utility">Offense/Utility</option>
<option value="Offense/Defense">Offense/Defense</option>
<option value="Defense/Utility">Defense/Utility</option></select>
<br><b>Enhancement Power:</b><select onChange="disable('not')" name="Enhancement" id="Enhancement"><option value=""></option>
    <option value="Acute Senses">Acute Senses</option>
    <option value="Anticipation">Anticipation</option>
    <option value="Armor Breaker">Armor Breaker</option>
    <option value="Blurred Vision">Blurred Vision</option>
    <option value="Counteract">Counteract</option>
    <option value="Dulled Senses">Dulled Senses</option>
    <option value="Fortification">Fortification</option>
    <option value="Perfect Vision">Perfect Vision</option>
    <option value="Potency">Potency</option>
    <option value="Potent Precision">Potent Precision</option>
    <option value="Precision">Precision</option>
    <option value="Redemption">Redemption</option>
    <option value="Vulnerability">Vulnerability</option>
    <option value="Weapon Break">Weapon Break</option>
</select>
<input type="submit" value="Lookup"><br />
<input type="checkbox" id="powers" onClick="disable()">Search By Player Bonus Power <b><font color="red">(Maximum 2)</font></b><br />
<fieldset style="display:inline">
<input type="checkbox" name="bonus[]" value="Accuracy" disabled>Accuracy
<input type="checkbox" name="bonus[]" value="Armor Penetration" disabled>Armor Penetration
<input type="checkbox" name="bonus[]" value="Awareness" disabled>Awareness
<input type="checkbox" name="bonus[]" value="Buff" disabled>Buff<br />
<input type="checkbox" name="bonus[]" value="Combat Advantage" disabled>Combat Advantage
<input type="checkbox" name="bonus[]" value="Critical Avoidance" disabled>Critical Avoidance
<input type="checkbox" name="bonus[]" value="Critical Resist" disabled>Critical Resist
<input type="checkbox" name="bonus[]" value="Critical Severity" disabled>Critical Severity<br />
<input type="checkbox" name="bonus[]" value="Critical Strike" disabled>Critical Strike
<input type="checkbox" name="bonus[]" value="Damage" disabled>Damage
<input type="checkbox" name="bonus[]" value="Damage Bonus" disabled>Damage Bonus
<input type="checkbox" name="bonus[]" value="Damage Reduced" disabled>Damage Reduced<br />
<input type="checkbox" name="bonus[]" value="Damage Taken" disabled>Damage Taken
<input type="checkbox" name="bonus[]" value="Debuff" disabled>Debuff
<input type="checkbox" name="bonus[]" value="Defense" disabled>Defense
<input type="checkbox" name="bonus[]" value="Deflect" disabled>Deflect<br />
<input type="checkbox" name="bonus[]" value="Deflection" disabled>Deflection
<input type="checkbox" name="bonus[]" value="Hit Points" disabled>Hit Points
<input type="checkbox" name="bonus[]" value="Incoming Healing" disabled>Incoming Healing
<input type="checkbox" name="bonus[]" value="Outgoing Healing" disabled>Outgoing Healing
<input type="checkbox" name="bonus[]" value="Movement" disabled>Movement<br />
<input type="checkbox" name="bonus[]" value="Power" disabled>Power
<input type="checkbox" name="bonus[]" value="Stamina" disabled>Stamina
<input type="checkbox" name="bonus[]" value="XP Bonus" disabled>XP Bonus
</fieldset>
</form>
<?php if($_SERVER["REQUEST_METHOD"] == "POST"): ?>
<?php if(!isset($_POST["Names"]) || $_POST["Names"] == ""): ?>
<ul>
<?php
    $bolster = (isset($_POST["Bolster"]) && $_POST["Bolster"] != "") ? $_POST["Bolster"] : "";
    $type = (isset($_POST["Type"]) && $_POST["Type"] != "") ? $_POST["Type"] : "";
    $bonus = (!empty($_POST["bonus"]) ? $_POST["bonus"] : "");
    $enhancement = (isset($_POST["Enhancement"]) && $_POST["Enhancement"] != "") ? $_POST["Enhancement"] : "";
    $filteredcompanions = $comp->filterCompanions($bolster, $type, $enhancement, $bonus);
?>
<?php foreach($filteredcompanions as $filteredcompanion => $levelcolor): ?>
<li><a href="javascript: submitForm('<?= $comp->javascriptFriendly($filteredcompanion); ?>')"><font color="<?= $comp->color[$levelcolor] ."\">". $filteredcompanion; ?></font></a></li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<?php $lookupcompanion = $comp->getCompanion($_POST["Names"]);?>
<fieldset style="display:inline;">
<legend><h3><i><font color="<?= $comp->color[$lookupcompanion->getLevel()]."\">".$lookupcompanion->getName()." [".$lookupcompanion->getBolster(); ?>]</font></i></h3></legend>
<p align="right"><i><b><?= $lookupcompanion->getType(); ?></b></i></p>
<img style="position:relative; object-fit:contain; height:100px; width:100px;" src="<?=$lookupcompanion->getPicture(); ?>">
<h4><u>Enhancement Power:</u></h4>
    <i><font size="3"><b><?= $lookupcompanion->getPower(); ?></b></font></i>
<h4><u>Equip Power:</u></h4>
<i><font size="3"><b><?= $lookupcompanion->getBonus(); ?></b></font></i>
<h4><u>Summon Powers:</u></h4>
<i><font size="3"><b><?= $lookupcompanion->getSummonPower(); ?></b></font></i>

</fieldset>
<?php endif; ?>
<?php endif; ?>
</div>
</body>
</html>
<?php else: ?>
<?php header('Content-Type: application/json');
$lookupcompanion= $comp->getCompanion($_GET["name"]);
if($lookupcompanion != null)
    echo json_encode(["status" => 200, "message" => $lookupcompanion]);
else
    echo json_encode(["status" => 400, "message" => "Bad Request"]);
exit();
?>
<?php endif; ?>