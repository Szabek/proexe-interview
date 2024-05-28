<?php

namespace App\Services\Movies;


use Illuminate\Support\Facades\Cache;
use External\Foo\Exceptions\ServiceUnavailableException;
class MovieAggregatorService
{
    protected FooMovieAdapter $fooAdapter;
    protected BarMovieAdapter $barAdapter;
    protected BazMovieAdapter $bazAdapter;

    public function __construct(
        FooMovieAdapter $fooAdapter,
        BarMovieAdapter $barAdapter,
        BazMovieAdapter $bazAdapter
    ) {
        $this->fooAdapter = $fooAdapter;
        $this->barAdapter = $barAdapter;
        $this->bazAdapter = $bazAdapter;
    }

    public function getAggregatedTitles(): array
    {
        return Cache::remember('movie_titles', 60, function () {
            return array_merge(
                $this->retry([$this->fooAdapter, 'getTitles']),
                $this->retry([$this->barAdapter, 'getTitles']),
                $this->retry([$this->bazAdapter, 'getTitles'])
            );
        });
    }

    private function retry(callable $callback, $attempts = 3, $delay = 100)
    {
        for ($i = 0; $i < $attempts; $i++) {
            try {
                return $callback();
            } catch (ServiceUnavailableException $e) {
                if ($i === $attempts - 1) {
                    throw $e;
                }
                usleep($delay * 1000);
            }
        }
        throw new \Exception('Service is unavailable after multiple attempts.');
    }
}
