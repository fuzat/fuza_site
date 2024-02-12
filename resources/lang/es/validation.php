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
    'noscript' => 'El :attribute no puede contener una etiqueta "script".',
    'noanytag' => 'El :attribute no puede contener los caracteres "<", ">".',
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
        'applications-name'               => 'Nombre',
        'applications-email'              => 'Email',
        'applications-mobile'             => 'Móvil',
        'applications-company'            => 'Nombre de empresa',
        'applications-position'           => 'Posición',
        'applications-company_location'   => 'Lugar de trabajo',
        'applications-cv_file'            => 'Archivo CV',

        // BANNER
        'banners-name'          => 'Nombre',
        'banners-menu'          => 'Menú',
        'banners-post'          => 'Enviar',
        'banners-file'          => 'Imagen para el sitio web',
        'banners-mobile_file'   => 'Imagen para móvil',
        'banners-position'      => 'Posición',
        'banners-slogan_1'      => 'Eslogan 1',
        'banners-slogan_2'      => 'Eslogan 2',

        // CAREER
        'businesses-name'                   => 'Nombre',
        'businesses-slug'                   => 'Babosa',
        'businesses-content'                => 'Contenido',
        'businesses-show-home'              => 'Mostrar en casa',
        'businesses-short-desc'             => 'Breve descripción',
        'businesses-our-products'           => 'Nuestros productos',
        'businesses-scale-operation'        => 'Operación a escala',
        'businesses-development-strategy'   => 'Estrategia de desarrollo',
        'businesses-avatar'                 => 'Avatar',
        'businesses-file'                   => 'Imagen',
        'businesses-icon'                   => 'Icono',
        'businesses-icon-act'               => 'Icono activo',
        'businesses-file-home'              => 'Imagen en casa',
        'businesses-all-products-url'       => 'URL de todos los productos',
        'businesses-products-background'   => 'Fondo de productos',

        // Industry
        'industries-name' => 'Nombre',

        // Category
        'categories-name'  => 'Nombre',
        'categories-menu'  => 'Menú',

        // LOCATION
        'locations-name'    => 'Nombre',

        // JOB
        'jobs-name'             => 'Nombre',
        'jobs-file'             => 'Archivo',
        'jobs-type'             => 'Tipo de trabajo',
        'jobs-level'            => 'Nivel de trabajo',
        'jobs-salary'           => 'Salario',
        'jobs-company'          => 'Empresa',
        'jobs-industry'         => 'Industria',
        'jobs-industry.*'       => 'Industria',
        'jobs-location'         => 'Ubicación de trabajo',
        'jobs-location.*'       => 'Ubicación de trabajo',
        'jobs-experiences'      => 'Experiencias',
        'jobs-qualification'    => 'Calificación',
        'jobs-deadline_apply'   => 'Fecha límite',
        'jobs-benefit'          => 'Beneficio laboral',
        'jobs-description'      => 'Descripción del trabajo',
        'jobs-requirement'      => 'Requerimiento de trabajo',

        // CORE VALUE
        'core-values-name'      => 'Nombre',
        'core-values-avatar'    => 'Avatar',
        'core-values-file'      => 'Imagen de sinónimos',
        'core-values-file-how'  => 'Imagen de como hacer',
        'core-values-category'  => 'Categoría',
        'core-values-how'       => '¿Cómo?',
        'core-values-who'       => '¿Quien?',
        'core-values-what'      => '¿Qué?',
        'core-values-where'     => '¿Dónde?',
        'core-values-when'      => '¿Cuando?',

        // POSITION
        'tags-name'    => 'Etiqueta',

        // POSITION
        'positions-name'    => 'Nombre',

        // MENU
        'menus-name'        => 'Nombre',
        'menus-type'        => 'Tipo',
        'menus-parent_id'   => 'Menú raíz',

        // POST
        'posts-title'               => 'Título',
        'posts-slug'                => 'Babosa',
        'posts-short-content'       => 'Contenido corto',
        'posts-content'             => 'Contenido',
        'posts-contact'             => 'Contacto',
        'posts-file'                => 'Archivo',
        'posts-menu'                => 'Menú',
        'posts-type'                => 'Tipo',
        'posts-page'                => 'Página',
        'posts-category'            => 'Categoría',
        'posts-seo_title'           => 'Título de SEO',
        'posts-seo_description'     => 'Descripción de SEO',
        'posts-board-director'      => 'Junta Directiva',
        'posts-core-value'          => 'Valor central',
        'posts-milestone'           => 'Hitos',
        'posts-vision-mission'      => 'Misión vision',

        // NEWS
        'news-name'             => 'Título',
        'news-slug'             => 'Babosa',
        'news-file'             => 'Archivo',
        'news-video'            => 'Vídeo',
        'news-content'          => 'Contenido',
        'news-category'         => 'Categoría',
        'news-seo_title'        => 'Título de SEO',
        'news-seo_description'  => 'Descripción de SEO',
        'news-file-large'       => 'Archivo grande',
        'news-file-big'         => 'Imagen grande',
        'news-carousel'         => 'Carrusel de imagen',
        'news-public_date'      => 'Fecha publica',

        // CAROUSEL
        'carousels-category'    => 'Categoría',
        'carousels-description' => 'Descripción',
        'carousels-hover'       => 'Flotar',

        // BOARD DIRECTOR
        'board-directors-name'          => 'Name',
        'board-directors-avatar'        => 'Avatar',
        'board-directors-position'      => 'Position',
        'board-directors-description-1' => 'Descripción 1',
        'board-directors-description-2' => 'Descripción 2',
        'board-directors-hover-1'       => 'Flotar 1',
        'board-directors-hover-2'       => 'Flotar 2',

        // MILESTONE
        'milestones-name'           => 'Nombre',
        'milestones-year'           => 'Año',
        'milestones-description'    => 'Descripción',
        'milestones-hover'          => 'Flotar',
        'milestones-file'           => 'Archivo',

        // ROLE
