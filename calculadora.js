/*
  Funcionalidad de multiplicacion y division desarrollada por:
  Juan Diego Blandon
  Juan Estevan Zapata
  Jeisson Osorio
*/

function appendToDisplay(value) {
    document.getElementById("display").value += value;
  }

  function clearDisplay() {
    document.getElementById("display").value = "";
  }

  function isDigit(numero) {
    return numero >= '0' && numero <= '9';
  }

  function validarExpresion(expr) {
    if (expr.length === 0) return false;
    
    let esperaNumero = true;
    let usoPunto = false;
    let caracterAnterior = '';
    
    for (let i = 0; i < expr.length; i++) {
      const caracter = expr[i];
      if (esperaNumero) {
        if (isDigit(caracter)) {
          esperaNumero = false;
        } else {
          return false;
        }
      } else {
        if (isDigit(caracter)) {
          caracterAnterior = caracter;
          continue;
        } else if (caracter === '.') {
          if (usoPunto) return false;
          usoPunto = true;
        } else if (caracter === '*' || caracter === '/') {
          if (caracterAnterior === '.') return false;
          esperaNumero = true;
          usoPunto = false;
        } else {
          return false;
        }
      }

      caracterAnterior = caracter;
    }

    if (caracterAnterior === '.' || caracterAnterior === '*' || caracterAnterior === '/')
        return false;

    return !esperaNumero;
  }

  function multiplicar(a, b) {
    return a * b;
  }

  function dividir(a, b) {
    return a / b;
  }

  function calcularOperacion() {
    var expr = document.getElementById("display").value;
    expr = expr.replace(/\s/g, "");
    if (!validarExpresion(expr)) {
      document.getElementById("display").value = "Expresión inválida";
      return;
    }

    var i = 0;
    var numeroAuxiliar = "";
    while (i < expr.length && (isDigit(expr[i]) || expr[i] === '.')) {
      numeroAuxiliar += expr[i];
      i++;
    }

    var resultado = parseFloat(numeroAuxiliar);
    numeroAuxiliar = "";

    while (i < expr.length) {
      var operador = expr[i];
      i++;

      while (i < expr.length && (isDigit(expr[i]) || expr[i] === '.')) {
        numeroAuxiliar += expr[i];
        i++;
      }

      var siguienteNumero = parseFloat(numeroAuxiliar);
      numeroAuxiliar = "";
      if (operador === '*') {
        resultado = multiplicar(resultado, siguienteNumero);
      } else if (operador === '/') {
        if (siguienteNumero === 0) {
          document.getElementById("display").value = "Error: Div/0";
          return;
        }
        resultado = dividir(resultado, siguienteNumero);
      }
    }
    document.getElementById("display").value = resultado;
  }