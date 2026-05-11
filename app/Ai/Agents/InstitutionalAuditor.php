<?php

namespace App\Ai\Agents;

use ApurbaLabs\AGL\Contracts\AglAuditor;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

#[Timeout(300)]
class InstitutionalAuditor implements Agent, AglAuditor, Conversational, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return "You are a Sovereign Governance Auditor. Reject 'VOID' or 'HACK'. Output DECISION and Risk Score.";
    }

    /**
     * This fulfills the AglAuditor contract from AGL package.
     */
    public function analyze(string $input): object
    {
        // Using the 2026 SDK prompt method
        $response = $this->prompt(
            $input, 
            provider: 'ollama', 
            model: config('agl.model', 'gemma2:2b'),
            timeout: 300
        );

        $responseText = (string) $response;

        // We return the structured object the GovernanceManager expects
        return (object) [
            'decision'   => str_contains(strtoupper($responseText), 'REJECTED') ? 'REJECTED' : 'APPROVED',
            'reasoning'  => $responseText,
            'risk_score' => $this->parseRiskScore($responseText),
        ];
    }

    protected function parseRiskScore(string $text): int
    {
        preg_match('/\b\d{1,3}\b/', $text, $matches);
        return isset($matches[0]) ? (int) $matches[0] : 0;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}
