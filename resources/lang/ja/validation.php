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
        'ファイル'    => 'The :attribute must be between :min and :max kilobytes.',
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
    'Eメール'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'ファイル'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'ファイル'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'ファイル'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    '画像'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'ファイル'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'ファイル'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'ファイル'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'ファイル'    => 'The :attribute must be at least :min kilobytes.',
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
        'ファイル'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    // Custom Validation
    'noscript' => ':attribute に "script"タグを含めることはできません。',
    'noanytag' => ':attribute に文字 "<", ">"を含めることはできません。',
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
        'applications-name'               => '名前',
        'applications-email'              => 'Eメール',
        'applications-mobile'             => 'モバイル',
        'applications-company'            => '会社名',
        'applications-position'           => 'ポジション',
        'applications-company_location'   => '職場',
        'applications-cv_file'            => 'CVファイル',

        // BANNER
        'banners-name'          => '名前',
        'banners-menu'          => 'メニュー',
        'banners-post'          => '役職',
        'banners-file'          => 'ウェブサイトの画像',
        'banners-mobile_file'   => 'モバイル用の画像',
        'banners-position'      => 'ポジション',
        'banners-slogan_1'      => 'スローガン 1',
        'banners-slogan_2'      => 'スローガン 2',

        // CAREER
        'businesses-name'               => '名前',
        'businesses-slug'               => 'ナメクジ',
        'businesses-content'            => 'コンテンツ',
        'businesses-show-home'          => 'ホームで表示',
        'businesses-short-desc'         => '簡単な説明',
        'businesses-our-products'       => '当社の製品',
        'businesses-scale-operation'    => 'スケール操作',
        'businesses-development-strategy' => '開発戦略',
        'businesses-avatar'             => 'アバター',
        'businesses-file'               => '画像',
        'businesses-icon'               => 'アイコン',
        'businesses-icon-act'           => 'アクティブなアイコン',
        'businesses-file-home'          => 'ホームの画像',
        'businesses-all-products-url'   => 'すべての製品のURL',
        'businesses-products-background'   => '製品の背景',

        // Industry
        'industries-name' => '名前',

        // Category
        'categories-name'  => '名前',
        'categories-menu'  => 'メニュー',

        // LOCATION
        'locations-name'    => '名前',

        // JOB
        'jobs-name'             => '名前',
        'jobs-file'             => 'ファイル',
        'jobs-type'             => '職種',
        'jobs-level'            => '職務レベル',
        'jobs-salary'           => '給料',
        'jobs-company'          => '会社',
        'jobs-industry'         => '業界',
        'jobs-industry.*'       => '業界',
        'jobs-location'         => '勤務地',
        'jobs-location.*'       => '勤務地',
        'jobs-experiences'      => '体験',
        'jobs-qualification'    => '資格',
        'jobs-deadline_apply'   => '締め切り',
        'jobs-benefit'          => '仕事の利点',
        'jobs-description'      => '仕事内容',
        'jobs-requirement'      => '仕事の要件',

        // CORE VALUE
        'core-values-name'      => '名前',
        'core-values-avatar'    => 'アバター',
        'core-values-file'      => '同義語の画像',
        'core-values-file-how'  => '方法のイメージ',
        'core-values-category'  => 'カテゴリー',
        'core-values-how'       => 'どうやって？',
        'core-values-who'       => '誰？',
        'core-values-what'      => '何？',
        'core-values-where'     => 'どこ？',
        'core-values-when'      => 'いつ？',

        // POSITION
        'tags-name'    => '鬼ごっこ',

        // POSITION
        'positions-name'    => '名前',

        // MENU
        'menus-name'        => '名前',
        'menus-type'        => 'タイプ',
        'menus-parent_id'   => 'ルートメニュー',

        // POST
        'posts-title'           => 'Title',
        'posts-slug'            => 'ナメクジ',
        'posts-short-content'   => '短いコンテンツ',
        'posts-content'         => 'コンテンツ',
        'posts-contact'         => '連絡先',
        'posts-file'            => 'ファイル',
        'posts-menu'            => 'メニュー',
        'posts-type'            => 'タイプ',
        'posts-page'            => 'ページ',
        'posts-category'        => 'カテゴリー',
        'posts-seo_title'       => 'SEOタイトル',
        'posts-seo_description' => 'seoの説明',
        'posts-board-director'  => '取締役会',
        'posts-core-value'      => 'コア値',
        'posts-milestone'       => 'マイルストーン',
        'posts-vision-mission'      => 'ビジョンミッション',

        // NEWS
        'news-name'             => 'Title',
        'news-slug'             => 'ナメクジ',
        'news-file'             => 'ファイル',
        'news-video'            => 'Video',
        'news-content'          => 'コンテンツ',
        'news-category'         => 'カテゴリー',
        'news-seo_title'        => 'SEOタイトル',
        'news-seo_description'  => 'seoの説明',
        'news-file-large'       => '大きなファイル',
        'news-file-big'         => '大きな画像',
        'news-carousel'         => '画像カルーセル',
        'news-public_date'      => '公開日',

        // CAROUSEL
        'carousels-category'    => 'カテゴリー',
        'carousels-description' => '説明',
        'carousels-hover'       => 'ホバー',

        // BOARD DIRECTOR
        'board-directors-name'          => '名前',
        'board-directors-avatar'        => 'アバター',
        'board-directors-position'      => 'ポジション',
        'board-directors-description-1' => '説明 1',
        'board-directors-description-2' => '説明 2',
        'board-directors-hover-1'       => 'ホバー 1',
        'board-directors-hover-2'       => 'ホバー 2',

        // MILESTONE
        'milestones-name'           => '名前',
        'milestones-year'           => 'Year',
        'milestones-description'    => '説明',
        'milestones-hover'          => 'ホバー',
        'milestones-file'           => 'ファイル',

        // ROLE
