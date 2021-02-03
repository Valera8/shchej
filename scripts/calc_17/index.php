<?php
/*Обработка данных, полученных из формы */
if (isset($_POST["calc"]))
{
	require_once "function.php";
	/*Принять данные */
	$n_1 = $_POST["n_1"];
	$n_2 = $_POST["n_2"];
	$operation = $_POST["operation"];
	/*Определить какая из математических операций выполнена пользователем
	и выдать результат*/
	switch ($operation)
	{
		case "add":
			$result = "$n_1 + $n_2 = " . add($n_1, $n_2);
			break;
		case "mult":
			$result = "$n_1 * $n_2 = " . mult($n_1, $n_2);
			break;
		case "sub":
			$result = "$n_1 - $n_2 = " . sub($n_1, $n_2);
			break;
		case "div":
		{
			$result = div($n_1, $n_2);
			/*Проверка на эквивалентность*/
			if ($result === false) $result = "Деление на ноль!";
			else
				$result = "$n_1 / $n_2 = $result";
			break;
		}
		case "fact":
		{
			$result = factorial($n_1);
			if ($result === false) $result = "Факториала не существуюет!";
			else
				$result = "$n_1! = $result";
			break;
		}
		/*Среднее арифметическое*/
		case "meam":
			$result = "($n_1 + $n_2) / 2 = " . meam($n_1, $n_2);
			break;
		default:
			$result = "Неизвестная операция";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Калькулятор</title>
</head>
<body>
<!--Вывод результата вычисления-->
<?php
if (isset($result)) echo "<p>Вычисление: $result</p>";
?>
<form name="myform" action="index.php?" method="POSt">
	<p>
		<!--Для сохранения введенных чисел в форму - атрибут value -->
		<input type="text" name="n_1" value="<?php echo $n_1;?>" />
		<select name="operation">
			<?php
			/*Массив списка математических операций*/
			$operations = ["add" => "+", "sub" => "-", "mult" => "*", "div" => "/", "fact" => "!", "meam" => "<>"];
			foreach ($operations as $key => $value)
			{
				if ($operation == $key)
					/*Атрибут selected - для сохранения введенных пользователем операций в форму*/
					echo "<option value='$key' selected='selected'>$value</option>";
				else echo "<option value='$key'>$value</option>";
			}
			?>
		</select>
		<input type="text" name="n_2" value="<?php echo $n_2;?>" />
		<br><br>
		<input type="submit" name="calc" value="Вычислить" />
	</p>
</form>
</body>
</html>