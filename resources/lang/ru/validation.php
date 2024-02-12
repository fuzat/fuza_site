<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits. Note that only numeric characters are accepted',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    // Custom Validation
    'noscript' => ':attribute не может содержать тег "script".',
    'noanytag' => ':attribute не может содержать символы "<", ">".',
    'line-error' => 'Line :line',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'exact' => 'The :attribute is incorrect.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        // Applications
        'applications-name'               => 'имя',
        'applications-email'              => 'Эл. адрес',
        'applications-mobile'             => 'мобильный',
        'applications-company'            => 'Название компании',
        'applications-position'           => 'Позиция',
        'applications-company_location'   => 'Место работы',
        'applications-cv_file'            => 'CV файл',

        // BANNER
        'banners-name'          => 'имя',
        'banners-menu'          => 'Меню',
        'banners-post'          => 'Почта',
        'banners-file'          => 'Изображение для сайта',
        'banners-mobile_file'   => 'Изображение для мобильного',
        'banners-position'      => 'Позиция',
        'banners-slogan_1'      => 'лозунг 1',
        'banners-slogan_2'      => 'лозунг 2',

        // CAREER
        'businesses-name'                   => 'имя',
        'businesses-slug'                   => 'слизень',
        'businesses-content'                => 'содержание',
        'businesses-show-home'              => 'Показать в доме',
        'businesses-short-desc'             => 'Краткое описание',
        'businesses-our-products'           => 'Наши продукты',
        'businesses-scale-operation'        => 'Операция масштабирования',
        'businesses-development-strategy'   => 'Стратегия развития',
        'businesses-avatar'                 => 'Аватар',
        'businesses-file'                   => 'Образ',
        'businesses-icon'                   => 'Икона',
        'businesses-icon-act'               => 'Значок Активен',
        'businesses-file-home'              => 'Изображение в доме',
        'businesses-all-products-url'       => 'URL всех продуктов',
        'businesses-products-background'   => 'Фон продуктов',

        // Industry
        'industries-name' => 'имя',

        // Category
        'categories-name'  => 'имя',
        'categories-menu'  => 'Меню',

        // LOCATION
        'locations-name'    => 'имя',

        // JOB
        'jobs-name'             => 'имя',
        'jobs-file'             => 'Образ',
        'jobs-type'             => 'Тип вакансии',
        'jobs-level'            => 'Уровень работы',
        'jobs-salary'           => 'Оплата труда',
        'jobs-company'          => 'Компания',
        'jobs-industry'         => 'Промышленность',
        'jobs-industry.*'       => 'Промышленность',
        'jobs-location'         => 'Расположение работы',
        'jobs-location.*'       => 'Расположение работы',
        'jobs-experiences'      => 'опыт',
        'jobs-qualification'    => 'Квалификация',
        'jobs-deadline_apply'   => 'Крайний срок',
        'jobs-benefit'          => 'Пособие по работе',
        'jobs-description'      => 'Описание вакансии',
        'jobs-requirement'      => 'Требования для приема на работу',

        // CORE VALUE
        'core-values-name'      => 'имя',
        'core-values-avatar'    => 'Аватар',
        'core-values-file'      => 'Изображение синонимов',
        'core-values-file-how'  => 'Изображение как это сделать',
        'core-values-category'  => 'категория',
        'core-values-how'       => 'Как?',
        'core-values-who'       => 'Кто?',
        'core-values-what'      => 'Какая?',
        'core-values-where'     => 'Где?',
        'core-values-when'      => 'Когда?',

        // POSITION
        'tags-name'    => 'Тег',

        // POSITION
        'positions-name'    => 'имя',

        // MENU
        'menus-name'        => 'имя',
        'menus-type'        => 'Тип',
        'menus-parent_id'   => 'Корневое меню',

        // POST
        'posts-title'   => 'заглавие',
        'posts-slug'    => 'слизень',
        'posts-short-content' => 'Краткое содержание',
        'posts-content' => 'содержание',
        'posts-contact' => 'контакт',
        'posts-file'    => 'Образ',
        'posts-menu'    => 'Меню',
        'posts-type'    => 'Тип',
        'posts-page'    => 'страница',
        'posts-category'            => 'категория',
        'posts-seo_title'           => 'SEO название',
        'posts-seo_description'     => 'SEO описание',
        'posts-board-director'      => 'Совет директоров',
        'posts-core-value'          => 'основная ценность',
        'posts-milestone'           => 'Основные этапы',
        'posts-vision-mission'      => 'Видение - Миссия',

        // NEWS
        'news-name'             => 'заглавие',
        'news-slug'             => 'слизень',
        'news-file'             => 'Образ',
        'news-video'            => 'видео',
        'news-content'          => 'содержание',
        'news-category'         => 'категория',
        'news-seo_title'        => 'SEO название',
        'news-seo_description'  => 'SEO описание',
        'news-file-large'       => 'Большой файл',
        'news-file-big'         => 'Большое изображение',
        'news-carousel'         => 'Карусель изображений',
        'news-public_date'      => 'Публичная дата',

        // CAROUSEL
        'carousels-category'    => 'категория',
        'carousels-description' => 'Описание',
        'carousels-hover'       => 'зависать',

        // BOARD DIRECTOR
        'board-directors-name'          => 'имя',
        'board-directors-avatar'        => 'Аватар',
        'board-directors-position'      => 'Позиция',
        'board-directors-description-1' => 'Описание 1',
        'board-directors-description-2' => 'Описание 2',
        'board-directors-hover-1'       => 'зависать 1',
        'board-directors-hover-2'       => 'зависать 2',

        // MILESTONE
        'milestones-name'           => 'имя',
        'milestones-year'           => 'Год',
        'milestones-description'    => 'Описание',
        'milestones-hover'          => 'зависать',
        'milestones-file'           => 'Образ',

        // ROLE
