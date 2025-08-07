<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailLog;

class NotificationController extends Controller
{
    public function index()
    {
        $logs = EmailLog::latest()->paginate(10);

        return view('admin.notifications', compact('logs'));
    }
}
