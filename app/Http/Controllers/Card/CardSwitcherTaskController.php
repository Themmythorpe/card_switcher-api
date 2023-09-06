<?php

namespace App\Http\Controllers\Card;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\User;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\CardSwitcherTask;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CardSwitcherTaskController extends Controller
{
    /**
     * Create a new Card Switcher task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTask(Request $request)
    {
        $request->validate([
            'card_id' => 'required|exists:cards,id',
            'merchant_id' => 'required|exists:merchants,id',
        ]);

       // Store the previous Card ID used in the merchant for the user (if not the first time)
       $previousCardId = CardSwitcherTask::where([
                                    'user_id' => Auth::id(),
                                'merchant_id' => $request->input('merchant_id')
                                ])->latest('created_at')
                                ->value('card_id');

        $task =  CardSwitcherTask::create([
            'user_id' => Auth::id(),
            'card_id' => $request->input('card_id'),
            'merchant_id' => $request->input('merchant_id'),
            'previous_card_id' => $previousCardId,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Card switched succesfully', 'data' => $task ], 201); // Return the created task with a 201 status code
    }

    /**
     * Mark a Card Switcher task as finished.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markTaskAsFinished($taskId)
    {
        // Find the task by ID
        $task = CardSwitcherTask::findOrFail($taskId);

        // mark the task as finished here
        $task->status = 'finished';
        $task->finished_at = Carbon::now();

        $task->save();

        return response()->json(['message' => 'Task marked as finished', 'data' => $task ], 200);
    }


    /**
     * Mark a Card Switcher task as failed.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markTaskAsFailed($taskId)
    {
        // Find the task by ID
        $task = CardSwitcherTask::findOrFail($taskId);

        // mark the task as failed here

        $task->status = 'failed';
        $task->failed_at = Carbon::now();
        $task->save();

        return response()->json(['message' => 'Task marked as failed', 'data' => $task ], 200);
    }

    public function latestFinishedTasks($userId)
    {
        // Find the user by ID (you can add validation or error handling as needed)
        $user = User::findOrFail($userId);

        // Query to retrieve the latest finished tasks for each merchant
        $latestTasks = DB::table('card_switcher_tasks')
            ->select('merchants.name as merchant_name', 'cards.card_number as card_used')
            ->join('merchants', 'card_switcher_tasks.merchant_id', '=', 'merchants.id')
            ->join('cards', 'card_switcher_tasks.card_id', '=', 'cards.id')
            ->where('card_switcher_tasks.user_id', $user->id)
            ->whereNotNull('card_switcher_tasks.finished_at') // Only finished tasks
            ->groupBy('merchants.name', 'cards.card_number')
            ->orderByDesc('card_switcher_tasks.finished_at')
            ->get();

        return response()->json(['message' => 'Latest Task fetched succesfully', 'data' => $latestTasks ]);
    }

}
