
<?php

printArray($_POST);
$db=new Database();
$subject="test";
$sql= "INSERT INTO contacto (name,email,message) values (:name,:email,:message)";
$params = [
    ":name" => $_POST["name"],
    ":email" => $_POST["email"],
    ":message" => $_POST["message"],
];
$result = $db->querySQL($sql,$params);
if($result["success"]==true){
    mail($_POST["email"],$subject,$_POST["message"]);
    echo 'GRACIAS';
}else{
    echo"ERROR";
}

?>



