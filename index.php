<?php 

require_once __DIR__ . '/vendor/autoload.php';

use Byuufx\Kangu\Calculator;

// sugestão: pegar do seu arquivo .env --> https://github.com/vlucas/phpdotenv

$kangu = new Calculator('SEU_TOKEN_AQUI');

try {

    $result = $kangu->setProducts([
        [
            'peso' => 0.5, // peso em KG
            'altura' => 0.5, // largura em CM
            'largura' => 0.5, // comprimento em CM
            'comprimento' => 0.5, // altura em CM
            'valor' => 100, // valor unitário
            'quantidade' => 2 // quantidade
        ],
        [
            'peso' => 1, // peso em KG
            'altura' => 1, // largura em CM
            'largura' => 1.25, // comprimento em CM
            'comprimento' => 1.25, // altura em CM
            'valor' => 99.90, // valor unitário
            'quantidade' => 2 // quantidade
        ], //podem ser adicionados mais produtos no array
    ])->calculate('11000000', '12000000');

    // exemplo VOLUMES
    /*

        $result = $kangu->setVolumes([
        [
            'peso' => 0.5, // peso em KG
            'altura' => 0.5, // largura em CM
            'largura' => 0.5, // comprimento em CM
            'comprimento' => 0.5, // altura em CM
            'valor' => 100, // valor unitário
            'quantidade' => 2 // quantidade,
            'tipo' => 'C' // Opcional, padrão 'C' . C - Caixa, E - Envelope
        ], //podem ser adicionados mais produtos no array
    ])->calculate('11000000', '12000000');

    */

    // mostra o resultado
    print_r($result);


} catch (\Exception $e) {
    echo 'Não foi possível calcular o frete. Detalhes: ' . $e->getMessage();
}


//TODO - enviar o frete para a KANGU

//TODO - rastreamento do frete

