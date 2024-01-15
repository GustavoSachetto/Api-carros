<?php

namespace App\Http;

class Response
{
    /**
     * Código do Status HTTP
     * @var integer
     */
    private $httpCode = 200; 

    /**
     * Cabeçalho do Response
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo que está sendo retornado
     * @var string
     */
    private $contentType = 'application/json';

    /**
     * Conteúdo do Response
     * @var mixed
     */
    private $content;

    /**
     * Método responsável por iniciar a classe e definir os valores
     * @param integer $httpCode
     * @param mixed $content
     * @return void
     */
    public function __construct($httpCode, $content)
    {
        $this->httpCode = $httpCode;
        $this->content  = $content;
        $this->addHeader("Content-type", $this->contentType);
    }

    /**
     * Método responsável por adicionar um registro no cabeçalho de response
     * @param string $contentType
     * @return void
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar os headers para o navegador
     * @return void
     */
    private function sendHeaders()
    {
        // STATUS
        http_response_code($this->httpCode);

        // ENVIAR HEADERS
        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }
    }

    /**
     * Método responsável por enviar a resposta para o usuário
     * @return void
     */
    public function sendReponse()
    {
        // ENVIA OS HEADERS
        $this->sendHeaders();

        // IMPRIME O CONTEUDO
        switch ($this->contentType) {
            case 'application/json':
                echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                break;
        }
    }
}
