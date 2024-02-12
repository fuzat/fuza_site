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

    'accepted'             => ':attribute phải được chấp nhận.',
    'active_url'           => ':attribute không phải là một URL hợp lệ.',
    'after'                => ':attribute phải là một ngày sau :date.',
    'after_or_equal'       => ':attribute phải là một ngày sau hoặc bằng :date.',
    'alpha'                => ':attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash'           => ':attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num'            => ':attribute chỉ có thể chứa chữ cái và số.',
    'array'                => ':attribute phải là một mảng.',
    'before'               => ':attribute phải là một ngày trước :date.',
    'before_or_equal'      => ':attribute phải là một ngày trước hoặc bằng :date.',
    'between'              => [
        'numeric' => ':attribute phải ở giữa :min và :max.',
        'file'    => ':attribute có kylobytes phải ở giữa :min và :max.',
        'string'  => ':attribute có characters phải ở giữa :min và :max.',
        'array'   => ':attribute có items phải ở giữa :min và :max.',
    ],
    'boolean'              => ':attribute trường phải đúng hoặc sai.',
    'confirmed'            => ':attribute nhận đinh không phù hợp.',
    'date'                 => ':attribute Không phải là ngày hợp lệ.',
    'date_format'          => ':attribute không phù hợp với định dạng :format.',
    'different'            => ':attribute và :other phải khác.',
    'digits'               => ':attribute phải là :digits chữ số.',
    'digits_between'       => ':attribute phải ở giữa :min và :max chữ số. Lưu ý rằng chỉ các ký tự số được chấp nhận',
    'dimensions'           => ':attribute có kích thước hình ảnh không hợp lệ.',
    'distinct'             => ':attribute trường có giá trị trùng lặp.',
    'email'                => ':attribute phải la một địa chỉ email hợp lệ.',
    'exists'               => 'Đã chọn giá trị :attribute không hợp lệ.',
    'file'                 => ':attribute phải là một tập tin.',
    'filled'               => ':attribute trường phải có giá trị.',
    'gt'                   => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file'    => ':attribute có kilobytes phải lớn hơn :value.',
        'string'  => ':attribute có characters phải lớn hơn :value.',
        'array'   => ':attribute có items phải lớn hơn :value.',
    ],
    'gte'                  => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file'    => ':attribute có kilobytes phải lớn hơn hoặc bằng :value.',
        'string'  => ':attribute có characters phải lớn hơn hoặc bằng :value.',
        'array'   => ':attribute phải có items là :value hoặc hơn',
    ],
    'image'                => ':attribute phải là ảnh.',
    'in'                   => 'Giá trị :attribute không hợp lệ.',
    'in_array'             => ':attribute không tồn tại trong :other.',
    'integer'              => ':attribute phải là số nguyên.',
    'ip'                   => ':attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4'                 => ':attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6'                 => ':attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json'                 => ':attribute phải là một chuỗi JSON hợp lệ.',
    'lt'                   => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file'    => ':attribute có kilobytes phải nhỏ hơn :value.',
        'string'  => ':attribute có characters phải nhỏ hơn :value.',
        'array'   => ':attribute phải có items nhỏ hơn :value.',
    ],
    'lte'                  => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file'    => ':attribute có kilobytes phải nhỏ hơn hoặc bằng :value.',
        'string'  => ':attribute có characters phải nhỏ hơn hoặc bằng :value.',
        'array'   => ':attribute phải có items nhỏ hơn hoặc bằng :value.',
    ],
    'max'                  => [
        'numeric' => ':attribute không thể lớn hơn :max.',
        'file'    => ':attribute có kilobytes không thể lớn hơn :max.',
        'string'  => ':attribute có characters không thể lớn hơn :max.',
        'array'   => ':attribute có items không thể lớn hơn :max.',
    ],
    'mimes'                => ':attribute phải là một tập tin loại: :values.',
    'mimetypes'            => ':attribute phải là một tập tin loại: :values.',
    'min'                  => [
        'numeric' => ':attribute ít nhất phải :min.',
        'file'    => ':attribute có kilobytes ít nhất phải :min.',
        'string'  => ':attribute có characters ít nhất phải :min.',
        'array'   => ':attribute có items ít nhất phải :min.',
    ],
    'not_in'               => 'Giá trị của :attribute không hợp lệ.',
    'not_regex'            => 'Định dạng của :attribute không hợp lệ.',
    'numeric'              => ':attribute phải là số.',
    'present'              => ':attribute phải có mặt.',
    'regex'                => ':attribute định dạng không hợp lệ.',
    'required'             => ':attribute là bắt buộc.',
    'required_if'          => ':attribute bắt buộc khi :other có giá trị là :value.',
    'required_unless'      => ':attribute bắt buộc khi nếu :other có giá trị không phải là :values.',
    'required_with'        => ':attribute bắt buộc khi :values là giá trị từ trước.',
    'required_with_all'    => ':attribute bắt buộc khi :values là giá trị từ trước.',
    'required_without'     => ':attribute bắt buộc khi :values không là giá trị từ trước.',
    'required_without_all' => ':attribute bắt buộc khi :values không có giá trị nào.',
    'same'                 => ':attribute và :other phải trùng nhau.',
    'size'                 => [
        'numeric' => ':attribute phải là :size.',
        'file'    => ':attribute có kylobytes phải là :size.',
        'string'  => ':attribute có characters phải là :size.',
        'array'   => ':attribute có chứa items là :size.',
    ],
    'string'               => ':attribute phải là chuỗi.',
    'timezone'             => ':attribute phải là một khu vực hợp lệ.',
    'unique'               => ':attribute đã được thực hiện.',
    'uploaded'             => ':attribute không tải lên được.',
    'url'                  => ':attribute định dạng không hợp lệ.',

    // Custom Validation
    'noscript' => 'Trường :attribute không được chứa thẻ "script".',
    'noanytag' => 'Trường :attribute không được chứa các kí tự "<", ">".',
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
        'applications-name'               => 'Tên',
        'applications-email'              => 'Email',
        'applications-mobile'             => 'Mobile',
        'applications-company'            => 'Tên công ty',
        'applications-position'           => 'Chức vụ',
        'applications-company_location'   => 'Nơi làm việc',
        'applications-cv_file'            => 'CV File',

        // BANNER
        'banners-name'          => 'Tên',
        'banners-menu'          => 'Menu',
        'banners-post'          => 'Post',
        'banners-file'          => 'Image for Website',
        'banners-mobile_file'   => 'Image for Mobile',
        'banners-position'      => 'Chức vụ',
        'banners-slogan_1'      => 'Slogan 1',
        'banners-slogan_2'      => 'Slogan 2',

        // CAREER
        'businesses-name' => 'Tên',
        'businesses-slug' => 'Slug',
        'businesses-content' => 'Nội dung',
        'businesses-show-home' => 'Hiện ở trang chủ',
        'businesses-short-desc' => 'Mô tả ngắn',
        'businesses-our-products' => 'Các sản phẩm của chúng tôi',
        'businesses-scale-operation' => 'Quy mô hoạt động',
        'businesses-development-strategy' => 'Chiến lược phát triển',
        'businesses-avatar'         => 'Avatar',
        'businesses-file'           => 'Ảnh',
        'businesses-icon'           => 'Icon',
        'businesses-icon-act'       => 'Icon Active',
        'businesses-file-home'      => 'Ảnh ở trang chủ',
        'businesses-all-products-url'   => 'All Products URL',
        'businesses-products-background'   => 'Products Background',

        // Industry
        'industries-name' => 'Tên',

        // Category
        'categories-name'  => 'Tên',
        'categories-menu'  => 'Danh mục',

        // LOCATION
        'locations-name'    => 'Tên',

        // JOB
        'jobs-name'             => 'Tên',
        'jobs-file'             => 'File',
        'jobs-type'             => 'Loại công việc',
        'jobs-level'            => 'Cấp bậc công việc',
        'jobs-salary'           => 'Lương',
        'jobs-company'          => 'Công ty',
        'jobs-industry'         => 'Lĩnh vực',
        'jobs-industry.*'       => 'Lĩnh vực',
        'jobs-location'         => 'Địa chỉ',
        'jobs-location.*'       => 'Địa chỉ',
        'jobs-experiences'      => 'Kinh nghiệm',
        'jobs-qualification'    => 'Trình độ chuyên môn',
        'jobs-deadline_apply'   => 'Hạn chót',
        'jobs-benefit'          => 'Phúc lợi',
        'jobs-description'      => 'Mô tả',
        'jobs-requirement'      => 'Yêu cầu',

        // CORE VALUE
        'core-values-name'      => 'Tên',
        'core-values-avatar'    => 'Avatar',
        'core-values-file'      => 'Image of synonyms',
        'core-values-file-how'  => 'Image of how to do',
        'core-values-category'  => 'Thể loại',
        'core-values-how'       => 'How?',
        'core-values-who'       => 'Who?',
        'core-values-what'      => 'What?',
        'core-values-where'     => 'Where?',
        'core-values-when'      => 'When?',

        // POSITION
        'tags-name'    => 'Tag',

        // POSITION
        'positions-name'    => 'Tên',

        // MENU
        'menus-name'        => 'Tên',
        'menus-type'        => 'Loại',
        'menus-parent_id'   => 'Danh mục gốc',

        // POST
        'posts-title'   => 'Tiêu đề',
        'posts-slug'    => 'Slug',
        'posts-short-content' => 'Mô tả ngắn',
        'posts-content' => 'Nội dung',
        'posts-contact' => 'Nội dung',
        'posts-file'    => 'File',
        'posts-menu'    => 'Danh mục',
        'posts-type'    => 'Loại',
        'posts-page'    => 'Trang',
        'posts-category'            => 'Thể loại',
        'posts-seo_title'           => 'Tiêu đề SEO',
        'posts-seo_description'     => 'Nội dung SEO',
        'posts-board-director'      => 'Ban giám đốc',
        'posts-core-value'          => 'Giá trị cốt lõi',
        'posts-milestone'           => 'Mốc thời gian',
        'posts-vision-mission'      => 'Tầm nhìn - Sứ mệnh',

        // NEWS
        'news-name'             => 'Tiêu đề',
        'news-slug'             => 'Slug',
        'news-file'             => 'File',
        'news-video'            => 'Video',
        'news-content'          => 'Nội dung',
        'news-category'         => 'Thể loại',
        'news-seo_title'        => 'Tiêu đề SEO',
        'news-seo_description'  => 'Nội dung SEO',
        'news-file-large'       => 'Large File',
        'news-file-big'         => 'Big Image',
        'news-carousel'         => 'Image Carousel',
        'news-public_date'      => 'Ngày công khai',

        // CAROUSEL
        'carousels-category'    => 'Category',
        'carousels-description' => 'Mô tả',
        'carousels-hover'       => 'Mô tả hover',

        // BOARD DIRECTOR
        'board-directors-name' => 'Tên',
        'board-directors-avatar' => 'Avatar',
        'board-directors-position' => 'Chức vụ',
        'board-directors-description-1' => 'Mô tả 1',
        'board-directors-description-2' => 'Mô tả 2',
        'board-directors-hover-1' => 'Mô tả hover 1',
        'board-directors-hover-2' => 'Mô tả hover 2',

        // MILESTONE
        'milestones-name' => 'Tên',
        'milestones-year' => 'Năm',
        'milestones-description' => 'Mô tả',
        'milestones-hover' => 'Mô tả hover',
        'milestones-file' => 'File',

        // ROLE
