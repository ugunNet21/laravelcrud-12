<?php
namespace Modules\ChatDating\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\ChatDating\app\Http\Requests\StoreFriendshipRequest;
use Modules\ChatDating\app\Http\Requests\UpdateFriendshipRequest;
use Modules\ChatDating\app\Models\Friendship;
use Modules\ChatDating\app\Services\FriendshipService;

class FriendshipController extends Controller
{
    protected $friendshipService;

    public function __construct(FriendshipService $friendshipService)
    {
        $this->friendshipService = $friendshipService;
    }

    public function index()
    {
        $friendships = $this->friendshipService->getAllFriendships();
        return response()->json($friendships);
    }

    public function store(StoreFriendshipRequest $request)
    {
        $friendship = $this->friendshipService->createFriendship($request->validated());
        return response()->json($friendship, 201);
    }

    public function show(Friendship $friendship)
    {
        return response()->json($friendship);
    }

    public function update(UpdateFriendshipRequest $request, Friendship $friendship)
    {
        $friendship = $this->friendshipService->updateFriendship($friendship, $request->validated());
        return response()->json($friendship);
    }

    public function destroy(Friendship $friendship)
    {
        $this->friendshipService->deleteFriendship($friendship);
        return response()->json(null, 204);
    }
}