//        'roles-name' => 'TỪ KHÓA',
//        'roles-display_name' => 'TÊN',
//        'roles-description' => 'MÔ TẢ',
//        'chosed_permissions' => 'PHÂN QUYỀN',
//        'chosed_permissions.*' => 'PHÂN QUYỀN',

        // PARTNER
        'partners-file' => 'Образ',
        'partners-name' => 'имя',
        'partners-url'  => 'Веб-сайт',

        // Global Presence
        'global-presence-name'      => 'имя',
        'global-presence-address'   => 'Адрес',

        // SETTING
        'settings-email'            => 'Эл. адрес',
        'settings-facebook-url'     => 'Facebook Url',
        'settings-linkedin-url'     => 'Linked Url',
        'settings-youtube-url'      => 'Youtube Url',
        'settings-hotline'          => 'Горячая линия',
        'settings-company-name'     => 'Название компании',
        'settings-logo-header'      => 'Заголовок логотипа',
        'settings-logo-footer'      => 'Логотип Нижний колонтитул',
        'settings-fax'              => 'факс',
        'settings-seo-title'        => 'Название SEO',
        'settings-seo-description'  => 'SEO описание',
        'settings-logo-footer-text' => 'Logo Footer Text',
        'settings-show-language'    => 'Show Languages',
        'settings-address'          => 'Address',

        // COMPANY
        'companies-email'           => 'Эл. адрес',
        'companies-name'            => 'имя',
        'companies-content'         => 'содержание',
        'companies-phone'           => 'Телефон',
        'companies-logo'            => 'логотип',
        'companies-working-time'    => 'Рабочее время',
        'companies-work-location'   => 'Расположение работы',
        'companies-city.*'          => 'город',
        'companies-address.*'       => 'Адрес',
        'companies-city'            => 'город',
        'companies-address'         => 'Адрес',

        // STAVIAN GROUP
        'groups-name' => 'Name',
        'groups-file' => 'File',

        // VISION - MISSION
        'vision-mission-name'           => 'имя',
        'vision-mission-content'        => 'содержание',
        'vision-mission-icon_active'    => 'Значок Активен',
        'vision-mission-icon_inactive'  => 'Значок неактивен',

        // Job Type
        'job-types-name' => 'имя',

        // Job Level
        'job-levels-name' => 'имя',

        // OTHER
        'slug'              => 'слизень',
        'status'            => 'Положение дел',
        'locale'            => 'язык',
        'email'             => 'Эл. адрес',
        'phone'             => 'Телефон',
        'headquarter'       => 'штаб-квартира',
        'on_top'            => 'Топ-лист',
        'hot_news'          => 'Горячие новости',
        'fullname'          => 'ФИО',
        'created_at'        => 'Создан в',
        'message'           => 'Сообщение',
        'sorting'           => 'Сортировка',
    ],
];
