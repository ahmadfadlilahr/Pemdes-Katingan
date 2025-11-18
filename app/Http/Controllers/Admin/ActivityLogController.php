<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by search (description)
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->action($request->action);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->byModel($request->model_type);
        }

        $logs = $query->paginate(20)->withQueryString();

        // Get filter options
        $users = User::select('id', 'name')->orderBy('name')->get();
        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');
        $modelTypes = ActivityLog::select('model_type')
            ->whereNotNull('model_type')
            ->distinct()
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->model_type,
                    'label' => class_basename($item->model_type),
                ];
            });

        return view('admin.activity-logs.index', compact('logs', 'users', 'actions', 'modelTypes'));
    }

    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');

        return view('admin.activity-logs.show', compact('activityLog'));
    }

    /**
     * Remove the specified activity log.
     */
    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()
            ->route('admin.activity-logs.index')
            ->with('success', 'Log aktivitas berhasil dihapus.');
    }

    /**
     * Remove multiple activity logs.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:activity_logs,id',
        ]);

        $count = ActivityLog::whereIn('id', $request->ids)->delete();

        return redirect()
            ->route('admin.activity-logs.index')
            ->with('success', "{$count} log aktivitas berhasil dihapus.");
    }

    /**
     * Clean old activity logs (older than 30 days).
     */
    public function clean()
    {
        $count = ActivityLog::deleteOlderThan(30);

        return redirect()
            ->route('admin.activity-logs.index')
            ->with('success', "{$count} log aktivitas lama berhasil dihapus.");
    }

    /**
     * Get activity log statistics.
     */
    public function statistics()
    {
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'this_week' => ActivityLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => ActivityLog::whereMonth('created_at', now()->month)->count(),
            'by_action' => ActivityLog::select('action', DB::raw('count(*) as count'))
                ->groupBy('action')
                ->orderBy('count', 'desc')
                ->get(),
            'by_user' => ActivityLog::select('user_id', DB::raw('count(*) as count'))
                ->whereNotNull('user_id')
                ->groupBy('user_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->with('user:id,name')
                ->get(),
        ];

        return response()->json($stats);
    }
}
