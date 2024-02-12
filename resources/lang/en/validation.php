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
    'noscript' => 'The :attribute cannot contain a "script" tag.',
    'noanytag' => 'The :attribute cannot contain the characters "<", ">".',
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
        'applications-name'               => 'Name',
        'applications-email'              => 'Email',
        'applications-mobile'             => 'Mobile',
        'applications-company'            => 'Company name',
        'applications-position'           => 'Position',
        'applications-company_location'   => 'Work Place',
        'applications-cv_file'            => 'CV File',

        // BANNER
        'banners-name'          => 'Name',
        'banners-menu'          => 'Menu',
        'banners-post'          => 'Post',
        'banners-file'          => 'Image for Website',
        'banners-mobile_file'   => 'Image for Mobile',
        'banners-position'      => 'Position',
        'banners-slogan_1'      => 'Slogan 1',
        'banners-slogan_2'      => 'Slogan 2',

        // CAREER
        'businesses-name' => 'Name',
        'businesses-slug' => 'Slug',
        'businesses-content' => 'Content',
        'businesses-show-home' => 'Show In Home',
        'businesses-short-desc' => 'Short Description',
        'businesses-our-products' => 'Our Products',
        'businesses-scale-operation' => 'Scale Operation',
        'businesses-development-strategy' => 'Development Strategy',
        'businesses-avatar'             => 'Avatar',
        'businesses-file'               => 'Image',
        'businesses-icon'               => 'Icon',
        'businesses-icon-act'           => 'Icon Active',
        'businesses-file-home'          => 'Image In Home',
        'businesses-all-products-url'   => 'All Products URL',
        'businesses-products-background'   => 'Products Background',

        // Industry
        'industries-name' => 'Name',

        // Category
        'categories-name'  => 'Name',
        'categories-menu'  => 'Menu',

        // LOCATION
        'locations-name'    => 'Name',

        // JOB
        'jobs-name'             => 'Name',
        'jobs-file'             => 'File',
        'jobs-type'             => 'Job Type',
        'jobs-level'            => 'Job Level',
        'jobs-salary'           => 'Salary',
        'jobs-company'          => 'Company',
        'jobs-industry'         => 'Industry',
        'jobs-industry.*'       => 'Industry',
        'jobs-location'         => 'Work Location',
        'jobs-location.*'       => 'Work Location',
        'jobs-experiences'      => 'Experiences',
        'jobs-qualification'    => 'Qualification',
        'jobs-deadline_apply'   => 'Deadline',
        'jobs-benefit'          => 'Job Benefit',
        'jobs-description'      => 'Job Description',
        'jobs-requirement'      => 'Job Requirement',

        // CORE VALUE
        'core-values-name'      => 'Name',
        'core-values-avatar'    => 'Avatar',
        'core-values-file'      => 'Image of synonyms',
        'core-values-file-how'  => 'Image of how to do',
        'core-values-category'  => 'Category',
        'core-values-how'       => 'How?',
        'core-values-who'       => 'Who?',
        'core-values-what'      => 'What?',
        'core-values-where'     => 'Where?',
        'core-values-when'      => 'When?',

        // POSITION
        'tags-name'    => 'TAG',

        // POSITION
        'positions-name'    => 'Name',

        // MENU
        'menus-name'        => 'Name',
        'menus-type'        => 'Type',
        'menus-parent_id'   => 'Root menu',

        // POST
        'posts-title'   => 'Title',
        'posts-slug'    => 'Slug',
        'posts-short-content' => 'Short content',
        'posts-content' => 'Content',
        'posts-contact' => 'Contact',
        'posts-file'    => 'File',
        'posts-menu'    => 'Menu',
        'posts-type'    => 'Type',
        'posts-page'    => 'Page',
        'posts-category'            => 'Category',
        'posts-seo_title'           => 'SEO title',
        'posts-seo_description'     => 'SEO description',
        'posts-board-director'      => 'Board of directors',
        'posts-core-value'          => 'Core value',
        'posts-milestone'           => 'Milestones',
        'posts-vision-mission'      => 'Vision - Mission',

        // NEWS
        'news-name'             => 'Title',
        'news-slug'             => 'Slug',
        'news-file'             => 'File',
        'news-video'            => 'Video',
        'news-content'          => 'Content',
        'news-category'         => 'Category',
        'news-seo_title'        => 'SEO title',
        'news-seo_description'  => 'SEO description',
        'news-file-large'       => 'Large File',
        'news-file-big'         => 'Big Image',
        'news-carousel'         => 'Image Carousel',
        'news-public_date'      => 'Public Date',

        // CAROUSEL
        'carousels-category'    => 'Category',
        'carousels-description' => 'Description',
        'carousels-hover'       => 'Hover',

        // BOARD DIRECTOR
        'board-directors-name' => 'Name',
        'board-directors-avatar' => 'Avatar',
        'board-directors-position' => 'Position',
        'board-directors-description-1' => 'Description 1',
        'board-directors-description-2' => 'Description 2',
        'board-directors-hover-1' => 'Hover 1',
        'board-directors-hover-2' => 'Hover 2',

        // MILESTONE
        'milestones-name' => 'Name',
        'milestones-year' => 'Year',
        'milestones-description' => 'Description',
        'milestones-hover' => 'Hover',
        'milestones-file' => 'File',

        // ROLE
