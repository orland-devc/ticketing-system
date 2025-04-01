<?php

namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use App\Models\DataBank;
use App\Models\TicketCategory;
use App\Models\User;
use App\Services\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function chatbot()
    {
        $dataBanks = DataBank::all();
        $offices = User::where('role', 'Office')->get()->sortBy('name'); // Fetch office users
        $categories = TicketCategory::all();

        return view('chatbot-guest2', compact('dataBanks', 'offices', 'categories'));
    }

    public function handleMessage(Request $request)
    {
        $userMessage = $request->input('message');

        // Implement your chatbot logic here
        $chatbotResponse = $this->getChatbotReply($userMessage);

        // Save the message and response to the database
        $chatbotMessage = new ChatbotMessage();
        $chatbotMessage->user_message = $userMessage;
        $chatbotMessage->chatbot_response = $chatbotResponse;
        // Set any other necessary fields, such as user_id
        $chatbotMessage->save();

        return response()->json(['reply' => $chatbotResponse]);
    }

    private function getChatbotReply($message)
    {
        // Replace this with your actual chatbot logic
        // You can implement intent recognition, knowledge base lookup, etc.
        $knowledgeBase = [
            'What are the admission requirements?' => 'The admission requirements include...',
            'How can I register for classes?' => 'To register for classes, follow these steps...',
            // Add more entries to your knowledge base
        ];

        $lowercaseMessage = strtolower($message);
        foreach ($knowledgeBase as $question => $answer) {
            if (str_contains($lowercaseMessage, strtolower($question))) {
                return $answer;
            }
        }

        return 'Sorry, I could not understand your query. Please rephrase or contact our support team.';
    }

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function processMessage(Request $request)
    {
        $query = $request->input('message');

        $response = $this->chatbotService->processQuery($query);

        return response()->json([
            'message' => $response,
        ]);
    }
}
