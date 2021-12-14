<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\members_extra_information;
use Carbon\Carbon;
class isSubscriptionExpirey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Subscription:Expirey';

    /**
     * The console command description.
     *
     * @var string
     */                       //بيتشك كل دقيقه لو في اشتراكات منتهيه يغير حالتها من مدفوعه الي منتهيه
    protected $description = 'If the subscription period is over, the subscription status will be changed from paid to expired dynamically';

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
     * @return int
     */
    public function handle()
    {

        $today = Carbon::now('Africa/Cairo')->toDateString();
        $membersWhereSubscriptionExpirey = members_extra_information::where('period_Expiry','=',$today)->get();

        foreach($membersWhereSubscriptionExpirey as $member){

            $member->update(['subscription_status' => 'expired']);

        }
    }
}
