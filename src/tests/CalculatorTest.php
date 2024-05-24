<?php

namespace App\tests;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase{//esta herdando as propiedades do testcase para usarmos seus metodos

    public function testSumMethod(){//seguir padrão camelCase OBRIGATORIAMENTE

        $calc = new App/Model/Calculator();

        $method = $calc->sum(1,2);

        $this->assertSame(3,$method);//assertSame(resposta, função) - verifica se resultado é verdadeiro

    }

}

/*
    PARA FAZER O TESTE, REALIZAR UM COMANDO NO TERMINAL DO PROEJTO:
    open ./vendor/bin/phpunit src/tests/CalculatorTest.php

    para executar um executavel que analiza o teste.
*/