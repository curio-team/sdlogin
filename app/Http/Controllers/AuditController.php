<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = Audit::with('user')->latest();

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('model')) {
            $query->where('auditable_type', $request->model);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $audits = $query->paginate(request('n', 25));

        $modelTypes = Audit::distinct()->pluck('auditable_type')->sort()->values();
        $events = Audit::distinct()->pluck('event')->sort()->values();

        return view('audits.index', compact('audits', 'modelTypes', 'events'));
    }

    public function show(Audit $audit)
    {
        $audit->load('user');
        return view('audits.show', compact('audit'));
    }
}
