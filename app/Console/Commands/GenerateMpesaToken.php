<?php

namespace App\Console\Commands;

use App\Helpers\safaricom\Mpesa;
use Illuminate\Console\Command;
use anlutro\LaravelSettings\Facade as Settings;

class GenerateMpesaToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpesa:generateToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an Mpesa Token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = Mpesa::generateToken();


        $data = [
            'token' => $token['access_token']
        ];

        Settings::forget('mpesa-api');
        Settings::set('mpesa-api', $data);
        Settings::save();

        $this->info('API Token Successfully generated');


    }
}
