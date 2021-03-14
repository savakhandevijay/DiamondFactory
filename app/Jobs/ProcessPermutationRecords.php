<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessPermutationRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * timeout
     *
     * @var int
     */
    protected $timeout = 0;

    /**
     * permutation
     *
     * @var mixed
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        Storage::disk('local')->append('tmp/permutation.json', json_encode($this->data));
        unset($this->data);
    }
}
