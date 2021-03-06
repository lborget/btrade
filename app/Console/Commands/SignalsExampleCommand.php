<?php
namespace btrade\Console\Commands;

use btrade\Console\Kernel;
use btrade\Traits\Signals;
use btrade\Traits\OHLC;
use Illuminate\Console\Command;
use btrade\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use AndreasGlaser\PPC\PPC; // https://github.com/andreas-glaser/poloniex-php-client

/**
 * Class ExampleCommand
 * @package btrade\Console\Commands
 */
class SignalsExampleCommand extends Command {

    use Signals, OHLC;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'btrade:example_signals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forex signals example';


    public function doColor($val)
    {
        if ($val == 0){ return 'none'; }
        if ($val == 1){ return 'green'; }
        if ($val == -1){ return 'magenta'; }
        return 'none';
    }

    /**
     * @return null
     *
     *  this is the part of the command that executes.
     */
    public function handle()
    {
        echo "PRESS 'q' TO QUIT AND CLOSE ALL POSITIONS\n\n\n";
        stream_set_blocking(STDIN, 0);

        while(1){
			$instruments = ['BTC/USD'];
			
			$util        = new Util\BrokersUtil();
			$console     = new \btrade\Util\Console();
			$indicators  = new \btrade\Util\Indicators();

			$this->signals(false, false, $instruments);

			$back = $this->signals(1,2, $instruments);
			print_r($back);

			sleep(5);
		}


        return null;
    }


}
