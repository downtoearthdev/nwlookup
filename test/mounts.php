<?php
    require "com/scorchedcode/mounts/mountfactory.php";
    $mounts = new MountFactory();
?>
<!-- if(!(isset($_GET["name"]) || isset($_GET["level"]))): ?>-->
<html>
<head><title>Mod16 Mount Helper</title>
</head>
<?php include 'header.html'; ?>
<form name="mount" action="mounts.php" method="post">
<b>Name:</b><select name="Names" id="Names">
<?php foreach($mounts->listNames() as $name): ?>
<option value=<?= "\"".$name."\">".$name; ?></option>
<?php endforeach; ?>
</select>
<input type="submit" value="Lookup"><br />
</form>
<?php if($_SERVER["REQUEST_METHOD"] == "POST"): ?>
<?php $themount = $mounts->getMount($_POST["Names"]); ?>
<fieldset style="display:inline; background-color:<?= $mounts->colors[$themount->getSpeed()] ?>;">
<legend><h4><i><?= $themount->getName(); ?></i></h4></legend>

<img style="position:relative; object-fit:contain; height:100px; width:100px;" src=<?= "\"".$themount->getPicture(). "\">"; ?>
<?php if($themount->getSpeed() == "110" || $themount->getSpeed() == "140"): ?>
<h5><u>Equip Power:</u></h5>
<i><font size="3"><b><?= $themount->getEquip(); ?></b></font></i>
<?php endif; ?>
<?php if($themount->getSpeed() == "140"): ?>
<h5><u>Combat Power</u></h5>
<i><font size="3"><b><?= $themount->getCombat(); ?></b></i>
<?php endif; ?>
</fieldset>
<?php endif; ?>
<!-- script src="artifacts.js"></script> -->
</body>
</html>