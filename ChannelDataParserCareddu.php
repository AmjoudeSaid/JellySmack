<?php
//require_once('SPDO.php');

$dbh = new PDO('mysql:host=192.168.43.29;dbname=hackaton_jelly', "userJelly", "mdpJelly");
// utiliser la connexion ici
$sth = $dbh->query('SELECT * FROM foo');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.tiktok.com/node/share/user/@ohmygoal",
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
    /*$fan = $jsonArray->body->userData->fans;
    $following = $jsonArray->body->userData->following;
    $heart = $jsonArray->body->userData->heart;
    $video = $jsonArray->body->userData->video;*/

    $secUid = 597;
    $userId = $jsonArray->body->userData->userId;
    $uniqueId = $jsonArray->body->userData->uniqueId;
    $nickName = $jsonArray->body->userData->nickName;

    $sth = $dbh->query('INSERT INTO `channel`(`secuId`, `userId`, `uniqueId`, `nickname`) VALUES ('.$secUid.','.$userId.',"'.$uniqueId.'","'.$nickName.'")');

    /*$this->_sql = "INSERT INTO channel (secuId, userId,uniqueId,nickname) VALUES (:secuId, :userId, :uniqueId, :nickname)";
            $this->_statement = $this->_db->prepare($this->_sql);
            $this->_statement->bindParam(':secuId', $secUid);
            $this->_statement->bindParam(':userId', $userId);
            $this->_statement->bindParam(':uniqueId', $uniqueId);
            $this->_statement->bindParam(':nickname', $nickName);
            $this->_statement->execute();*/

    //echo "fan : ".$fan."\r\n". "following : ".$following."\n";
}
?>