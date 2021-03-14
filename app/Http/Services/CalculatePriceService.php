<?php

namespace App\Http\Services;

use App\Jobs\updateAvaragePriceForStoneJob;

class CalculatePriceService
{
    protected $permutation = [];
    protected $errors = [];

    /**
     * process
     *
     */
    public function getAll()
    {
        $this->readfile(storage_path('app/tmp/permutation.json'));

        return json_encode(['status' => true, 'message' => 'Job dispatched']);
    }

    /**
     * readfile
     *
     * @param  mixed $filePath
     */
    public function getFileBySteam(string $filePath)
    {
        $handle = fopen($filePath, 'r');
        // while ($line = fgets($handle)) {
        //     $linebreaks = array_filter(mb_split('\n', $line));
        //     foreach ($linebreaks as $json_data) {
        //         yield $json_data;
        //     }
        // }

        // fclose($handle);

        $chunkData = 2048 * 2048;
        while (!feof($handle)) {
            if (!empty($flines = stream_get_line($handle, $chunkData, "\n"))) {
                yield $flines;
            }
        }
        fclose($handle);
    }

    /**
     * readFile
     *
     * @param  mixed $filePath
     */
    public function readFile($filePath)
    {
        $data = [];
        foreach ($this->getFileBySteam($filePath) as $fdata) {
            $json_data = json_decode($fdata, true);
            try {
                $this->setErrors(json_last_error());
                $this->addToQueue($json_data);
            } catch (\Throwable $th) {
                return 'Invalid Json ' . $th->getMessage();
            }
        }

        return $data;
    }

    /**
     * setErrors
     *
     * @param  mixed $errorCode
     */
    public function setErrors(int $errorCode)
    {
        switch ($errorCode) {
            case JSON_ERROR_NONE: $errorMessage = null; break;
            case JSON_ERROR_DEPTH:$errorMessage = ' - Maximum stack depth exceeded'; break;
            case JSON_ERROR_STATE_MISMATCH:$errorMessage = ' - Underflow or the modes mismatch'; break;
            case JSON_ERROR_CTRL_CHAR:$errorMessage = ' - Unexpected control character found'; break;
            case JSON_ERROR_SYNTAX:$errorMessage = ' - Syntax error, malformed JSON'; break;
            case JSON_ERROR_UTF8:$errorMessage = ' - Malformed UTF-8 characters, possibly incorrectly encoded'; break; default:$errorMessage = ' - Unknown error'; break;
        }
        if ($errorCode != JSON_ERROR_NONE) {
            throw new \Exception('Error Processing Request :' . $errorMessage);
        }

        return ($errorCode != JSON_ERROR_NONE);
    }

    /**
     * addToQueue
     *
     * @param  mixed $fdata
     */
    public function addToQueue(array $fdata)
    {
        $chunkPermutations = array_chunk($fdata, 300);
        foreach ($chunkPermutations as $permutation) {
            updateAvaragePriceForStoneJob::dispatch(collect($permutation));
        }
    }
}
