<?php namespace Classes;

class MultiArr
{
    public $matrix;

    /**
     * Метод получения числа из ряда Фибоначчи по индексу
     * @param $i - Индекс числа
     * @return int - Число
     */
    private function fibonacciCalc($i): int
    {
        if ($i < 3) {
            return 1;
        }
        else {
            return $this->fibonacciCalc($i - 1) + $this->fibonacciCalc($i - 2);
        }
    }

    /**
     * Метод генерации массива из чисел ряда Фибоначчи
     * @param $count - Размер генерируемого массива
     * @return array
     */
    public function fibonacciBuild($count): array
    {
        $return = [];
        for ($i = 1; $i <= $count; $i++) {
            $return[] = $this->fibonacciCalc($i);
        }
        return $return;
    }

    /**
     * Метод сборки двумерной матрицы из массива
     * @param int $x - Ширина матрицы
     * @param int $y - Высота матрицы
     * @param bool $rotate90 - Транспонирование матрицы
     * @return object
     */
    public function createMatrix($x=3, $y=3, $rotate90 = false): object
    {
        $numbers = $this->fibonacciBuild($x*$y);

        $matrix = [];

        for($i=0;$i<$y;$i++) {
            $line = [];
            for($ii=0;$ii<$x;$ii++) {
                $line[] = $numbers[$i*$x+$ii];
            }
            $matrix[] = $line;
        }

        if($rotate90) {
            array_unshift($matrix, null);
            $matrix = call_user_func_array("array_map", $matrix);
        }

        $this->matrix = $matrix;

        return $this;
    }

    /**
     * Метод вывода результата
     * @return array
     */
    public function toArray(): array
    {
        return $this->matrix;
    }

    /**
     * Линейное суммирование по координатам элементов матрицы
     * @param $a - Начало отрезка суммирование
     * @param $b - Конец отрезка суммирования
     * @return int
     */
    public function linearSum($a, $b): int
    {
        $x = $a[0];
        $y = $a[1];
        $sum = 0;

        while(true)
        {
            $sum += $this->matrix[$y][$x];

            if(!isset($this->matrix[$y]) || !isset($this->matrix[$y][$x])) break;
            if($x == $b[0] && $y == $b[1]) break;

            if($a[0] < $b[0]) $x++;
            if($a[0] > $b[0]) $x--;
            if($a[1] < $b[1]) $y++;
            if($a[1] > $b[1]) $y--;
        }

        return $sum;
    }
}