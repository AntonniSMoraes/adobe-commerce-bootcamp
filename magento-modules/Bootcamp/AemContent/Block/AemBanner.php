<?php
namespace Bootcamp\AemContent\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\HTTP\Client\Curl;

class AemBanner extends Template
{
    private Curl $curl;

    public function __construct(
        Template\Context $context,
        Curl $curl,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->curl = $curl;
    }

    public function getAemContent(): array
    {
        // Tenta pegar a URL do banco (setData) ou usa o endereço corrigido para Docker
        $aemUrl = $this->_scopeConfig->getValue('bootcamp_aem/general/aem_url') 
            ?: 'http://host.docker.internal:4502/content/experience-fragments/bootcamp-antonnimoraes/us/en/banner-promo-bootcamp/master.model.json';

        try {
            $this->curl->setCredentials('admin', 'admin');
            $this->curl->setTimeout(5);
            $this->curl->get($aemUrl);

            $status = $this->curl->getStatus();
            if ($status !== 200) {
                throw new \Exception("Erro de conexão: Status " . $status);
            }

            $response = $this->curl->getBody();
            $data = json_decode($response, true);

            // Baseado no seu JSON, o caminho correto é :items -> root -> :items
            $rootItems = $data[':items']['root'][':items'] ?? [];

            return [
                'title' => $rootItems['title']['text'] ?? 'Bootcamp 2026',
                'text'  => $rootItems['text']['text'] ?? 'Confira nossas ofertas!',
                'success' => true,
            ];
        } catch (\Exception $e) {
            return [
                'title' => 'Bootcamp 2026',
                'text'  => 'Conteúdo indisponível no momento. (AEM Offline)',
                'success' => false,
            ];
        }
    }
}