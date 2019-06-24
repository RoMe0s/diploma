<?php

namespace App\Constants\Check;

class Available
{
//    const USES_KEYWORDS_IN_TITLES = 'UsesKeywordsInTitles';

    const DISALLOW_TITLE_3_NEXT_TO_TITLE_2 = 'DisallowTitle3NextToTitle2';

    const MINIMUM_NUMBER_OF_LETTERS_IN_THE_TITLE = 'MinimumNumberOfLettersInTheTitle';

    const MAXIMUM_NUMBER_OF_LETTERS_IN_THE_TITLE = 'MaximumNumberOfLettersInTheTitle';

    const MINIMUM_NUMBER_OF_LETTERS_IN_THE_PARAGRAPH = 'MinimumNumberOfLettersInTheParagraph';

    const MAXIMUM_NUMBER_OF_LETTERS_IN_THE_PARAGRAPH = 'MaximumNumberOfLettersInTheParagraph';

    const SEQUENCE = [
        // GLOBAL
//        self::USES_KEYWORDS_IN_TITLES,
        self::DISALLOW_TITLE_3_NEXT_TO_TITLE_2,
        // TITLE
        self::MINIMUM_NUMBER_OF_LETTERS_IN_THE_TITLE,
        self::MAXIMUM_NUMBER_OF_LETTERS_IN_THE_TITLE,
        // PARAGRAPHS
        self::MINIMUM_NUMBER_OF_LETTERS_IN_THE_PARAGRAPH,
        self::MAXIMUM_NUMBER_OF_LETTERS_IN_THE_PARAGRAPH
    ];
}
