<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KnnService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private string $url, private int $timeout = 5 * 60) {}

    public function train()
    {
        $response = Http::post("{$this->url}/train");
        $response->throw();

        return $response->json();
    }

    public function predict(array $userAnswers): array
    {
        $response = Http::post("{$this->url}/predict", ['user_answers' => $userAnswers]);
        $response->throw();

        return $response->json('recommendations');
    }

    public function analysisReport()
    {
        set_time_limit($this->timeout);
        $response = Http::timeout($this->timeout)->get("{$this->url}/analysis");
        $response->throw();

        return $response->json('analysis');
    }
}
