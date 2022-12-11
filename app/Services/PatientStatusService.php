<?php

namespace App\Services;

use Carbon\Carbon;

class PatientStatusService
{
    public static function checkHypertensionStatus($last12MonthsConsultations)
    {
        if ($last12MonthsConsultations->count() < 3) {
            return true;
        }

        $aboveThreshold = $last12MonthsConsultations->reverse()->search(function ($consultation) {
            return $consultation->systole >= 140 || $consultation->diastole >= 90;
        });

        if ($aboveThreshold !== false) {
            $filtered = $last12MonthsConsultations->reject(function ($value, $key) use ($aboveThreshold) {
                return $key <= $aboveThreshold;
            });
        } else {
            $filtered = $last12MonthsConsultations;
        }

        $grouped = $filtered->groupBy(function ($item) {
            return Carbon::createFromFormat('Y-m-d', $item->date)->format('Y-m');
        });

        if ($grouped->count() < 3) {
            return true;
        }

        $months = $grouped->keys();

        $counter = 1;

        for ($i = 0; $i < count($months) - 1; $i++) {
            $firstMonth = Carbon::parse($months[$i], 'UTC');
            $secondMonth = Carbon::parse($months[$i + 1], 'UTC');

            if ($firstMonth->diffInMonths($secondMonth) == 1) {
                $counter++;
            } else {
                $counter = 1;
            }

            if ($counter == 3) {
                return false;
            }
        }

        return true;
    }

    public static function checkTreatmentStatus($last12MonthsConsultations)
    {
        if ($last12MonthsConsultations->count() < 3) {
            return false;
        }

        $groupedConsultations = $last12MonthsConsultations->groupBy(function ($item) {
            return Carbon::createFromFormat('Y-m-d', $item->date)->format('Y-m');
        });

        $months = $groupedConsultations->keys();

        $counter = 1;

        for ($i = 0; $i < count($months) - 1; $i++) {
            $firstMonth = Carbon::parse($months[$i], 'UTC');
            $secondMonth = Carbon::parse($months[$i + 1], 'UTC');

            if ($firstMonth->diffInMonths($secondMonth) == 1) {
                $counter++;
            } else {
                $counter = 1;
            }

            if ($counter == 3) {
                return true;
            }
        }

        return false;
    }
}
