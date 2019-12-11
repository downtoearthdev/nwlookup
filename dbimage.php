<?php
require "com/scorchedcode/companions/companionfactory.php";
require "com/scorchedcode/mounts/mountfactory.php";
require "com/scorchedcode/artifacts/artifactfactory.php";

if(isset($_GET["name"]) && isset($_GET["type"])) {
        header('Content-Type: image/png');
        if(strcasecmp($_GET["type"], "comp") == 0) {
            $type = (new CompanionFactory())->getCompanion($_GET["name"]);
        }
        else if(strcasecmp($_GET["type"], "mount") == 0) {
            $type = (new MountFactory())->getMount($_GET["name"]);
        }
        else if(strcasecmp($_GET["type"], "art") == 0) {
            $type = (new ArtifactFactory())->getArtifact($_GET["name"], "Uncommon");
        }
       $im = imagecreatefromstring(base64_decode(str_replace("data:image/png;base64, ", "", $type->getPicture())));
       imagepng($im);
       imagedestroy($im);
}
else {
    echo "Not found.";
}
?>