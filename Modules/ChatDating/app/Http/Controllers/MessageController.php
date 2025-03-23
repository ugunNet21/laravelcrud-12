<?php
namespace Modules\ChatDating\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\ChatDating\app\Http\Requests\StoreMessageRequest;
use Modules\ChatDating\app\Http\Requests\UpdateMessageRequest;
use Modules\ChatDating\app\Models\Message;
use Modules\ChatDating\app\Services\MessageService;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index()
    {
        $messages = $this->messageService->getAllMessages();
        return response()->json($messages);
    }

    public function store(StoreMessageRequest $request)
    {
        $message = $this->messageService->createMessage($request->validated());
        return response()->json($message, 201);
    }

    public function show(Message $message)
    {
        return response()->json($message);
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        $message = $this->messageService->updateMessage($message, $request->validated());
        return response()->json($message);
    }

    public function destroy(Message $message)
    {
        $this->messageService->deleteMessage($message);
        return response()->json(null, 204);
    }
}
