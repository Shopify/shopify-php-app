<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require 'helpers.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . '..');
$dotenv->load();

$config = [
  'apiKey' => $_ENV['API_KEY'],
  'secret' => $_ENV['SECRET']
];

$app = new \Slim\App($config);

// install route
$app->get('/', function (Request $request, Response $response) {
  $apiKey = $this->get('apiKey');
  $shop = $request->getQueryParam('shop');
  $scope = 'write_products,read_orders';

  $scheme = $request->getUri()->getScheme();
  $host = $request->getUri()->getHost();
  $port = $request->getUri()->getPort();
  $redirectUri = $scheme . "://" . $host . ":" . $port . $this->router->pathFor('oAuthCallback');
  $installUrl = "https://{$shop}/admin/oauth/authorize?client_id={$apiKey}&scope={$scope}&redirect_uri={$redirectUri}";

  return $response->withRedirect($installUrl);
});

// callback route
$app->get('/auth/shopify/callback', function (Request $request, Response $response) {
  $params = $request->getQueryParams();
  $apiKey = $this->get('apiKey');
  $secret = $this->get('secret');
  $validHmac = validateHmac($params, $secret);
  $accessToken = "";

  if ($validHmac) {
    $accessToken = getAccessToken($params['shop'], $apiKey, $secret, $params['code']);
  } else {
    return $response->getBody()->write("This request is NOT from Shopify!");
  }

  $shopifyResponse = performShopifyRequest(
    $params['shop'], $accessToken, 'products', array('limit' => 10)
  );
  $products = $shopifyResponse['products'];

  $responseBody = "<h1>Your products:</h1>";
  foreach ($products as $product) {
    $responseBody = $responseBody . '<br>' . $product['title'];
  }

  return $response->getBody()->write($responseBody);
})->setName('oAuthCallback');

$app->run();
