<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use App\Models\LogActivity as LogActivityModel;


class LogActivity
{
    public static function addToLog($subject='ไม่ระบุ', $description='-')
    {
        $user = auth()->check() ? auth()->user()->id : null;
        $username = auth()->check() ? auth()->user()->name : "ไม่ทราบชื่อ";
        $log = [];
        $log['subject'] = $subject;
        $log['description'] = $username . " " .  $description;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = $user;
        LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }
}
