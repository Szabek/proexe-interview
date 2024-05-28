<?php

namespace App\Services\Movies;

use External\Bar\Movies\MovieService as ExternalBarMovieService;
use External\Bar\Exceptions\ServiceUnavailableException;

class BarMovieAdapter implements MovieAdapterInterface
{
    protected ExternalBarMovieService $movieService;

    public function __construct(ExternalBarMovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @throws ServiceUnavailableException
     */
    public function getTitles(): array
    {
        try {
            $response = $this->movieService->getTitles();
            return array_map(function ($item) {
                return $item['title'];
            }, $response['titles']);
        } catch (ServiceUnavailableException $e) {
            throw $e;
        }
    }
}
