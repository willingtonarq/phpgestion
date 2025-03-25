<!DOCTYPE html>
<html>
<head>
    <title>Calculadora PHP</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            display: flex; 
            height: 100vh; 
            justify-content: center; 
            align-items: center; 
            background-color: #f0f2f5; 
            margin: 0;
        }
        .calculator { 
            background: #fff; 
            padding: 20px; 
            border-radius: 12px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            width: 300px;
        }
        .display { 
            width: calc(100% - 12px); 
            height: 40px; 
            text-align: right; 
            margin-bottom: 10px; 
            padding: 5px; 
            font-size: 1.5em; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
        }
        .buttons { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 5px; 
        }
        button { 
            padding: 15px; 
            font-size: 1.2em; 
            cursor: pointer; 
            border: none; 
            background-color: #0078FF; 
            color: #fff; 
            border-radius: 5px; 
            transition: background 0.3s;
        }
        button:hover {
            opacity: 0.9;
        }
        button.operator { 
            background-color: #ff9500; 
        }
        button.equal { 
            grid-column: span 2; 
            background-color: #4CAF50; 
        }
        button.clear { 
            background-color: #FF3B30; 
        }
        .result { 
            margin-top: 15px; 
            padding: 10px; 
            background: #f8f9fa; 
            border-radius: 5px; 
            text-align: center;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <form method="POST" action="">
            <input type="text" class="display" name="display" readonly 
                   value="<?php echo isset($_POST['display']) ? htmlspecialchars($_POST['display']) : ''; ?>">
            <div class="buttons">
                <button type="button" onclick="appendToDisplay('7')">7</button>
                <button type="button" onclick="appendToDisplay('8')">8</button>
                <button type="button" onclick="appendToDisplay('9')">9</button>
                <button type="button" class="operator" onclick="appendToDisplay('+')">+</button>

                <button type="button" onclick="appendToDisplay('4')">4</button>
                <button type="button" onclick="appendToDisplay('5')">5</button>
                <button type="button" onclick="appendToDisplay('6')">6</button>
                <button type="button" class="operator" onclick="appendToDisplay('-')">-</button>

                <button type="button" onclick="appendToDisplay('1')">1</button>
                <button type="button" onclick="appendToDisplay('2')">2</button>
                <button type="button" onclick="appendToDisplay('3')">3</button>
                <button type="button" class="operator" onclick="appendToDisplay('*')">*</button>

                <button type="button" onclick="appendToDisplay('0')">0</button>
                <button type="button" onclick="appendToDisplay('.')">.</button>
                <button type="submit" class="equal">=</button>
                <button type="button" class="operator" onclick="appendToDisplay('/')">/</button>

                <button type="button" class="clear" onclick="clearDisplay()">C</button>
            </div>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['display'])) {
            $expression = $_POST['display'];
            $result = '';
            
            if (!empty($expression)) {
                // Filtrado de seguridad
                $clean_expression = preg_replace('/[^0-9+\-*\/.]/', '', $expression);
                
                // Validación de expresión matemática
                if (preg_match('/^[\d\.]+([\+\-\*\/][\d\.]+)+$/', $clean_expression)) {
                    // Cálculo seguro (versión mejorada sin eval)
                    $parts = preg_split('/([\+\-\*\/])/', $clean_expression, -1, PREG_SPLIT_DELIM_CAPTURE);
                    
                    if (count($parts) >= 3) {
                        $num1 = floatval($parts[0]);
                        $op = $parts[1];
                        $num2 = floatval($parts[2]);
                        
                        switch ($op) {
                            case '+': $result = $num1 + $num2; break;
                            case '-': $result = $num1 - $num2; break;
                            case '*': $result = $num1 * $num2; break;
                            case '/': $result = ($num2 != 0) ? $num1 / $num2 : 'Error: Div/0'; break;
                            default: $result = 'Error: Operación inválida';
                        }
                    }
                } else {
                    $result = 'Error: Expresión no válida';
                }
            }
            
            echo '<div class="result">';
            echo 'Expresión: ' . htmlspecialchars($expression) . '<br>';
            echo 'Resultado: <strong>' . htmlspecialchars($result) . '</strong>';
            echo '</div>';
        }
        ?>
    </div>

    <script>
        function appendToDisplay(value) {
            document.querySelector(".display").value += value;
        }

        function clearDisplay() {
            document.querySelector(".display").value = "";
        }
    </script>
</body>
</html>