<?
include_once("lettersDecodeClass.php");

$obj = new lettersDecode;
$lettersCode = $obj->lettersCode;
$endResNum =  $obj -> endResNum;
$endResLetter = $obj -> endResLetter;

echo "<pre>";
echo <<<HTML
One task from 2023 GCHQ Christmas Challenge
<a href="https://www.gchq.gov.uk/files/2023%20GCHQ%20Christmas%20Challenge.pdf">2023 GCHQ Christmas Challenge</a>
(GCHQ - UK's intelligence, security and cyber agency)
<b>
Each letter represents a different digit:
MI * MI = MAA
TI + TI = RA
DO - SO + TI - MI = RE
RE * RE = ?
<hr>
Result from PHP class lettersDecode

</b>
HTML;
echo "\$lettersCode ";
print_r($lettersCode);
echo "<br>RE * RE = $endResNum =>  $endResLetter";
/*
Result:
$lettersCode Array
(
    [M] => 1
    [I] => 2
    [A] => 4
    [T] => 3
    [R] => 6
    [D] => 9
    [S] => 5
    [E] => 0
    [O] => 7
)

endResNum RE * RE = 3600 =>  endResLetter = TREE
*/
?>