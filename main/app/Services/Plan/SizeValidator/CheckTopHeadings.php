<?php

namespace App\Services\Plan\SizeValidator;

use App\Constants\Plan\Heading;

class CheckTopHeadings
{
    /**
     * @param array $data
     * @return array
     */
    public function differences(array $data): array
    {
        $result = [];
        [$totalFromLength, $totalToLength] = $this->getTotalLength($data);
        if ($totalFromLength > $data['sizes']['from']) {
            $result['plan.sizes.from'] = 'min:' . $totalFromLength;
        }
        if ($totalToLength > $data['sizes']['to']) {
            $result['plan.sizes.to'] = 'min:' . $totalToLength;
        }
        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    private function getTotalLength(array $data): array
    {
        $from = 0;
        $to = 0;
        if (key_exists('openingBlock', $data)) {
            $from += $data['openingBlock']['sizes']['from'];
            $to += $data['openingBlock']['sizes']['to'];
        }
        if (key_exists('closingBlock', $data)) {
            $from += $data['closingBlock']['sizes']['from'];
            $to += $data['closingBlock']['sizes']['to'];
        }
        foreach ($data['blocks'] ?? [] as $block) {
            if ($block['heading'] === Heading::H2) {
                $from += $block['sizes']['from'];
                $to += $block['sizes']['to'];
            }
        }
        return [$from, $to];
    }
}
