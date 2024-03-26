<?php

namespace App\Services\Order;

use Illuminate\Support\Carbon;
use App\Models\TimeSlots as ModelTimeSlots;
class TimeSlots
{
    /**
     * @param $date
     * @return array
     */
    public function slotTimes($date): array
    {
        $carbonDay = Carbon::create($date . date('H:i'));
        $model = ModelTimeSlots::where('is_active', true)->first();
        $slots = [];
        foreach ($model->slots as $key => $value) {
            $slots[] = $value['Слот'];
        }

        if ($carbonDay->format('Y-m-d') !== Carbon::now()->format('Y-m-d')) {
            return $slots;
        } else {
            $start = $carbonDay->addHour()->roundHour()->format('H:i');
            foreach ($slots as $key => $slot) {
                $item = explode('-', $slot);
                if (!empty($item[1])) {
                    if (strtotime($start) > strtotime($item[0])
                        && strtotime($start) > strtotime($item[1])) {
                        unset($slots[$key]);
                    }
                } else {
                    if (strtotime($start) > strtotime($item[0])) {
                        unset($slots[$key]);
                    }
                }

            }
            return array_values($slots);
        }
    }

    /**
     * @param $date
     * @return mixed|void
     */
    public function slotTimeRange($date)
    {
        $carbonDay = Carbon::parse($date)->roundHour()->format('H:i');
        $model = ModelTimeSlots::where('is_active', true)->first();
        $slots = [];
        foreach ($model->slots as $value) {
            $slots[] = $value['Слот'];
        }

        if (count(explode('-', $slots[0])) >! 1) {
            $result = array_search($carbonDay, $slots);
            return $slots[$result];
        }

        foreach ($slots as $slot) {
            list($startTime, $endTime) = explode('-', $slot);
            if ($carbonDay >= $startTime && $carbonDay < $endTime) {
                return $slot;
            }
        }
    }
}
