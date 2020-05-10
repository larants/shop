<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-07-12
 */

namespace Leading\Lib\Http;

use Closure;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Leading\Lib\Exceptions\HttpException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LibClient
 * @package Leading\Lib\Http
 */
class LibClient
{
    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @var Collection
     */
    protected $middleware;

    /**
     * @var HandlerStack
     */
    protected $handlerStack;

    /**
     * @var string
     */
    protected $baseUri = '';

    /**
     * 每次请求的超时时间
     *
     * @var int
     */
    protected $timeout = 30.0;

    /**
     * 请求头信息
     *
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $defaults = [];

    /**
     * 跳过Retry
     *
     * @var bool
     */
    protected $skipRetry = false;

    /**
     * 尝试次数
     *
     * @var int
     */
    protected $retries = 0;

    /**
     * 最大尝试次数
     *
     * @var int
     */
    protected $maxRetries = 5;

    /**
     * BaseClient constructor.
     * @param GuzzleClient $client
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
        $this->middleware = collect();
    }


    /**
     * get request.
     *
     * @param string $uri
     * @param array $query
     * @return string
     * @throws HttpException
     */
    public function get(string $uri, array $query = [])
    {
        return $this->request('GET', $uri, [
            'query' => $query
        ]);
    }

    /**
     * post request.
     *
     * @param string $uri
     * @param array $data
     * @return string
     * @throws HttpException
     */
    public function post(string $uri, array $data = [])
    {
        return $this->request('POST', $uri, [
            'form_params' => $data
        ]);
    }

    /**
     * json post request.
     *
     * @param string $uri
     * @param array $data
     * @param array $query
     * @return string
     * @throws HttpException
     */
    public function postJson(string $uri, array $data = [], array $query = [])
    {
        $this->headers['Content-Type'] = 'application/json';

        return $this->request('POST', $uri, [
            'query' => $query,
            'json' => $data
        ]);
    }

    /**
     * upload file request.
     *
     * @param string $uri
     * @param array $files
     * @param array $form
     * @param array $query
     * @return string
     * @throws HttpException
     */
    public function upload(string $uri, array $files = [], array $form = [], array $query = [])
    {
        $multipart = [];

        foreach ($files as $name => $path) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($path, 'r'),
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->request('POST', $uri, [
            'query' => $query,
            'multipart' => $multipart
        ]);
    }

    /**
     * Make a request.
     *
     * @param $method
     * @param $uri
     * @param array $options
     * @return string
     * @throws HttpException
     */
    public function request($method, $uri, $options = [])
    {
        $method = strtoupper($method);
        // 重试
        if (!$this->skipRetry) {
            $this->pushMiddleware($this->retryMiddleware());
            $this->pushMiddleware($this->addTimeoutMiddleware());
        }
        // 是否需要递归合并
        $options = array_merge($this->defaults, $options, [
            'base_uri' => $this->baseUri,
            'timeout' => $this->timeout,
            'headers' => $this->headers,
            'handler' => $this->getHandlerStack()
        ]);

        try {
            $response = $this->client->request($method, $uri, $options);

            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            throw new HttpException(
                $e->getResponse()->getStatusCode(),
                $e->getResponse()->getBody()->getContents()
            );
        } catch (Exception $e) {
            throw new HttpException(400, $e->getMessage());
        }
    }

    /**
     * @param $uri
     * @param array $query
     * @return PromiseInterface
     */
    public function asyncGet($uri, array $query = [])
    {
        return $this->asyncRequest('GET', $uri, [
            'query' => $query,
        ]);
    }

    /**
     * @param $uri
     * @param array $data
     * @return PromiseInterface
     */
    public function asyncPost($uri, $data = [])
    {
        return $this->asyncRequest('POST', $uri, [
            'form_params' => $data
        ]);
    }

    /**
     * @param $uri
     * @param array $query
     * @param array $data
     * @return PromiseInterface
     */
    public function asyncPostJson($uri, $query = [], $data = [])
    {
        return $this->asyncRequest('POST', $uri, [
            'query' => $query,
            'json' => $data
        ]);
    }

    /**
     * 使用Promise和异步请求来同时发送多个请求
     *
     * @param array $promises
     * @return array
     */
    public function unwrap(array $promises)
    {
        $results = [];
        foreach ($promises as $key => $promise) {
            /* @var Promise $promise */
            $response = $promise->wait();
            $results[$key] = $response;
        }

        return $results;
    }

    /**
     * @param string $method
     * @param $uri
     * @param array $options
     * @return PromiseInterface
     */
    public function asyncRequest($method, $uri, $options = [])
    {
        $method = strtoupper($method);

        $options = array_merge($this->defaults, $options, [
            'base_uri' => $this->baseUri,
            'timeout' => $this->timeout,
            'headers' => $this->headers
        ]);

        return $this->client->requestAsync($method, $uri, $options);
    }

    /**
     * @param string $baseUri
     */
    public function setBaseUri(string $baseUri): void
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @param bool $skipRetry
     */
    public function setSkipRetry(bool $skipRetry): void
    {
        $this->skipRetry = $skipRetry;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Add a header
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Add a middleware.
     *
     * @param callable $middleware
     * @param string|null $name
     *
     * @return $this
     */
    public function pushMiddleware(callable $middleware, string $name = null)
    {
        if (!is_null($name)) {
            $this->middleware->put($name, $middleware);
        } else {
            $this->middleware->push($middleware);
        }

        return $this;
    }

    /**
     * Build a handler stack.
     *
     * @return HandlerStack
     */
    public function getHandlerStack(): HandlerStack
    {
        if ($this->handlerStack) {
            return $this->handlerStack;
        }
        $this->handlerStack = HandlerStack::create(new CurlHandler());
        $this->middleware->each(function ($middleware, $name) {
            $this->handlerStack->push($middleware, $name);
        });

        return $this->handlerStack;
    }


    /**
     * @param $contents
     * @return array
     */
    public function toArray($contents): array
    {
        if (is_array($contents)) {
            return $contents;
        }
        return \GuzzleHttp\json_decode($contents, true);
    }

    /**
     * Build to collection.
     *
     * @param $content
     * @return Collection
     */
    public function toCollection($content): Collection
    {
        return collect($this->toArray($content));
    }

    /**
     * Return retry middleware.
     *
     * @return Closure
     */
    protected function retryMiddleware()
    {
        return Middleware::retry(function (
            $retries,
            Request $request,
            ResponseInterface $response = null,
            Exception $exception = null
        ) {
            // Limit the number of retries
            if ($retries >= $this->maxRetries) {
                return false;
            }
            // Retry connection exceptions
            if ($exception instanceof ConnectException) {
                $this->retries = $retries + 1;
                Log::error('timeout', [
                    'retries' => $this->retries,
                    'uri' => $request->getUri(),
                    'exception' => $exception->getMessage()
                ]);
                return true;
            }
            // todo others
            if ($response) {
                // Retry on server errors
                if ($response->getStatusCode() >= 500) {
                    return true;
                }
            }
            return false;
        });
    }


    /**
     * @return Closure
     */
    protected function addTimeoutMiddleware()
    {
        return function (callable $handler) {
            return function (Request $request, array $options) use ($handler) {
                // 如果存在超时，修改下一次请求时间
                if ($this->retries) {
                    $options['timeout'] = ($this->retries + 1) * $this->timeout;
                }

                return $handler($request, $options);
            };
        };
    }
}