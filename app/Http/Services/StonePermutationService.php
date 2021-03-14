<?php

namespace App\Http\Services;

use App\Jobs\ProcessPermutationRecords;
use App\Model\StonePermutation;

/**
 * StonePermutationService
 */
class StonePermutationService
{
    /**
     * stonePermutation
     *
     * @var mixed
     */
    protected $stonePermutation;
    /**
     * permutation
     *
     * @var array
     */
    protected $permutation = [];
    /**
     * @var string
     */
    protected const STONE = 'diamond';
    /**
     * @var string
     */
    protected const LABNAME = 'gia';

    /**
     * @var array
     */
    protected const SHAPE = ['round', 'square', 'rectangle', 'cushion'];
    /**
     * @var array
     */
    protected const SIZE = [
        '0.2000-0.2499', '0.2500-0.2999', '0.3000-0.3499', '0.3500-0.3999',
        '0.4000-0.4499', '0.4500-0.4999', '0.5000-0.5499', '0.5500-0.5999',
        '0.6000-0.6499', '0.6500-0.6999', '0.7000-0.7499', '0.7500-0.7999',
        '0.8000-0.8499', '0.8500-0.8999', '0.9000-0.9499', '0.9500-0.9999'
    ];

    /**
     * @var array
     */
    protected const COLOR = [
        'a' => 'a',
        'b' => 'a-b',
        'c' => 'a-b-c',
        'd' => 'a-b-c-d',
        'e' => 'a-b-c-d-e',
        'f' => 'a-b-c-d-e-f',
        'g' => 'a-b-c-d-e-f-g',
        'h' => 'a-b-c-d-e-f-g-h',
        'i' => 'a-b-c-d-e-f-g-h-i'
    ];

    protected const QUALITY = [
        'a1' => 'a1',
        'a2' => 'a1-a2',
        'b1' => 'a1-a2-b1',
        'b2' => 'a1-a2-b1-b2',
        'c1' => 'a1-a2-b1-b2-c1',
        'c2' => 'a1-a2-b1-b2-c1-c2',
        'd1' => 'a1-a2-b1-b2-c1-c2-d1',
        'd2' => 'a1-a2-b1-b2-c1-c2-d1-d2',
        'e1' => 'a1-a2-b1-b2-c1-c2-d1-d2-e1'
    ];

    protected const CUT = [
        'ideal' => 'ideal',
        'excellent' => 'ideal-excellent',
        'good' => 'ideal-excellent-good',
        'fair' => 'ideal-excellent-good-fair',
        'poor' => 'ideal-excellent-good-fair-poor',
    ];

    protected const POLISH = [
        'ideal' => 'ideal',
        'excellent' => 'ideal-excellent',
        'good' => 'ideal-excellent-good',
        'fair' => 'ideal-excellent-good-fair',
        'poor' => 'ideal-excellent-good-fair-poor',
    ];

    protected const RADIATION = [
        'none' => 'none',
        'slight' => 'none-slight',
        'faint' => 'none-slight-faint',
        'medium' => 'none-slight-faint-medium',
        'strong' => 'none-slight-faint-medium-strong',
        'extreme' => 'none-slight-faint-medium-strong-extreme',
    ];

    /**
     * @var string
     */
    protected const LAB = 'gia';

    /**
     * __construct
     *
     * @param  mixed $stonePermutation
     */
    public function __construct(StonePermutation $stonePermutation)
    {
        $this->stonePermutation = $stonePermutation;
    }

    /**
     * create
     *
     */
    public function create()
    {
        foreach (self::SHAPE as $shape) {
            $this->createSize($shape);
        }
    }

    /**
     * createSize
     *
     * @param  mixed $shape
     */
    public function createSize(string $shape)
    {
        foreach (self::SIZE as $size) {
            $this->createColor($shape, $size);
        }
    }

    /**
     * createColor
     *
     * @param  mixed $shape
     * @param  mixed $size
     */
    public function createColor(string $shape, string $size)
    {
        foreach (array_flip(self::COLOR) as $color) {
            $this->createQualities($shape, $size, $color);
            ProcessPermutationRecords::dispatch($this->permutation);
            unset($this->permutation);
        }
    }

    /**
     * createQualities
     *
     * @param  mixed $shape
     * @param  mixed $size
     * @param  mixed $color
     */
    public function createQualities(string $shape, string $size, string $color)
    {
        foreach (array_flip(self::QUALITY) as $quality) {
            $this->createCuts($shape, $size, $color, $quality);
        }
    }

    /**
     * createCuts
     *
     * @param  mixed $shape
     * @param  mixed $size
     * @param  mixed $color
     * @param  mixed $quality
     */
    public function createCuts(string $shape, string $size, string $color, string $quality)
    {
        foreach (array_flip(self::CUT) as $cut) {
            $this->createPolish($shape, $size, $color, $quality, $cut);
        }
    }

    /**
     * createPolish
     *
     * @param  mixed $shape
     * @param  mixed $size
     * @param  mixed $color
     * @param  mixed $quality
     * @param  mixed $cut
     */
    public function createPolish(string $shape, string $size, string $color, string $quality, string $cut)
    {
        foreach (array_flip(self::POLISH) as $polish) {
            $this->createRadiation($shape, $size, $color, $quality, $cut, $polish);
        }
    }

    /**
     * createRadiation
     *
     */
    public function createRadiation(
        string $shape,
        string $size,
        string $color,
        string $quality,
        string $cut,
        string $polish
    ) {
        foreach (array_flip(self::RADIATION) as $radiation) {
            $this->permutation[] = [
                'stone' => self::STONE,
                'shape' => $shape,
                'size' => $size,
                'color' => $color,
                'quality' => $quality,
                'cut' => $cut,
                'polish' => $polish,
                'radiation' => $radiation,
                'lab' => self::LABNAME,
            ];
        }

        return $this->permutation;
    }
}
