# A simple Shopify app in PHP.

## Getting Started

Create a new file called `.env` which contains your Shopify API credentials. See `.env.example` for an example.

### Install dependencies
```shell
cd src
composer install
```

### Run the application
```shell
cd src/public
php -S localhost:8000
```

### Installing to your Shopify store
Navigate to the following URL in your browser:

`http://localhost:8000/?shop=my-test-shop.myshopify.com`

Making the appropriate subsitutions for your hostname and `myshopify` domain.

## Advanced Usage

`helpers.php` includes a simple API wrapper for Shopify.

See [this gist](https://gist.github.com/jamiemtdwyer/e109bcab1ff187f6341b7077904e47d6) for a more advanced usage example of `performShopifyRequest()`.
