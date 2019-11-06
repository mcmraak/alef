<?php

# Class loader
spl_autoload_register(function ($class) {
    include __DIR__.str_replace('Classes\\', '/classes/', $class). '.php';
});

use Classes\MultiArr as A;
use Classes\Decipher as B;

# Сумма чисел в матрице построеной из чисел последовательности
# фибоначчи по выбранным координатам елементов

echo "Задача 1 - ответ: ";
echo (new A)->createMatrix(6, 6, 1)->linearSum([0,5], [5,0]);
echo "<br>";
echo "Задача 2 - ответ: ";
echo (new B('->11гe+20∆∆A+4µcњil->5•Ћ®†Ѓ p+5f-7Ќ¬f pro+10g+1悦ra->58->44m+1*m+2a喜er!'))->decoding();