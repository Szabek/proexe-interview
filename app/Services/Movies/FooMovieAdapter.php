<?php

namespace App\Services\Movies;

use External\Foo\Movies\MovieService as ExternalFooMovieService;
use External\Foo\Exceptions\ServiceUnavailableException;

class FooMovieAdapter implements MovieAdapterInterface
{
    protected ExternalFooMovieService $movieService;

    public function __construct(ExternalFooMovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @throws ServiceUnavailableException
     */
    public function getTitles(): array
    {
        try {
            return $this->movieService->getTitles();
        } catch (ServiceUnavailableException $e) {
            throw $e;
        }
    }
}
