<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Posts;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostSummaryEmail;
class DailyPostEmail extends Command
{
    protected $signature = 'email:daily-post-summary';
    protected $description = 'Send daily summary email of active status posts from yesterday';
    public function handle()
    {
        $yesterday = Carbon::yesterday();
        $posts = Posts::whereDate('created_at', $yesterday)
            ->where('status', 1)
            ->latest()
            ->take(10)
            ->get();
        $users = User::where('type', '0')
        ->where('deleted_at', null)
        ->get();
        foreach ($users as $user) {
            $email = $user->email;
            Mail::to($email)->send(new PostSummaryEmail($posts));
            $this->info('Weekly report has been sent successfully');
        }
    }
}
