A simple Shopify app in PHP.

# Getting Started

Create a new file called `.env` which contains your Shopify API credentials. See `.env.example` for an example.

## Install dependencies
`cd src`
`composer install`

## Run the application
`php -S localhost:8000`

# Advanced Usage

`helpers.php` includes a simple API wrapper for Shopify.

See [this gist](https://gist.github.com/jamiemtdwyer/e109bcab1ff187f6341b7077904e47d6) for a more advanced usage example of `performShopifyRequest()`.