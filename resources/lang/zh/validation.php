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
        '文件'    => 'The :attribute must be between :min and :max kilobytes.',
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
    '电子邮件'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    '文件'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        '文件'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        '文件'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    '图片'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        '文件'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        '文件'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        '文件'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        '文件'    => 'The :attribute must be at least :min kilobytes.',
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
        '文件'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    // Custom Validation
    'noscript'=>':attribute 不能包含 "script" 标记.',
    'noanytag'=>':attribute 不能包含字符 "<", ">".',
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
        'applications-name'               => '名称',
        'applications-email'              => '电子邮件',
        'applications-mobile'             => '移动',
        'applications-company'            => '公司名',
        'applications-position'           => '位置',
        'applications-company_location'   => '工作单位',
        'applications-cv_file'            => '简历文件',

        // BANNER
        'banners-name'          => '名称',
        'banners-menu'          => '菜单',
        'banners-post'          => '发布',
        'banners-file'          => '网站图片',
        'banners-mobile_file'   => '手机图片',
        'banners-position'      => '位置',
        'banners-slogan_1'      => '口号 1',
        'banners-slogan_2'      => '口号 2',

        // CAREER
        'businesses-name'           => '名称',
        'businesses-slug'           => 'Slug',
        'businesses-content'        => '内容',
        'businesses-show-home'      => '在家里显示',
        'businesses-short-desc'     => '简短的介绍',
        'businesses-our-products'   => '我们的产品',
        'businesses-scale-operation'        => '规模经营',
        'businesses-development-strategy'   => '发展战略',
        'businesses-avatar'         => '头像',
        'businesses-file'           => '图片',
        'businesses-icon'           => '图标',
        'businesses-icon-act'       => '活动图标',
        'businesses-file-home'      => '在家中的图像',
        'businesses-all-products-url'   => '所有产品网址',
        'businesses-products-background'   => '产品背景',

        // Industry
        'industries-name' => '名称',

        // Category
        'categories-name'  => '名称',
        'categories-menu'  => '菜单',

        // LOCATION
        'locations-name'    => '名称',

        // JOB
        'jobs-name'             => '名称',
        'jobs-file'             => '文件',
        'jobs-type'             => '工作类型',
        'jobs-level'            => '职业等级',
        'jobs-salary'           => '薪水',
        'jobs-company'          => '公司',
        'jobs-industry'         => '行业',
        'jobs-industry.*'       => '行业',
        'jobs-location'         => '工作地点',
        'jobs-location.*'       => '工作地点',
        'jobs-experiences'      => '体会',
        'jobs-qualification'    => '资质',
        'jobs-deadline_apply'   => '最后期限',
        'jobs-benefit'          => '工作福利',
        'jobs-description'      => '职位描述',
        'jobs-requirement'      => '职位需要',

        // CORE VALUE
        'core-values-name'      => '名称',
        'core-values-avatar'    => '头像',
        'core-values-file'      => '同义词图片',
        'core-values-file-how'  => '形象怎么办',
        'core-values-category'  => '类别',
        'core-values-how'       => '怎么样？',
        'core-values-who'       => '谁？',
        'core-values-what'      => '什么？',
        'core-values-where'     => '哪里？',
        'core-values-when'      => '什么时候？',

        // POSITION
        'tags-name'    => '标签',

        // POSITION
        'positions-name'    => '名称',

        // MENU
        'menus-name'        => '名称',
        'menus-type'        => '类型',
        'menus-parent_id'   => '根菜单',

        // POST
        'posts-title'   => '标题',
        'posts-slug'    => 'Slug',
        'posts-short-content' => '简短内容',
        'posts-content' => '内容',
        'posts-contact' => '联系',
        'posts-file'    => '文件',
        'posts-menu'    => '菜单',
        'posts-type'    => '类型',
        'posts-page'    => '页',
        'posts-category'            => '类别',
        'posts-seo_title'           => 'SEO 标题',
        'posts-seo_description'     => 'SEO 说明',
        'posts-board-director'      => '董事会',
        'posts-core-value'          => '核心价值',
        'posts-milestone'           => '大事记',
        'posts-vision-mission'      => '愿景使命',

        // NEWS
        'news-name'             => '标题',
        'news-slug'             => 'Slug',
        'news-file'             => '文件',
        'news-video'            => 'Video',
        'news-content'          => '内容',
        'news-category'         => '类别',
        'news-seo_title'        => 'SEO 标题',
        'news-seo_description'  => 'SEO 说明',
        'news-file-large'       => '大文件',
        'news-file-big'         => '大形象',
        'news-carousel'         => '图像轮播',
        'news-public_date'      => '公开日期',

        // CAROUSEL
        'carousels-category'    => '类别',
        'carousels-description' => '描述',
        'carousels-hover'       => '徘徊',

        // BOARD DIRECTOR
        'board-directors-name'      => '名称',
        'board-directors-avatar'    => '头像',
        'board-directors-position'  => '位置',
        'board-directors-description-1' => '描述 1',
        'board-directors-description-2' => '描述 2',
        'board-directors-hover-1' => '徘徊 1',
        'board-directors-hover-2' => '徘徊 2',

        // MILESTONE
        'milestones-name'           => '名称',
        'milestones-year'           => '年',
        'milestones-description'    => '描述',
        'milestones-hover'          => '徘徊',
        'milestones-file'           => '文件',

        // ROLE
