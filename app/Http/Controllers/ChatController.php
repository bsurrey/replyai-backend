<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

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

        return response()->json([
            'message' => $response,
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
