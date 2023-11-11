<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Chat;
use Illuminate\Http\Response;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Requests\ChatByOpenAI\ChatByOpenAIRequest;

class OpenAIController extends Controller {

    /**
     * @OA\Post(
     *      path="/api/v1/chat",
     *      summary="Chat By Open AI",
     *      description="Chat By Open AI",
     *      operationId="chatByOpenAI",
     *      tags={"Chat By Open AI"},
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Credentials",
     *          @OA\JsonContent(
     *              required={"chat"},
     *              @OA\Property(property="chat", type="string", example="Hello"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Hello! How can I assist you today?")
     *         )
     * )
     */

    public function chatByOpenAI(ChatByOpenAIRequest $request) {
        return $request->saveRequest();
    }

    /**
     * @OA\Post(
     *      path="/api/v1/chat-histories",
     *      summary="Chat Histories",
     *      description="Chat Histories",
     *      operationId="chatByOpenAI",
     *      tags={"chatHistories"},
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Chat histories")
     *         )
     * )
     */

    public function chatHistories() {
        $chats    = Chat::where('user_id', auth()->id())->latest()->get();
        $response = [
            'message' => "Chat Histories",
            'chats'   => ChatResource::collection(@$chats),
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
