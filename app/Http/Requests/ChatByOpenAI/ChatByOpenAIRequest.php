<?php

namespace App\Http\Requests\ChatByOpenAI;

use App\Models\Chat;
use Illuminate\Http\Response;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Foundation\Http\FormRequest;

class ChatByOpenAIRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'chat' => ['required', 'string'],
        ];
    }

    public function saveRequest() {
        try {
            $result = OpenAI::chat()->create([
                'model'    => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $this->chat],
                ],
            ]);

            $response = @$result->choices[0]->message->content;

            Chat::create([
                'user_id'  => auth()->id(),
                'chat'     => @$this->chat,
                'response' => @$response,
            ]);

            return response()->json(['message' => $response], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
