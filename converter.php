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
    <p>Convert arabic to roman or roman to arabic numbers, from 0 to 4000</p>
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
        if(is_numeric($_GET['someNumber']) && $_GET['someNumber']>0 && $_GET['someNumber']<4000 && ctype_digit($_GET['someNumber'])){ //ctype_digit - если в строке только цифры
            $finalRomanNum = arabicToRoman($_GET['someNumber']); //Вызов функции и передача ей введенных данных
            echo $finalRomanNum;
        }elseif(is_numeric($_GET['someNumber']) && ($_GET['someNumber']<=0 || $_GET['someNumber']>3999)){
            echo "Number must be between 0 and 4000 ";
        }elseif(is_numeric($_GET['someNumber']) && $_GET['someNumber']>0 && !ctype_digit($_GET['someNumber'])){
            echo "Number must be integer";
        }else{ //Если введены буквы и цифры
            $finalArabicNum = romanToArabic(strtoupper($_GET['someNumber'])); //Функция переведет в цифры те буквы, которые есть в массиве и вернет ответ
            $checkFinalArabicNum = arabicToRoman($finalArabicNum); //Полученный ответ снова будет переведен в римский вариант
            if($checkFinalArabicNum==strtoupper($_GET['someNumber'])){ //Если введенное римское число совпадает с переведенным
                echo $finalArabicNum;
            }else{
                echo "Incorrect roman number";
            }
        }
    }
    function arabicToRoman($gotArabicNum){ //Получаем введенные цифры
        global $arabicNums, $romanNums; //Делаем массивы глобальными, что бы использовать в ф-ии
        $newRomanNum = ''; //Новая переменная, куда будет записан римский вариант
        $i = count($arabicNums)-1; //Переменная i для удобства
        while($gotArabicNum>0){ //Пока введенное число не будет равно нулю
            if($gotArabicNum>=$arabicNums[$i]){ //Если полученное число/цифра больше или равно числу/цифре из массива с арабскими
                $newRomanNum .= $romanNums[$i]; //То взять из массива с римскими число/цифру, стоящую на такой же позиции в массиве и добавить в переменную $newRomanNum
                $gotArabicNum -= $arabicNums[$i]; //От введенного числа отнять число/цифру из арабского массива
            }else{ //Если не нашлось соответствий, то перейти к элементу массива с меньшим индексом(i), соответсвенно и меньшим общим числовым значением. Числа в обоих массивах записаны по возрастанию
                $i--;
            }
        }
        return $newRomanNum; //Вернуть полученный результат
    }

    function romanToArabic($gotRomanNum){ //Получаем введенные буквы
        global $arabicNums, $romanNums;
        $newArabicNum = 0; //Новая переменная, где будут складываться арабские числа
        $i = count($romanNums)-1;
        $posInGotRomanNum = 0; //Переменная для отслеживания позиции внутри строки м римским числом/цифрой
        while($posInGotRomanNum<strlen($gotRomanNum) && $i>=0){ //Пока позиция меньше длины введенных римских цифр, а i больше, либо равно нулю. Если среди букв не будет ни одной из массива, то без условия для i цикл будет бесконечным. Сдвиг по позиции позволяет проверить всю строку с начала до конца
            if(substr($gotRomanNum,$posInGotRomanNum,strlen($romanNums[$i]))==$romanNums[$i]){ //Берем самое большое и последнее римское число из массива, смотрим сколько его длина и сравниваем его с таким же количеством(по длине) элементов в веденной строке, начиная с указанной позиции
                $newArabicNum += $arabicNums[$i]; //Из массива с арабскими числами берем число/цифру с таким же индексом и прибавляем
                $posInGotRomanNum += strlen($romanNums[$i]); //Позиция сдвигает на длину сравниваемого элемента
            }else{
                $i--;
            }
        }
        return $newArabicNum;
    }
?>
