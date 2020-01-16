<?php
require_once("SPDO.php");

$lstChaines = ["@gamology", "@ohmygoal", "@beautylicious", "@beautyhacks", "@beautywow", "@thisjusthappened",
    "@abcdiyus", "@naturee", "@namemeifyoucan", "@tiboinshape"];

$urlPart1 = "https://www.tiktok.com/node/share/user/";

foreach ($lstChaines as $uneChaine) {
    $chaine = $uneChaine;
    $url = $urlPart1 . $chaine;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST=>0,
        CURLOPT_SSL_VERIFYPEER=>0,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "Postman-Token: e8be3338-ba96-457d-b107-b5f9b52b0eaf",
            "cache-control: no-cache"
        ),
    ));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0',
        'Host: www.tiktok.com'
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        //echo $response;

        $jsonArray = json_decode($response);
        $secUid = $jsonArray->body->userData->secUid;
        $userId = $jsonArray->body->userData->userId;
        $uniqueId = $jsonArray->body->userData->uniqueId;
        $nickName = $jsonArray->body->userData->nickName;
        $following = $jsonArray->body->userData->following;
        $fans = $jsonArray->body->userData->fans;
        $heart = $jsonArray->body->userData->heart;
        $video = $jsonArray->body->userData->video;
        $verified = $jsonArray->body->userData->verified;
        if($verified=="true")
            $verified=1;
        else
            $verified=0;
            
        //if ($sth = $dbh->query('SELECT COUNT(*) FROM channel') == 0) {
            SPDO::getInstance()->query('INSERT INTO `channel`(`secuId`, `userId`, `uniqueId`, `nickname`) VALUES ("' . $secUid . '","' . $userId . '","' . $uniqueId . '","' . $nickName . '")');
            foreach (SPDO::getInstance()->query('SELECT `id` FROM `channel` WHERE `uniqueId`="'.$uniqueId.'"') as $membre)
                {
                $idchannel = $membre['id'];
                }
            //$idchannel = SPDO::getInstance()->query('SELECT `id` FROM `channel` WHERE `uniqueId`="'.$uniqueId.'"');
            var_dump($idchannel);
            //}
        //SELECT `id` FROM `channel` WHERE `uniqueId`="ohmygoal"
        $test =SPDO::getInstance()->query('INSERT INTO `channel_metrics`(`idChannel`,`following`, `fans`, `heart`, `video`, `verified`)
        VALUES ('.$idchannel.','.$following.','.$fans.','.$heart.','.$video.','.$verified.')');

        var_dump($test);
    }
}

