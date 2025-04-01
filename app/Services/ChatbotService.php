<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ChatbotService
{
    protected $knowledgeBase;

    protected $conversationContext;

    public function __construct()
    {
        // Load knowledge base from JSON file
        $this->knowledgeBase = $this->loadKnowledgeBase();

        // Initialize conversation context
        $this->resetContext();
    }

    protected function loadKnowledgeBase()
    {
        $path = storage_path('app/chatbot_knowledge_base.json');

        if (! File::exists($path)) {
            // Create a default knowledge base if not exists
            $defaultKnowledgeBase = [
                [
                    'topic' => 'Admission',
                    'questions' => [
                        'how to apply',
                        'admission process',
                        'application requirements',
                    ],
                    'response' => 'To apply to PSU, follow these steps:
1. Complete the online application form
2. Prepare required documents
3. Submit all materials before the deadline',
                ],
            ];

            File::put($path, json_encode($defaultKnowledgeBase, JSON_PRETTY_PRINT));
        }

        return json_decode(File::get($path), true);
    }

    protected function resetContext()
    {
        $this->conversationContext = [
            'current_topic' => null,
            'previous_queries' => [],
            'confidence_threshold' => 0.6,
        ];
    }

    protected function calculateSimilarity($query, $possibleMatch)
    {
        // Simple similarity calculation
        $query = strtolower($query);
        $matchScore = 0;

        foreach ($possibleMatch['questions'] as $possibleQuestion) {
            $possibleQuestion = strtolower($possibleQuestion);

            // Calculate word overlap
            $queryWords = explode(' ', $query);
            $matchWords = explode(' ', $possibleQuestion);

            $commonWords = array_intersect($queryWords, $matchWords);
            $similarityRatio = count($commonWords) / max(count($queryWords), count($matchWords));

            $matchScore = max($matchScore, $similarityRatio);
        }

        return $matchScore;
    }

    public function processQuery($query)
    {
        // Trim and normalize query
        $query = trim(strtolower($query));

        // Find best match
        $bestMatch = null;
        $highestSimilarity = 0;

        foreach ($this->knowledgeBase as $entry) {
            $similarity = $this->calculateSimilarity($query, $entry);

            if ($similarity > $highestSimilarity && $similarity > $this->conversationContext['confidence_threshold']) {
                $bestMatch = $entry;
                $highestSimilarity = $similarity;
            }
        }

        // Prepare response
        if ($bestMatch) {
            // Update conversation context
            $this->conversationContext['previous_queries'][] = $query;
            $this->conversationContext['current_topic'] = $bestMatch['topic'];

            // Confidence-based response
            $confidenceMessage = $highestSimilarity >= 0.8
                ? ''
                : sprintf('(Confidence: %.2f%%)', $highestSimilarity * 100);

            return trim($bestMatch['response']."\n\n".$confidenceMessage);
        }

        // Fallback responses
        $fallbackResponses = [
            "I couldn't find a precise answer. Could you rephrase or be more specific?",
            'This query is a bit unclear. Can you provide more context?',
            "I'm still learning. Could you help me understand your question better?",
        ];

        return $fallbackResponses[array_rand($fallbackResponses)];
    }

    // Method to update knowledge base
    public function updateKnowledgeBase($newEntries)
    {
        $this->knowledgeBase = array_merge($this->knowledgeBase, $newEntries);

        // Persist to file
        File::put(
            storage_path('app/chatbot_knowledge_base.json'),
            json_encode($this->knowledgeBase, JSON_PRETTY_PRINT)
        );
    }
}
