<?php

namespace App\Constants\Check;

/*
==================================
                Order:
                Назва
                Опис
Посилання з інфо. (окрема табличка)
==================================

==================================
        |Табличка "Плани"|
        ------------------
        Пункти від автора (bool)
        Об'єм тексту (int)
----------------------------------
        Об'єм першого абзацу (int, null)
        Перший абзац до плану (bool)
----------------------------------
        |Табличка "Блоки"|
        ------------------
        Заголовок (int, null)
        Назва (varchar, null)
        Об'єм (int, null)
        Опис (varchar)
        Позиція (int)
----------------------------------
        |Табличка "Ключі"|
        ------------------
        Значення (varchar)
        К-сть (int)
        Тип (enum)
----------------------------------
        |Табличка "Обов'язкові елементи"|
        ------------------
        Тег (varchar)
        К-сть до (int)
        К-сть від (int)
----------------------------------
        Останній абзац після плану (bool)
        Об'єм останнього абзацу (int, null)
==================================
 */

class Available
{
    const ALLOWED_OVERHEAD = 'AllowedOverhead';

    const USES_KEYWORDS_IN_TITLES = 'UsesKeywordsInTitles';

    const DISALLOW_TITLE_3_NEXT_TO_TITLE_2 = 'DisallowTitle3NextToTitle2';

    const MINIMUM_NUMBER_OF_LETTERS_IN_THE_TITLE = 'MinimumNumberOfLettersInTheTitle';

    const MAXIMUM_NUMBER_OF_LETTERS_IN_THE_TITLE = 'MaximumNumberOfLettersInTheTitle';

    const MINIMUM_NUMBER_OF_LETTERS_IN_THE_DESCRIPTION = 'MinimumNumberOfLettersInTheDescription';

    const MAXIMUM_NUMBER_OF_LETTERS_IN_THE_DESCRIPTION = 'MaximumNumberOfLettersInTheDescription';

    const MINIMUM_NUMBER_OF_LETTERS_IN_THE_HEADER = 'MinimumNumberOfLettersInTheHeader';

    const MAXIMUM_NUMBER_OF_LETTERS_IN_THE_HEADER = 'MaximumNumberOfLettersInTheHeader';

    const MINIMUM_NUMBER_OF_LETTERS_IN_THE_PARAGRAPH = 'MinimumNumberOfLettersInTheParagraph';

    const MAXIMUM_NUMBER_OF_LETTERS_IN_THE_PARAGRAPH = 'MaximumNumberOfLettersInTheParagraph';

    const SEQUENCE = [
        // GLOBAL
        self::ALLOWED_OVERHEAD,
        self::USES_KEYWORDS_IN_TITLES,
        self::DISALLOW_TITLE_3_NEXT_TO_TITLE_2,
        // TITLE
        self::MINIMUM_NUMBER_OF_LETTERS_IN_THE_TITLE,
        self::MAXIMUM_NUMBER_OF_LETTERS_IN_THE_TITLE,
        // DESCRIPTION
        self::MINIMUM_NUMBER_OF_LETTERS_IN_THE_DESCRIPTION,
        self::MAXIMUM_NUMBER_OF_LETTERS_IN_THE_DESCRIPTION,
        // PARAGRAPHS
        self::MINIMUM_NUMBER_OF_LETTERS_IN_THE_PARAGRAPH,
        self::MAXIMUM_NUMBER_OF_LETTERS_IN_THE_PARAGRAPH
    ];
}
