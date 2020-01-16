<?php

//$lstChaines = ["@gamology", "@ohmygoal", "@beautylicious", "@beautyhacks", "@beautywow", "@thisjusthappened",
  //  "@abcdiyus", "@naturee", "@namemeifyoucan", "@boysdoitto"];

$urlPart1 = "https://www.tiktok.com/node/share/user/";
$chaine = "@gamology";
$url = $urlPart1 . $chaine;
$json = file_get_contents($url);
$jsonArray = json_decode($json);

echo $jsonArray;

?>