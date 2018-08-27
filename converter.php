<!doctype html>
<html>
<head>
<meta charset="utf-8" />
</head>
<style>
input.inputNum {
	text-transform: uppercase;
}
</style>
<body>
    <p>Convert arabic to roman or roman to arabic numbers, from 1 to 3999</p>
    <form action="converter.php" method="get">
        <input class="inputNum" type="text" name="someNumber" value=""/>
        <input type="submit" name="sendValue" value="Convert"/>
    </form>
</body>
</html>
<?php
    $romanNums = array('I','IV','V','IX','X','XL','L','XC','C','CD','D','CM','M');
    $arabicNums = array(1,4,5,9,10,40,50,90,100,400,500,900,1000);
    if(isset($_GET['sendValue'])&&$_GET['someNumber']!=""){
        //If arabic numberis correct(from 0 to 4000)
        if(is_numeric($_GET['someNumber']) && $_GET['someNumber']>0 && $_GET['someNumber']<4000 && ctype_digit($_GET['someNumber'])){
            $finalRomanNum = arabicToRoman($_GET['someNumber']); //Call function and send value
            echo $finalRomanNum;
        }elseif(is_numeric($_GET['someNumber']) && ($_GET['someNumber']<=0 || $_GET['someNumber']>3999)){ //Less than 1 or more than 3999
            echo "Number must be between 0 and 4000 ";
        }elseif(is_numeric($_GET['someNumber']) && $_GET['someNumber']>0 && !ctype_digit($_GET['someNumber'])){ //Not integer
            echo "Number must be integer";
        }else{ //If digits and letters
            $finalArabicNum = romanToArabic(strtoupper($_GET['someNumber'])); //Function will convert letter to digits
            $checkFinalArabicNum = arabicToRoman($finalArabicNum); //After function converted roman number to arabic on the next step another function will convert this arabic number back to roman
            if($checkFinalArabicNum==strtoupper($_GET['someNumber'])){ //If roman number from function equal roman number from input, then everything is correct 
                echo $finalArabicNum;
            }else{
                echo "Incorrect roman number";
            }
        }
    }
    function arabicToRoman($gotArabicNum){ //Get arabic number
        global $arabicNums, $romanNums; //Make array global
        $newRomanNum = ''; //Variable for new roman number
        $i = count($arabicNums)-1; //Get number of arabic array's elements and minus 1
        while($gotArabicNum>0){ //While current arabic number more than 0
            if($gotArabicNum>=$arabicNums[$i]){ //If current arabic number more or equal than number from arabic array
                $newRomanNum .= $romanNums[$i]; //Then get number from roman array with same position and add to new roman number
                $gotArabicNum -= $arabicNums[$i]; //Current arabic number minus number from arabic array
            }else{ //If current arabic number is less, then go to previous number in arabic array
                $i--;
            }
        }
        return $newRomanNum; //Return final roman number
    }

    function romanToArabic($gotRomanNum){ //Get roman number
        global $arabicNums, $romanNums;
        $newArabicNum = 0; //Variable for arabic new number
        $i = count($romanNums)-1;
        $posInGotRomanNum = 0; //Starting position inside string with roman number
        while($posInGotRomanNum<strlen($gotRomanNum) && $i>=0){ //While starting position less than roman number's string length and $i more than 0 (if roman number will not contain any letter from roman array, then loop will be endless with out $i condition)
            if(substr($gotRomanNum,$posInGotRomanNum,strlen($romanNums[$i]))==$romanNums[$i]){ //Get elements from current roman number, where an amount of elements equal to number's length from roman array and if elements are equal to number from roman array then do next
                $newArabicNum += $arabicNums[$i]; //Get number from arabic array with same position and plus it with new arabic number
                $posInGotRomanNum += strlen($romanNums[$i]); //Change starting position by adding length of comparing number from roman array to current starting position
            }else{ //If elements are not equal, then go to previous number inroman array
                $i--;
            }
        }
        return $newArabicNum; //Return final arabic number
    }
?>
