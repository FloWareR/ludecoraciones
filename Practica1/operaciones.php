<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>HOLA</h1>
    <div class="divp">
    <ul>



    </ul>    
    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

    <a href="/Practica1/archivo2.html">Sexoservicio</a>
</div>
<?php

    $array = array(
    "SIIII",
    "NOOOOO",
    "TAAAALVEZZZ"
    );
    echo $_GET["op"];
    $a = $_GET["a"];
    $b = $_GET["b"];
    $c;

    function suma(int $a, int $b) : string {
        $c = $a+$b;
        return "<p>El resultado de la suma de $a y $b es $c</p>";
    }
    function resta(int $a, int $b) : string {
        $c = $a-$b;
        return "<p>El resultado de la resta de $a y $b es $c</p>";
    }
    function multi(int $a, int $b) : string {
        $c = $a*$b;
        return "<p>El resultado de la multiplicacion de $a y $b es $c</p>";
    }
    function div(int $a, int $b) : string {
            if ($b>=0) {

                return "NOOO";
                
            }
            else {
                $c = $a/$b;
                return"<p>El resultado de X entre $a y $b es $c</p>";
            }
            
    }
    

    switch ($_GET["op"]) {
        case 'sum':
            echo suma($a, $b);
            break;
        case 'res':
            echo resta($a, $b);
            break;
        case 'multi':
            echo multi($a, $b);
            break;
        case "div":
            echo div($a, $b);

            break;
        
        default:

            break;
    }
    foreach($array as $key =>$value){
        echo'<li>'.$value.'</li>';
    }
?>

</body>
</html>