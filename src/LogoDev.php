<?php

namespace Syntaxsapiens\LogoDev;

use Illuminate\Support\Facades\Http;

/**
 * LogoDev API Client
 *
 * This class provides methods to interact with the Logo.dev API,
 * including fetching logos by domain or ticker and performing brand searches.
 */
class LogoDev
{
    /**
     * Constructor
     *
     * @param  string  $publishableKey  API publishable key.
     * @param  string  $secretKey  API secret key.
     * @param  string  $apiBaseUrl  Base URL for the Logo.dev API.
     * @param  string  $imgBaseUrl  Base URL for Logo.dev image assets.
     * @param  int|null  $imageSize  Default image size.
     * @param  string|null  $imageFormat  Default image format.
     * @param  bool|null  $imageGreyscale  Default greyscale setting.
     * @param  string|null  $imageFallback  Default fallback behavior.
     */
    public function __construct(
        private string $publishableKey = '',
        private string $secretKey = '',
        private string $apiBaseUrl = 'https://api.logo.dev/',
        private string $imgBaseUrl = 'https://img.logo.dev/',
        private ?int $imageSize = null,
        private ?string $imageFormat = null,
        private ?bool $imageGreyscale = null,
        private ?string $imageFallback = null,
    ) {
        $this->publishableKey = config('logodev.publishable_key');
        $this->secretKey = config('logodev.secret_key');
        $this->imageSize = config('logodev.size');
        $this->imageFormat = config('logodev.format');
        $this->imageGreyscale = config('logodev.greyscale');
        $this->imageFallback = config('logodev.fallback');
    }

    // ----------------------------
    // Public API Methods
    // ----------------------------

    /**
     * Get the logo URL for a domain.
     *
     * @param  string  $domain  The domain to fetch the logo for.
     * @param  array  $options  Additional query parameters (size, format, greyscale, fallback).
     * @return string The logo URL.
     */
    public function logoByDomain(string $domain, array $options = []): string
    {
        return $this->buildLogoUrl($domain, $options);
    }

    /**
     * Get the logo URL for a stock ticker.
     *
     * @param  string  $ticker  The stock ticker symbol.
     * @param  array  $options  Additional query parameters (size, format, greyscale, fallback).
     * @return string The logo URL.
     */
    public function logoByTicker(string $ticker, array $options = []): string
    {
        return $this->buildLogoUrl("ticker/{$ticker}", $options);
    }

    /**
     * Perform a domain search by brand.
     *
     * @param  string  $query  The search query.
     * @return array The brand / domain search results.
     */
    public function brandSearch(string $query): array
    {
        return $this->request($this->apiBaseUrl.'search?q='.urlencode($query));
    }

    /**
     * Describe all brand data for a given domain.
     *
     * @param  string  $domain  The domain to describe.
     * @return array The brand data for the given domain.
     */
    public function describe(string $domain): array
    {
        return $this->request($this->apiBaseUrl.'describe/'.$domain);
    }

    // ----------------------------
    // Private Utility Methods
    // ----------------------------

    /**
     * Build the URL for a logo.
     *
     * @param  string  $path  The path for the logo (domain or ticker).
     * @param  array  $options  Additional query parameters (size, format, greyscale, fallback).
     * @return string The constructed URL.
     */
    private function buildLogoUrl(string $path, array $options = []): string
    {
        $queryParams = array_merge([
            'size' => $this->imageSize,
            'format' => $this->imageFormat,
            'greyscale' => $this->imageGreyscale,
            'fallback' => $this->imageFallback,
            'token' => $this->publishableKey,
        ], $options);

        $queryParams = array_map(function ($value) {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }

            return $value;
        }, $queryParams);

        $queryParams = array_filter($queryParams, fn ($value) => ! is_null($value));

        return $this->imgBaseUrl.$path.'?'.http_build_query($queryParams);
    }

    /**
     * Send an HTTP GET request.
     *
     * @param  string  $url  The URL to request.
     * @return array The JSON-decoded response.
     */
    private function request(string $url): array
    {
        $response = Http::withToken($this->secretKey)
            ->acceptJson()
            ->get($url);

        return $response->json();
    }
}