//        'roles-name' => 'TỪ KHÓA',
//        'roles-display_name' => 'TÊN',
//        'roles-description' => 'MÔ TẢ',
//        'chosed_permissions' => 'PHÂN QUYỀN',
//        'chosed_permissions.*' => 'PHÂN QUYỀN',

        // PARTNER
        'partners-file' => 'Image',
        'partners-name' => 'Name',
        'partners-url'  => 'Url',

        // Global Presence
        'global-presence-name' => 'Name',
        'global-presence-address' => 'Address',

        // SETTING
        'settings-email'            => 'Email',
        'settings-facebook-url'     => 'Facebook Url',
        'settings-linkedin-url'     => 'Linked Url',
        'settings-youtube-url'      => 'Youtube Url',
        'settings-hotline'          => 'Hotline',
        'settings-company-name'     => 'Company name',
        'settings-logo-header'      => 'Logo Header',
        'settings-logo-footer'      => 'Logo Footer',
        'settings-fax'              => 'Fax',
        'settings-seo-title'        => 'SEO Title',
        'settings-seo-description'  => 'SEO Description',
        'settings-logo-footer-text' => 'Logo Footer Text',
        'settings-show-language'    => 'Show Languages',
        'settings-address'          => 'Address',

        // COMPANY
        'companies-email'           => 'Email',
        'companies-name'            => 'Name',
        'companies-content'         => 'Content',
        'companies-phone'           => 'Phone',
        'companies-logo'            => 'Logo',
        'companies-working-time'    => 'Working time',
        'companies-work-location'   => 'Work location',
        'companies-city.*'          => 'City',
        'companies-address.*'       => 'Address',
        'companies-city'            => 'City',
        'companies-address'         => 'Address',

        // STAVIAN GROUP
        'groups-name' => 'Name',
        'groups-file' => 'File',

        // VISION - MISSION
        'vision-mission-name'           => 'Name',
        'vision-mission-content'        => 'Content',
        'vision-mission-icon_active'    => 'Icon Active',
        'vision-mission-icon_inactive'  => 'Icon Inactive',

        // Job Type
        'job-types-name' => 'Name',

        // Job Level
        'job-levels-name' => 'Name',

        // OTHER
        'slug'              => 'Slug',
        'status'            => 'Status',
        'locale'            => 'Language',
        'email'             => 'Email',
        'phone'             => 'Phone',
        'headquarter'       => 'Headquarter',
        'on_top'            => 'Top List',
        'hot_news'          => 'Hot News',
        'fullname'          => 'Full name',
        'created_at'        => 'Created at',
        'message'           => 'Message',
        'sorting'           => 'Sorting',
    ],
];
