<?php

namespace App\Http\Middleware;

use App\Services\UserQuestionnaireService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserQuestionsAreAllAnswered
{
    public function __construct(
        public UserQuestionnaireService $userQuestionnaireService
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAnswers = $request->session()->get('survey.user-answers');
        $unanswered = $this->userQuestionnaireService->doCheckUnanswered($userAnswers);

        if ($unanswered->isNotEmpty()) {
            return Redirect::route('questionnaire.take', $unanswered->first()['index'])
                ->with('warning', 'Please fill up missing values before proceeding.');
        }

        return $next($request);
    }
}
