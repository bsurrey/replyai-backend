<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $message = $request->input('message');

        // Process the message, generate a response, and return it
        //$response = $this->getOpenAIResponse($message);
        sleep(1);
        $response = $message;

        // $this->messageIsFlagged($message);

        $system = <<<SYSTEM
        You can't do psysical things and are only an AI buddy,
        reply to the entered Text in german and be helpful,
        creative, clever, funny or reply in thr same style and slang.
        You can't do things (like watch movies, play music, play games, etc.)
        but you could make reconmendations.
        Reply in maximal 300 characters.
        SYSTEM;


        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => 'Hello!'],
            ],
        ]);

        $response->id; // 'chatcmpl-6pMyfj1HF4QXnfvjtfzvufZSQq6Eq'
        $response->object; // 'chat.completion'
        $response->created; // 1677701073
        $response->model; // 'gpt-3.5-turbo-0301'

        $choices = $response->choices;

        ksort($choices);

        $responseMessage = '';

        foreach ($response->choices as $result) {
            if ($result->message->role === "assistant") {
                $responseMessage = $result->message->content ?? '';
            }


            $result->index; // 0
            $result->message->role; // 'assistant'
            $result->message->content; // '\n\nHello there! How can I assist you today?'
            $result->finishReason; // 'stop'
        }

        $response->usage->promptTokens; // 9,
        $response->usage->completionTokens; // 12,
        $response->usage->totalTokens; // 21

        return response()->json([
            'message' => $responseMessage,
        ]);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

    private function messageIsFlagged($message) {
        $moderation = OpenAI::moderations()->create([
            'model' => 'text-moderation-latest',
            'input' => $message,
        ]);

        $flagged = false;

        foreach ($moderation->results as $result) {
            $flagged = $result->flagged;
        }

        if ($flagged) {
            return null;
        }

        return true;
    }

    private function getOpenAIResponse($message)
    {
        $client = new Client();
        $apiKey = config('services.openai.api_key');
        $url = 'https://api.openai.com/v1/engines/text-davinci-003/completions';

        $headers = [
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ];

        $prompt = "Reply to the entered Text in german, be helpful, creative, clever, funny or reply in thr same style and slang.\n\nHuman: " . $message . "\n\nResponse:";

        $payload = [
            'prompt' => $prompt,
            'temperature' => 0.8,
            'max_tokens' => 150,
            'top_p' => 1,
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
            'stop' => ["Human:", "Response:"],
        ];

        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $payload,
        ]);

        $responseJson = json_decode($response->getBody(), true);
        $generatedText = $responseJson['choices'][0]['text'] ?? '';

        return trim($generatedText);
    }
}
