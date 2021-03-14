<?php

namespace App\Jobs;

use App\Model\StonePermutation;
use App\Model\StonePrice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class updateAvaragePriceForStoneJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * data
     *
     * @var mixed
     */
    protected $collection;

    /**
     * Create a new job instance.
     *
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * timeout
     *
     * @var int
     */
    protected $timeout = 0;

    /**
     * retry
     *
     * @var int
     */
    protected $retry = 2;

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        $processRecords = $this->collection->map(function ($permutation) {
            $prices = StonePrice::select('price')->where([
                'shape' => $permutation['shape'],
                'color' => $permutation['color'],
                'quality' => $permutation['quality'],
                'cut' => $permutation['cut'],
                'polish' => $permutation['polish'],
                'radiation' => $permutation['radiation'],
                'lab' => $permutation['lab'],
                'stone' => $permutation['stone']
            ])->where(function ($query) use ($permutation) {
                $stoneSize = explode('-', $permutation['size']);
                $query->where('size', '>=', $stoneSize[0])->where('size', '<', $stoneSize[1]);
            })->orderby('price', 'asc')->limit(10)->get();

            return array_merge($permutation, [
                'avg_price' => $prices->avg('price') ?? 0,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);
        });
        $this->insertPermutations($processRecords);
    }

    /**
     * updateStonePrice
     *
     * @param  mixed $price
     * @param  mixed $permutation
     */
    public function insertPermutations(Collection $permutations)
    {
        return StonePermutation::insert($permutations->toArray());
    }
}
