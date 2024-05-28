<?php

namespace App\Services\Movies;

use External\Baz\Movies\MovieService as ExternalBazMovieService;
use External\Baz\Exceptions\ServiceUnavailableException;

class BazMovieAdapter implements MovieAdapterInterface
{
    protected ExternalBazMovieService $movieService;

    public function __construct(ExternalBazMovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function getTitles(): array
    {
        try {
            $response = $this->movieService->getTitles();
            return $response['titles'];
        } catch (ServiceUnavailableException $e) {
            throw $e;
        }
    }
}
