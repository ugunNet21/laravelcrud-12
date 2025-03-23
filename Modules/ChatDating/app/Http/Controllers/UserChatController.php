<?php
namespace Modules\ChatDating\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\ChatDating\app\Http\Requests\StoreUserChatRequest;
use Modules\ChatDating\app\Http\Requests\UpdateUserChatRequest;
use Modules\ChatDating\app\Models\UserChat;
use Modules\ChatDating\app\Services\UserChatService;

class UserChatController extends Controller
{
    protected $userChatService;
    public function __construct(UserChatService $userChatService)
    {
        $this->userChatService = $userChatService;
    }
    /**
     * Display a listing of the resource.
     */
    public function getPageindex()
    {
        return view('chatdating::index');
    }
    public function index()
    {
        $users = $this->userChatService->getAllUsers();
        return response()->json($users);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function getPagecreate()
    {
        return view('chatdating::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserChatRequest $request)
    {
        $user = $this->userChatService->createUser($request->validated());
        return response()->json($user, 201);
    }

    /**
     * Show the specified resource.
     */
    public function getPageshow(UserChat $id)
    {
        return view('chatdating::show');
        // return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getPageedit($id)
    {
        return view('chatdating::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserChatRequest $request, UserChat $user)
    {
        $user = $this->userChatService->updateUser($user, $request->validated());
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(UserChat $user)
    {
        $this->userChatService->deleteUser($user);
        return response()->json(null, 204);
    }
}
