<?php

namespace App\Services\Plan\SizeValidator;

use App\Constants\Plan\Heading;

class CheckSubHeadings
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * CheckSubHeadings constructor.
     */
    function __construct()
    {
        $this->configuration = Heading::getShortConfig();
    }

    /**
     * @param array $blocks
     * @return array
     */
    public function differences(array $blocks): array
    {
        $result = [];
        foreach ($blocks as $index => $block) {
            if ($childHeading = $this->getChildHeading($block['heading'])) {
                [$childrenFromLength, $childrenToLength] = $this->childrenLength($blocks, $index + 1, $childHeading);
                if ($childrenToLength > $block['sizes']['to']) {
                    $result["plan.blocks.$index.sizes.to"] = 'min:' . $childrenToLength;
                }
                if ($childrenFromLength > $block['sizes']['from']) {
                    $result["plan.blocks.$index.sizes.from"] = 'min:' . $childrenFromLength;
                }
            }
        }
        return $result;
    }

    /**
     * @param array $blocks
     * @param int $index
     * @param string $heading
     * @return array
     */
    private function childrenLength(array $blocks, int $index, string $heading): array
    {
        $from = 0;
        $to = 0;
        for (; $index < count($blocks); $index++) {
            if ($heading > $blocks[$index]['heading']) {
                break;
            }
            if ($heading === $blocks[$index]['heading']) {
                $from += $blocks[$index]['sizes']['from'];
                $to += $blocks[$index]['sizes']['to'];
            }
        }
        return [$from, $to];
    }

    /**
     * @param string $heading
     * @return string|null
     */
    private function getChildHeading(string $heading): ?string
    {
        return $this->configuration['sequence'][$heading] ?? null;
    }
}
