<?php namespace Classes;


class Decipher
{
    public $code;

    public function __construct($code)
    {
        $this->code = $this->mbStringToArray($code);
    }

    /**
     * Метод разбивает строку на символы с учётом многобайтных кодировок
     * @param $string
     * @return array
     */
    public function mbStringToArray ($string): array
    {
        $strlen = mb_strlen($string);
        while ($strlen) {
            $array[] = mb_substr($string,0,1,"UTF-8");
            $string = mb_substr($string,1,$strlen,"UTF-8");
            $strlen = mb_strlen($string);
        }
        return $array;
    }

    /**
     * Метод расшифровки
     * @return string
     */
    public function decoding(): string
    {
        $decode = '';
        $code = $this->code;

        $i = 0;
        $c = 0;
        while(true) {
            if($c>100) die("overload stop - code=$decode\n");$c++;
            if(!isset($code[$i])) return $decode;

            $sy = $code[$i];

            # Trash skip
            if(preg_match('/\d/', $sy) || $code[$i] == '>') {
                $i++;
                continue;
            }

            # Move to index
            if(isset($code[$i+1]) && $sy.$code[$i+1]=='->') {
                $i = $this->getArg($i+2);
                continue;
            }

            # Shift
            if(($sy == '+' || $sy == '-') && $sy.$code[$i+1]!='->') {
                $arg = $this->getArg($i+1, $sy);
                if($sy == '+') {
                    $i += $arg;
                } else {
                    $i -= $arg;
                }
                continue;
            }

            # Add to decode
            $decode .= $sy;
            $i++;
        }

    }

    /**
     * Метод получения аргумента
     * @param $i - Индекс начала аргумента
     * @param bool $shiftWay - Корректировка по "ширине" аргумента в случе смещения вправо
     * @return int
     */
    public function getArg($i, $shiftWay = false): int
    {
        $code = $this->code;
        $arg = '';

        while(preg_match('/\d/', $code[$i])) {
            $arg .= $code[$i];
            $i++;
        }

        $add = 0;
        if($shiftWay && $shiftWay == '+') {
            $add = strlen($arg)+1;
        }

        $arg = intval($arg);

        return $arg+$add;
    }

}