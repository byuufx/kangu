<?php 

namespace Byuufx\Kangu;

class Calculator extends Kangu
{

    /**
     * Volumes - informar produtos ou volumes, apenas um
     * 
     * @var array
     * 
    */
    public $volumes = [];

    /**
     * Produtos - informar produtos ou volumes, apenas um
     * 
     * @var array
     * 
    */
    public $products = [];

    /**
     * Ordem - preco ou prazo
     */
    public $order = 'preco';

    /**
     * Serviços disponíveis - E, X, M, R, utilizar ao menos um destes
     * 
     * @var array
     */
    public $services = [
        "E",
        "X",
        "M",
        "R"
    ];

    public function __construct($token)
    {
        parent::__construct($token);
    }


    /**
     * Set products
     * 
     * @param array $products
     * 
     * @throws \Exception
     * 
     * @return object
     */
    public function setProducts($products){
        
        //empty
        if(empty($products) || !is_array($products)){
            throw new \Exception('Produtos não informados');
        }

        foreach($products as $product){
            
            $this->products[] = [
                "peso" => floatval($product['peso']),
                "altura" => floatval($product['altura']),
                "largura" => floatval($product['largura']),
                "comprimento" => floatval($product['comprimento']),
                "valor" => floatval($product['valor']),
                "quantidade" => intval($product['quantidade']),
            ];

        }

        return $this;
    }


    /**
     * Set volumes
     * 
     * @param array $volumes
     * 
     * @throws \Exception
     */

    public function setVolumes($volumes){
        
        if(empty($volumes) || !is_array($volumes)){
            throw new \Exception('Volumes não informados');
        }

        foreach($volumes as $volume){
            
            $this->volumes[] = [
                "peso" => floatval($volume['peso']),
                "altura" => floatval($volume['altura']),
                "largura" => floatval($volume['largura']),
                "comprimento" => floatval($volume['comprimento']),
                "valor" => floatval($volume['valor']),
                "quantidade" => intval($volume['quantidade']),
            ];

        }

        return $this;

    }

    
    /**
     * Simula o frete com base nos dados informados
     *
     * @param string $from_postal_code CEP de origem
     * @param string $to_postal_code CEP de destino
     *
     * @return object
     *
     * @throws \Exception Dados inválidos ou erro na requisição
     */
    public function calculate($from_postal_code, $to_postal_code)
    {
        
        if(empty($this->volumes) && empty($this->products)){
            throw new \Exception('Produtos e volumes não informados');
        }

        $data = [
            'cepOrigem' => preg_replace('/[^0-9]/', '', $from_postal_code),
            'cepDestino' => preg_replace('/[^0-9]/', '', $to_postal_code),
        ];

        //volumes and products
        if(!empty($this->products)){
            $data['produtos'] = $this->products;

            //vlrMerc
            $data['vlrMerc'] = array_sum(array_map(function($product) {
                return $product['valor'] * $product['quantidade'];
            }, $this->products));

            //pesoMerc
            $data['pesoMerc'] = array_sum(array_column($this->products, 'peso'));

        }elseif(!empty($this->volumes)){
            $data['volumes'] = $this->volumes;

            //vlrMerc
            $data['vlrMerc'] = array_sum(array_map(function($volume) {
                return $volume['valor'] * $volume['quantidade'];
            }, $this->volumes));

            //pesoMerc
            $data['pesoMerc'] = array_sum(array_column($this->volumes, 'peso'));

        }

        //services
        $data['servicos'] = $this->services;


        $result = $this->send('/simular', $data);

        return $result;
    }




}