//        'roles-name' => 'TỪ KHÓA',
//        'roles-display_name' => 'TÊN',
//        'roles-description' => 'MÔ TẢ',
//        'chosed_permissions' => 'PHÂN QUYỀN',
//        'chosed_permissions.*' => 'PHÂN QUYỀN',

        // PARTNER
        'partners-file' => 'Image',
        'partners-name' => 'Tên',
        'partners-url'  => 'Url',

        // Global Presence
        'global-presence-name' => 'Tên',
        'global-presence-address' => 'Địa chỉ',

        // SETTING
        'settings-email'            => 'Email',
        'settings-facebook-url'     => 'Facebook Url',
        'settings-linkedin-url'     => 'Linked Url',
        'settings-youtube-url'      => 'Youtube Url',
        'settings-hotline'          => 'Hotline',
        'settings-company-name'     => 'Tên công ty',
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
        'companies-name'            => 'Tên',
        'companies-content'         => 'Nội dung',
        'companies-phone'           => 'Điện thoại',
        'companies-logo'            => 'Logo',
        'companies-working-time'    => 'Thời gian làm việc',
        'companies-work-location'   => 'Nơi làm việc',
        'companies-city.*'          => 'Tỉnh/Thành',
        'companies-address.*'       => 'Địa chỉ',
        'companies-city'            => 'Tỉnh/Thành',
        'companies-address'         => 'Địa chỉ',

        // STAVIAN GROUP
        'groups-name' => 'Tên',
        'groups-file' => 'File',

        // VISION - MISSION
        'vision-mission-name'           => 'Tên',
        'vision-mission-content'        => 'Nội dung',
        'vision-mission-icon_active'    => 'Icon Active',
        'vision-mission-icon_inactive'  => 'Icon Inactive',

        // Job Type
        'job-types-name' => 'Tên',

        // Job Level
        'job-levels-name' => 'Tên',

        // OTHER
        'slug'              => 'Slug',
        'status'            => 'Trạng thái',
        'locale'            => 'Ngôn ngữ',
        'email'             => 'Email',
        'phone'             => 'Điện thoại',
        'headquarter'       => 'Trụ sở chính',
        'on_top'            => 'Đầu danh sách',
        'hot_news'          => 'Hot News',
        'fullname'          => 'Họ & tên',
        'created_at'        => 'Ngày tạo',
        'message'           => 'Tin nhắn',
        'sorting'           => 'Sắp xếp',
    ],
];
