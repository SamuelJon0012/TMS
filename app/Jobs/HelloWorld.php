<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HelloWorld implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $yourName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $yourName)
    {
        $this->yourName = $yourName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->yourName))
            return $this->fail('You need a name');

        if (is_numeric($this->yourName))
            throw new \Exception('Your name can\'t be a number');
        
        echo "Hello {$this->yourName}\n";
    }
}
