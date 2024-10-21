<?php

namespace Byuufx\Kangu;

trait Connection
{
    /**
     * Envia uma requisi o para a API da Kangu
     *
     * @param string $url URL da API da Kangu
     * @param array $body Dados a serem enviados
     *
     * @return array
     *
     * @throws \Exception
     */
    public function send($url, $body)
    {

        if(empty($url)){
            throw new \Exception('URL Kangu não informada');
        }
        
        $body = json_encode($body, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => Kangu::API_URL . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Content-Type:application/x-www-form-urlencoded',
                'token: ' . $this->token,
                'Content-Length: ' . strlen($body)
            )
        ]);

        //localhost, chama o cacert.pem ( C://php/cacert.pem )
        if(!isset($_SERVER['REMOTE_ADDR'])){
            curl_setopt($ch, CURLOPT_CAINFO, 'C://php/cacert.pem');
        }

        $response = curl_exec($ch);
        curl_close($ch);

        if(empty($response)){
            throw new \Exception('Erro ao conectar com Kangu - ' . curl_error($ch));
        }

        return json_decode($response, true);


    }
}
