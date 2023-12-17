# PHP class lettersDecode

### Version: 1.0, 2023-12-17

Author: Vladimir Kheifets <vladimir.kheifets.@online.de>

Copyright &copy; 2023 Vladimir Kheifets All Rights Reserved

The class provides a solution to one task of the GCHQ 2023 Christmas competition.

(GCHQ - UK's intelligence, security and cyber agency)

[https://www.gchq.gov.uk/files/2023%20GCHQ%20Christmas%20Challenge.pdf](https://www.gchq.gov.uk/files/2023%20GCHQ%20Christmas%20Challenge.pdf)

```
    Each letter represents a different digit:
    MI * MI = MAA
    TI + TI = RA
    DO - SO + TI - MI = RE
    RE * RE = ?

```
Demo
[https://www.alto-booking.com/developer/columnOperations/](https://www.alto-booking.com/developer/lettersDecode/)

### 1. Properties of the class lettersDecode

lettersCode - (array) сodes of Letter

endResNum - (integer) result RE * RE

endResLetter - (string) encoded result RE * RE

### 2 Quellcodes in PHP

### 2.1 File index.php
```php
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
```

#### 2.2 File  lettersDecode.php

```php
<?
//-------------------------------------------------
/*
    PHP class lettersDecode
    Version: 1.0, 2023-12-17
    Author: Vladimir Kheifets (vladimir.kheifets.@online.de)
    Copyright (c) 2023 Vladimir Kheifets All Rights Reserved
    Demo:
    https://www.alto-booking.com/developer/lettersDecode
*/

class lettersDecode {

    public $lettersCode;
    public $endResNum;
    public $endResLetter;
    private $digits;

    function __construct() {
        $this->digits = range(0, 9);
        $this->lettersCode = $this -> lettersDecodeStep1();
        $this -> lettersDecodeStep2();
        $this -> lettersDecodeStep3();
        extract($this -> lettersCode);
        $RE = intval($R.$E);
        $this -> endResNum = $RE * $RE;
        $this -> endResLetter = "";
        $flippedLettersCode = array_flip($this -> lettersCode);
        foreach(str_split($this -> endResNum) as $digit)
            $this -> endResLetter .= $flippedLettersCode[$digit];
    }

    private function lettersDecodeStep1(){
        //Step1: MI * MI = MAA
        foreach($this->digits as $digit)
        {
            foreach($this -> getNextDigits($digit)  as $digit2)
            {
                $MI = intval($digit.$digit2);
                $MAA = $MI * $MI;
                if($MAA > 100)
                {
                    $digitsMAA = str_split($MAA);
                    if($digitsMAA[0] == $digit AND $digitsMAA[1] == $digitsMAA[2])
                    {
                        return
                        [
                            "M" => $digitsMAA[0],
                            "I" => $digit2,
                            "A" => $digitsMAA[1]
                        ];
                    }
                }
            }
        }
    }
    //-------------------------------------------------
    private function lettersDecodeStep2(){
            //Step2: TI * TI = RA
            $lettersCode = $this -> lettersCode;
            extract($lettersCode);
            foreach($this->digits as $digit)
            {
                $TI = intval($digit.$I);
                $RA = $TI + $TI;
                if($RA >10 AND $RA<100 AND $digit>$I)
                {
                    $digitsRA = str_split($RA);
                    $this -> lettersCode["T"] = $digit;
                    $this -> lettersCode["R"] = $digitsRA[0];
                    return;
                }
            }
        }
    //-------------------------------------------------
    private function lettersDecodeStep3(){
            //Step3: DO - SO + TI - MI = RE
            $lettersCode = $this -> lettersCode;
            extract($lettersCode);
            $Ti = intval($T.$I);
            $Mi = intval($M.$I);
            $diffTiMi = $Ti - $Mi;
            $diffTiMiDigits = str_split($diffTiMi);
            $codes = array_values($lettersCode);

            $digits = array_diff($this -> digits, $codes);
            foreach($digits as $digit)
            {
                foreach($this -> getNextDigits($digit) as $digit2)
                {
                    if($digit > $digit2)
                    {
                        if($digit - $digit2 + $diffTiMiDigits[0] == $R)
                        {
                            $this -> lettersCode["D"] = $D = $digit;
                            $this -> lettersCode["S"] = $S = $digit2;
                            break;
                        }
                    }
                }
            }
            $lettersCode = $this -> lettersCode;
            $codes = array_values($lettersCode);
            $digits = array_diff($this -> digits, $codes);
            foreach($digits as $digit)
            {
                $RE = intval($D.$digit)-intval($S.$digit) + $diffTiMi;
                $DigitsRE = str_split($RE);
                if($digit != $DigitsRE[1])
                {
                    $this -> lettersCode["E"] = $DigitsRE[1];
                    $this -> lettersCode["O"] = $digit;
                    return;
                }
            }
        }

        private function getNextDigits($usetVal){
            return array_diff( $this -> digits, (array)$usetVal);
        }
}
?>
```