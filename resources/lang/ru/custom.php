<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'msg' => [
        'create' => [
            'success' => 'Создано успешно',
            'fail' => 'Создано неудачно',
        ],
        'update' => [
            'success' => 'Успешно Обновлено',
            'fail' => 'Обновлен неудачно',
        ],
        'change-status' => [
            'success' => 'Changed status successfully',
            'fail' => 'Changed status unsuccessfully',
        ],
        'delete' => [
            'success' => 'Удалено успешно',
            'fail' => 'Удалено неудачно',
        ],
        'sent' => [
            'success'   => 'Успешно отправлено',
            'fail'      => 'Отправлено неудачно',
            'contact'   => 'Спасибо за отправку контакта. Отдел кадров компании Thaco ответит вам как можно скорее!',
            'job'       => 'Поздравляем! Вы успешно подали заявку на должность :job_name',
        ],
        'send-msg' => [
            'success'   => 'Отправить сообщение успешно',
            'fail'      => 'Отправить сообщение безуспешно',
        ],
        'error' => [
            '503' => 'Пожалуйста, попробуйте позже',
            '500' => 'Внутренний сервер имеет проблемы',
            '405' => 'Метод не разрешен',
            '404' => 'Страница не найдена',
            '403' => 'Ссылка недействительна',
            '201' => 'Нет авторизации',
            'no-data'       => 'Данные не найдены',
            'miss-param'    => 'Отсутствующий параметр :input',
            'not-edit'      => 'Эти данные не могут обновлять',
        ],
        'save' => [
            'success'   => 'Успешно сохранено',
            'fail'      => 'Сохранено неудачно',
        ],
        'apply' => [
            'success'   => 'Успешно применено',
            'fail'      => 'Применяется неудачно',
        ],
        'upload' => [
            'success'   => 'Загружен успешно',
            'fail'      => 'Загружен неудачно',
        ],
        'send-applicant' => [
            'success'   => 'Отправить письмо Присоединиться к сообществу талантов',
            'fail'      => 'Отправить письмо Присоединиться к Talent Community Fail',
        ],
    ],
    'button' => [
        'add'           => 'добавлять',
        'create'        => 'Создайте',
        'store'         => 'хранить',
        'show'          => 'Показать',
        'edit'          => 'редактировать',
        'update'        => 'Обновить',
        'delete'        => 'удалять',
        'list'          => 'Список',
        'detail'        => 'подробность',
        'save'          => 'Сохранить',
        'reset'         => 'Сброс настроек',
        'refresh'       => 'обновление',
        'filter'        => 'Фильтр',
        'confirm'       => 'Подтверждение',
        'select-all'    => 'Выбрать все',
        'deselect-all'  => 'Снять все',
        'sign-in'       => 'Войти в систему',
        'sign-up'       => 'Зарегистрироваться',
        'read-more'     => 'Подробнее',
        'send'          => 'послать',
        'sign-out'      => 'Выход',
        'cancel'        => 'Отмена',
        'show-all'      => 'Показать все',
        'back-home'     => 'Вернуться на главную страницу',
        'forgot-password'           => 'Забыл пароль',
        'send-message'              => 'Отправить сообщение',
        'view-compliance-policy'    => 'Ознакомьтесь с политикой соответствия при импорте-экспорте',
        'view-all-products'         => 'Просмотреть все продукты',
        'search'    => 'Поиск',
        'share'     => 'Поделиться',
        'apply'     => 'Подать заявление',
        'apply-now' => 'Применить сейчас',
        'upload-cv' => 'Загрузить резюме',
        'sort'      => 'Сортировать',
        'choose-company' => 'Выберите компанию',
        'choose-work-place' => 'Выберите рабочее место',
        'choose-position' => 'Выберите позицию',
        'choose-post' => 'Выберите сообщение',
        'choose-menu' => 'Выберите меню',
        'choose-page' => 'Выберите страницу',
    ],
    'permission' => [
        'module' => [
            'home'          => 'Home',
            'user'          => 'User',
            'role'          => 'Role',
            'industry'      => 'Industry',
            'business'      => 'Business',
            'category'      => 'Category',
            'location'      => 'Location',
            'banner'        => 'Banner',
            'position'      => 'Position',
            'job'           => 'Job',
            'benefit'       => 'Benefit',
            'menu'          => 'Menu',
            'post'          => 'Post',
            'applicant'     => 'Applicant',
            'application'   => 'Application',
            'interview'     => 'Interview',
            'carousel'      => 'Carousel',
            'milestone'     => 'Milestones',
            'core-value'    => 'Core value',
            'partner'       => 'Partner',
            'contact'       => 'Contact',
            'setting'       => 'Setting',
            'company'       => 'Company',
            'board-director'    => 'Board Of Directors',
            'global-presence'   => 'Global Presence',
            'group'         => 'Stavian Group',
            'news'          => 'News',
            'vision-mission'    => 'Vision-Mission',
            'language'      => 'Language',
            'job-type'      => 'Job\'s Type',
            'job-level'     => 'Job\'s Level',
        ],
    ],
    'confirm' => [
        'delete' => 'Вы хотите удалить эту строку?',
    ],
    'input' => [
        'name'          => 'имя',
        'telephone'     => 'Номер телефона',
        'email'         => 'Эл. адрес',
        'subject'       => 'Предмет',
        'message'       => 'Сообщение',
        'industry'      => 'Промышленность',
        'location'      => 'Место расположения',
        'company'       => 'Компания',
        'search-job'    => 'Поиск работы сейчас ...',
        'search-here'   => 'Поищи здесь',
    ],
];