//        'roles-name' => 'TỪ KHÓA',
//        'roles-display_name' => 'TÊN',
//        'roles-description' => 'MÔ TẢ',
//        'chosed_permissions' => 'PHÂN QUYỀN',
//        'chosed_permissions.*' => 'PHÂN QUYỀN',

        // PARTNER
        'partners-file' => '画像',
        'partners-name' => '名前',
        'partners-url'  => 'Url',

        // Global Presence
        'global-presence-name'      => '名前',
        'global-presence-address'   => '住所',

        // SETTING
        'settings-email'            => 'Eメール',
        'settings-facebook-url'     => 'Facebook Url',
        'settings-linkedin-url'     => 'Linked Url',
        'settings-youtube-url'      => 'Youtube Url',
        'settings-hotline'          => 'ホットライン',
        'settings-company-name'     => '会社名',
        'settings-logo-header'      => 'ロゴヘッダー',
        'settings-logo-footer'      => 'ロゴフッター',
        'settings-fax'              => 'ファックス',
        'settings-seo-title'        => 'SEO タイトル',
        'settings-seo-description'  => 'SEO の説明',
        'settings-logo-footer-text' => 'Logo Footer Text',
        'settings-show-language'    => 'Show Languages',
        'settings-address'          => 'Address',

        // COMPANY
        'companies-email'           => 'Eメール',
        'companies-name'            => '名前',
        'companies-content'         => 'コンテンツ',
        'companies-phone'           => '電話',
        'companies-logo'            => 'ロゴ',
        'companies-working-time'    => '労働時間',
        'companies-work-location'   => '勤務地',
        'companies-city.*'          => '市',
        'companies-address.*'       => '住所',
        'companies-city'            => '市',
        'companies-address'         => '住所',

        // STAVIAN GROUP
        'groups-name' => '名前',
        'groups-file' => 'ファイル',

        // VISION - MISSION
        'vision-mission-name'           => '名前',
        'vision-mission-content'        => 'コンテンツ',
        'vision-mission-icon_active'    => 'アクティブなアイコン',
        'vision-mission-icon_inactive'  => '非アクティブなアイコン',

        // Job Type
        'job-types-name' => '名前',

        // Job Level
        'job-levels-name' => '名前',

        // OTHER
        'slug'              => 'ナメクジ',
        'status'            => '状態',
        'locale'            => '言語',
        'Email'             => 'Eメール',
        'phone'             => '電話',
        'headquarter'       => '本部',
        'on_top'            => 'トップリスト',
        'hot_news'          => 'ホットニュース',
        'fullname'          => 'フルネーム',
        'created_at'        => 'で作成',
        'message'           => 'メッセージ',
        'sorting'           => '仕分け',
    ],
];
