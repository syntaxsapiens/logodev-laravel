<?php

namespace Syntaxsapiens\LogoDev\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Syntaxsapiens\LogoDev\LogoDev;

it('generates correct logo url for domain', function () {
    $logoDev = new LogoDev;

    $url = $logoDev->logoByDomain('example.com');

    expect($url)->toBe(
        'https://img.logo.dev/example.com?token=test-pub-key'
    );
});

it('generates correct logo url for stock ticker', function () {
    $logoDev = new LogoDev;

    $url = $logoDev->logoByTicker('AAPL');

    expect($url)->toBe(
        'https://img.logo.dev/ticker/AAPL?token=test-pub-key'
    );
});

it('generates logo url with request-level custom options', function () {
    $logoDev = new LogoDev;

    $url = $logoDev->logoByDomain('example.com', [
        'size' => 256,
        'format' => 'png',
        'greyscale' => true,
        'fallback' => 404,
    ]);

    expect($url)->toBe(
        'https://img.logo.dev/example.com?size=256&format=png&greyscale=true&fallback=404&token=test-pub-key'
    );
});

it('generates logo url with configuration-level custom options', function () {
    config()->set('logodev', array_merge(
        config('logodev'),
        [
            'size' => 256,
            'format' => 'png',
            'greyscale' => true,
            'fallback' => 404,
        ]
    ));

    $logoDev = new LogoDev;

    $url = $logoDev->logoByDomain('example.com');

    expect($url)->toBe(
        'https://img.logo.dev/example.com?size=256&format=png&greyscale=true&fallback=404&token=test-pub-key'
    );
});

it('can search for brands through the API', function () {
    Http::fake([
        'api.logo.dev/search?q=example' => Http::response([
            'results' => [
                ['domain' => 'example.com', 'name' => 'Example Inc'],
            ],
        ], 200),
    ]);

    $logoDev = new LogoDev;

    $results = $logoDev->brandSearch('example');

    expect($results)
        ->toBeArray()
        ->toHaveKey('results')
        ->and($results['results'])
        ->toBeArray()
        ->toHaveCount(1);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.logo.dev/search?q=example'
            && $request->hasHeader('Authorization', 'Bearer test-secret-key');
    });
});

it('can describe a domain through the API', function () {
    // Given we have a mocked API response
    Http::fake([
        'api.logo.dev/describe/example.com' => Http::response([
            'name' => 'Example Inc',
            'domain' => 'example.com',
            'description' => 'Some example description',
            'indexed_at' => '2024-10-25T15:30:27.36329-07:00',
            'logo' => 'https://img.logo.dev/example.com?token=test-pub-key',
            'socials' => [
                'facebook' => 'http://facebook.com/example',
                'instagram' => 'https://www.instagram.com/example',
            ],
        ], 200),
    ]);

    $logoDev = new LogoDev;

    $result = $logoDev->describe('example.com');

    expect($result)
        ->toBeArray()
        ->toHaveKey('name', 'Example Inc');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.logo.dev/describe/example.com'
            && $request->hasHeader('Authorization', 'Bearer test-secret-key');
    });
});
