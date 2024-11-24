<?php

namespace App\Console\Commands;

use App\Mail\BookRequestMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:testemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'khaledatef312@gmail.com'; // Set the recipient's email address
        Mail::to($email)->send(new BookRequestMail());

        $this->info('Test email sent successfully!');
    }
}
