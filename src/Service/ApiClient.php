<?php
declare (strict_types=1);

namespace Service;


class ApiClient {

    /** @var \Maleficarum\Client\Http\Rest\BasicClient  */
    protected $httpClient;

    /**
     * ApiClient constructor.
     *
     * @param \Maleficarum\Client\Http\Rest\BasicClient $httpClient
     */
    public function __construct(\Maleficarum\Client\Http\Rest\BasicClient $httpClient) {
        $this->httpClient = $httpClient;
    }

    /**
     * @param int $articleId
     *
     * @return array
     */
    public function getArticle(int $articleId): array {
        $this->httpClient->get('/articles/'.$articleId);

        return $this->httpClient->getParsedBody();
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function getArticles($limit = 10, $offset = 0): array {
        $parameters = [
            'limit' => $limit,
            'offset' => $offset,
            'sort' => '-id',
            'status' => 1 //Only active
        ];

        $this->httpClient->get('/articles?'.\http_build_query($parameters));

        return $this->httpClient->getParsedBody();
    }
}