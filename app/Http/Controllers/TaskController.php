<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class TaskController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::id(),
                'status' => 'Pending',
                'assigned_by' => null,
            ]);

            return back()->with('success', 'Task created successfully.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Task creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create task. Please try again.');
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            $request->validate([
                'status' => 'required|in:Pending,Done,finish',
            ]);

            if (Auth::guard('admin')->check()) {
                if (!$task->assigned_by || $task->status == 'Done') {
                    return back()->with('error', 'You cannot update this task.');
                }
            } else {
                if ($task->assigned_by || $task->user_id != Auth::id()) {
                    return back()->with('error', 'You cannot update this task.');
                }
            }

            $task->update([
                'status' => $request->status,
            ]);

            return back()->with('success', 'Task status updated successfully.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            Log::error('Task not found: ' . $e->getMessage());
            return back()->with('error', 'Task not found.');
        } catch (\Exception $e) {
            Log::error('Task update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update task. Please try again.');
        }
    }

    public function comment(Task $task)
    {
        try {
            return view('tasks.comment', compact('task'));
        } catch (ModelNotFoundException $e) {
            Log::error('Task not found for comment: ' . $e->getMessage());
            return back()->with('error', 'Task not found.');
        } catch (\Exception $e) {
            Log::error('Comment page error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load comment page.');
        }
    }

    public function storeComment(Request $request, Task $task)
    {
        try {
            $request->validate([
                'comment' => 'required|string'
            ]);

            $task->comments()->create([
                'user_id' => Auth::id(),
                'comment' => $request->comment
            ]);

            return back()->with('success', 'Comment added successfully.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            Log::error('Task not found for comment: ' . $e->getMessage());
            return back()->with('error', 'Task not found.');
        } catch (\Exception $e) {
            Log::error('Comment store error: ' . $e->getMessage());
            return back()->with('error', 'Failed to add comment. Please try again.');
        }
    }
}
