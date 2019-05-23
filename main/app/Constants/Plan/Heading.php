<?php

namespace App\Constants\Plan;

class Heading
{
    const OPENING = '0';

    const H2 = '2';

    const H3 = '3';

    const H4 = '4';

    const H5 = '5';

    const H6 = '6';

    const CLOSING = '-1';

    const ALL = [
        self::H2,
        self::H3,
        self::H4,
        self::H5,
        self::H6
    ];

    /**
     * @return array
     */
    public static function getConfig(): array
    {
        return [
            'sequence' => [
                self::OPENING => [
                    'all' => [
                        self::H2 => __('plan.heading.' . self::H2)
                    ],
                    'next' => null
                ],
                self::H2 => [
                    'all' => [
                        self::H2 => __('plan.heading.' . self::H2),
                        self::H3 => __('plan.heading.' . self::H3)
                    ],
                    'next' => self::H3
                ],
                self::H3 => [
                    'all' => [
                        self::H2 => __('plan.heading.' . self::H2),
                        self::H3 => __('plan.heading.' . self::H3),
                        self::H4 => __('plan.heading.' . self::H4)
                    ],
                    'next' => self::H4
                ],
                self::H4 => [
                    'all' => [
                        self::H2 => __('plan.heading.' . self::H2),
                        self::H3 => __('plan.heading.' . self::H3),
                        self::H4 => __('plan.heading.' . self::H4),
                        self::H5 => __('plan.heading.' . self::H5)
                    ],
                    'next' => self::H5
                ],
                self::H5 => [
                    'all' => [
                        self::H2 => __('plan.heading.' . self::H2),
                        self::H3 => __('plan.heading.' . self::H3),
                        self::H4 => __('plan.heading.' . self::H4),
                        self::H5 => __('plan.heading.' . self::H5),
                        self::H6 => __('plan.heading.' . self::H6)
                    ],
                    'next' => self::H6
                ],
                self::H6 => [
                    'all' => [
                        self::H2 => __('plan.heading.' . self::H2),
                        self::H3 => __('plan.heading.' . self::H3),
                        self::H4 => __('plan.heading.' . self::H4),
                        self::H5 => __('plan.heading.' . self::H5),
                        self::H6 => __('plan.heading.' . self::H6)
                    ],
                    'next' => null
                ]
            ],
            'opening' => self::OPENING,
            'closing' => self::CLOSING
        ];
    }

    /**
     * @return array
     */
    public static function getShortConfig(): array
    {
        return [
            'sequence' => [
                self::H2 => self::H3,
                self::H3 => self::H4,
                self::H4 => self::H5,
                self::H5 => self::H6,
                self::H6 => null
            ],
            'opening' => self::OPENING,
            'closing' => self::CLOSING
        ];
    }
}
