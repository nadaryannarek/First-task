<?php

namespace App\Services;

use Exception;

/**
 *
 */
class CalculateService
{
    /**
     * @var array
     */
    private array $users_history = [];

    /**
     * @throws Exception
     */
    public function calculate($row, $rate): string
    {
        $feeAmount = 0;
        $week = date('oW', strtotime($row[0]));

        if ($row["3"] == "withdraw" && $row[2] == "private") {
            if (isset($this->users_history[$row[1]]) && isset($this->users_history[$row[1]][$week])) {
                $old_value = $this->users_history[$row[1]][$week];
                $this->users_history[$row[1]][$week] += $row[4] / $rate;
                if ($old_value > 1000) {
                    $amount = $row[4] / $rate;
                } else {
                    $amount = $row[4] / $rate + $old_value > 1000 ? $row[4] / $rate + $old_value - 1000 : 0;
                }
            } else {
                $this->users_history[$row[1]][$week] = $row[4] / $rate;
                $amount = $this->users_history[$row[1]][$week] > 1000 ? $this->users_history[$row[1]][$week] - 1000 : 0;
            }
            $feeAmount = $amount * 0.3 / 100 * $rate;
        } elseif ($row["3"] == "withdraw" && $row[2] == "business") {
            $feeAmount = $row[4] / $rate * 0.5 / 100;
        } elseif ($row["3"] == "deposit") {
            $feeAmount = $row[4] / $rate * 0.03 / 100;
        }

        return round_up($feeAmount, 2);
    }
}