//        'roles-name' => 'TỪ KHÓA',
//        'roles-display_name' => 'TÊN',
//        'roles-description' => 'MÔ TẢ',
//        'chosed_permissions' => 'PHÂN QUYỀN',
//        'chosed_permissions.*' => 'PHÂN QUYỀN',

        // PARTNER
        'partners-file' => 'Imagen',
        'partners-name' => 'Nombre',
        'partners-url'  => 'Url',

        // Global Presence
        'global-presence-name'      => 'Nombre',
        'global-presence-address'   => 'Habla a',

        // SETTING
        'settings-email'            => 'Email',
        'settings-facebook-url'     => 'Facebook Url',
        'settings-linkedin-url'     => 'Linked Url',
        'settings-youtube-url'      => 'Youtube Url',
        'settings-hotline'          => 'Línea directa',
        'settings-company-name'     => 'Nombre de empresa',
        'settings-logo-header'      => 'Encabezado de logotipo',
        'settings-logo-footer'      => 'Pie de página del logotipo',
        'settings-fax'              => 'Fax',
        'settings-seo-title'        => 'Título de SEO',
        'settings-seo-description'  => 'Descripción de SEO',
        'settings-logo-footer-text' => 'Logo Footer Text',
        'settings-show-language'    => 'Show Languages',
        'settings-address'          => 'Address',

        // COMPANY
        'companies-email'           => 'Email',
        'companies-name'            => 'Nombre',
        'companies-content'         => 'Contenido',
        'companies-phone'           => 'Teléfono',
        'companies-logo'            => 'Logo',
        'companies-working-time'    => 'Tiempo de trabajo',
        'companies-work-location'   => 'Ubicación de trabajo',
        'companies-city.*'          => 'Ciudad',
        'companies-address.*'       => 'Habla a',
        'companies-city'            => 'Ciudad',
        'companies-address'         => 'Habla a',

        // STAVIAN GROUP
        'groups-name' => 'Nombre',
        'groups-file' => 'Archivo',

        // VISION - MISSION
        'vision-mission-name'           => 'Nombre',
        'vision-mission-content'        => 'Contenido',
        'vision-mission-icon_active'    => 'Icono activo',
        'vision-mission-icon_inactive'  => 'Icono inactivo',

        // Job Type
        'job-types-name' => 'Nombre',

        // Job Level
        'job-levels-name' => 'Nombre',

        // OTHER
        'slug'              => 'Babosa',
        'status'            => 'Estado',
        'locale'            => 'Idioma',
        'email'             => 'Email',
        'phone'             => 'Teléfono',
        'headquarter'       => 'Sede',
        'on_top'            => 'Lista superior',
        'hot_news'          => 'Noticias de ultimo momento',
        'fullname'          => 'Nombre completo',
        'created_at'        => 'Creado en',
        'message'           => 'Mensaje',
        'sorting'           => 'Clasificación',
    ],
];