//        'roles-name' => 'TỪ KHÓA',
//        'roles-display_name' => 'TÊN',
//        'roles-description' => 'MÔ TẢ',
//        'chosed_permissions' => 'PHÂN QUYỀN',
//        'chosed_permissions.*' => 'PHÂN QUYỀN',

        // PARTNER
        'partners-file' => '图片',
        'partners-name' => '名称',
        'partners-url'  => 'Url',

        // Global Presence
        'global-presence-name'      => '名称',
        'global-presence-address'   => '地址',

        // SETTING
        'settings-email'            => '电子邮件',
        'settings-facebook-url'     => 'Facebook Url',
        'settings-linkedin-url'     => 'Linked Url',
        'settings-youtube-url'      => 'Youtube Url',
        'settings-hotline'          => '热线',
        'settings-company-name'     => '公司名',
        'settings-logo-header'      => '徽标标题',
        'settings-logo-footer'      => '徽标页脚',
        'settings-fax'              => '传真',
        'settings-seo-title'        => 'SEO 标题',
        'settings-seo-description'  => 'SEO 说明',
        'settings-logo-footer-text' => 'Logo Footer Text',
        'settings-show-language'    => 'Show Languages',
        'settings-address'          => 'Address',

        // COMPANY
        'companies-email'           => '电子邮件',
        'companies-name'            => '名称',
        'companies-content'         => '内容',
        'companies-phone'           => '电话',
        'companies-logo'            => '商标',
        'companies-working-time'    => '工作时间',
        'companies-work-location'   => '工作地点',
        'companies-city.*'          => '市',
        'companies-address.*'       => '地址',
        'companies-city'            => '市',
        'companies-address'         => '地址',

        // STAVIAN GROUP
        'groups-name' => '名称',
        'groups-file' => '文件',

        // VISION - MISSION
        'vision-mission-name'           => '名称',
        'vision-mission-content'        => '内容',
        'vision-mission-icon_active'    => '活动图标',
        'vision-mission-icon_inactive'  => '图标无效',

        // Job Type
        'job-types-name' => '名称',

        // Job Level
        'job-levels-name' => '名称',

        // OTHER
        'slug'              => 'Slug',
        'status'            => '状态',
        'locale'            => '语言',
        'email'             => '电子邮件',
        'phone'             => '电话',
        'headquarter'       => '总公司',
        'on_top'            => '排行榜',
        'hot_news'          => '热点新闻',
        'fullname'          => '全名',
        'created_at'        => '创建于',
        'message'           => '信息',
        'sorting'           => '排序',
    ],
];
