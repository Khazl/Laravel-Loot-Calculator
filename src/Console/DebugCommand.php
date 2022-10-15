<?php

namespace Khazl\LootCalculator\Console;

use Illuminate\Console\Command;
use Khazl\LootCalculator\Examples\CoinToss;
use Khazl\LootCalculator\Examples\DiceRoll;
use Khazl\LootCalculator\Examples\WolfLoot;
use Throwable;

class DebugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loot-calculator:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs code to debug things ...';

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
     */
    public function handle()
    {
        $this->line('--- DEBUG START ---');

        $this->line('--- Coin Toss ---');
        $coin = new CoinToss();
        $this->info($coin->flip());

        $this->line('--- Wolf Loot ---');
        $wolf = new WolfLoot();
        $this->info(json_encode($wolf->loot()));

        $this->line('--- Dice Roll ---');
        $dice = new DiceRoll();
        $this->info($dice->roll());

        $this->line('--- DEBUG START ---');
    }

}
