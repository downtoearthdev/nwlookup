<?php
    require "com/scorchedcode/mounts/mountfactory.php";
    $mounts = new MountFactory();
?>
<?php if(!(isset($_GET["name"]) || isset($_GET["bonus"]))): ?>
<html>
<head><title>Mod16 Mount Helper</title>
<link href="mounts.css" rel="stylesheet">
<script src="jquery-3.3.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="tooltipster/dist/css/tooltipster.bundle.min.css" />
<script type="text/javascript" src="tooltipster/dist/js/tooltipster.bundle.min.js"></script>
<script src=mounts.js type="text/javascript"></script>
</head>
<?php include 'header.html'; ?>
<body style="background:url('img/firehorse.jpg') no-repeat; background-size:100%">
<form name="mount" action="mounts.php" method="post">
<b>Name:</b><select name="Names" id="Names">
<option value=""></option>
<?php foreach($mounts->listNames() as $name): ?>
<option value=<?= "\"".$name."\">".$name; ?></option>
<?php endforeach; ?>
</select><br />
<b>Insignia:</b><select name="Insignias" id="Insignias">
<option value=""></option>
<?php foreach((new InsigniaFactory())->listNames() as $name): ?>
<option value=<?= "\"".$name."\">".$name; ?></option>
<?php endforeach; ?>
</select><br />
<b>Stat Type:</b><select name="Types" id="Types">
<option value=""></option>
<option value="Buff">Buff</option>
<option value="Debuff">Debuff</option>
<option value="Damage">Damage</option>
<option value="Stat">Stat</option>
</select>
<input type="submit" value="Lookup"><br />
</form>
<?php if($_SERVER["REQUEST_METHOD"] == "POST"): ?>
<?php if(!isset($_POST["Names"]) || $_POST["Names"] == ""): ?>
<?php if(isset($_POST["Insignias"])): ?>
<?php foreach($mounts->getMountsFromFilter($_POST["Insignias"], null) as $bonus): ?>
<b><span class="mountpreview" title="Loading..." style="color:<?= $mounts->textsafecolors[($mounts->getMount(str_replace("\n", "", $bonus)))->getSpeed()] ?> !important;"><?= $bonus ?></span></b><br />
<?php endforeach; ?>
<?php else: ?>
<?php foreach($mounts->getMountsFromFilter(null, $_POST["Types"]) as $type): ?>
<b><span class="mountpreview" title="Loading..." style="color:<?= $mounts->textsafecolors[($mounts->getMount(str_replace("\n", "", $type)))->getSpeed()] ?> !important;"><?= $type ?></span></b><br />
<?php endforeach; ?>
<?php endif; ?>
<?php else: ?>
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
<?php if($themount->getInsignia() != ""): ?>
<h5><u>Insignias</u></h5>
<i><font size="3"><b><?= str_replace("\r\n", "<br />", $themount->getInsignia()); ?></b></i>
<h5><u><font color="red" size="20px">POSSIBLE</font> Insignia Bonuses</u></h5>
<?php foreach(explode("\n", $themount->getPossibleBonuses()) as $bonusline): ?>
<i><font size="3"><b><span title="Loading..." class="insigdesc"><?= $bonusline; ?></span></font></b></i><br />
<?php endforeach; ?>
<?php endif; ?>
</fieldset>
<?php endif; ?>
<?php endif; ?>
<!-- script src="artifacts.js"></script> -->
</body>
</html>
<?php else: ?>
<?php header('Content-Type: application/json');
    if(isset($_GET["name"])) {
        $lookupmount= $mounts->getMount($_GET["name"]);
        if($lookupmount != null)
            echo json_encode(["status" => 200, "message" => $lookupmount]);
        else
            echo json_encode(["status" => 400, "message" => "Bad Request"]);
    }
    elseif(isset($_GET["bonus"]))
        echo json_encode(["status" => 200, "message" => (new InsigniaFactory())->getBonus($_GET["bonus"])]);
else
    echo json_encode(["status" => 400, "message" => "Bad Request"]);
exit();
?>
<?php endif; ?>