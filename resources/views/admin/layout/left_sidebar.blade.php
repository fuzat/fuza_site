<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    @php($arr = [])
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown " data-menu-vertical="true" data-menu-dropdown="true" data-menu-scrollable="true" data-menu-dropdown-timeout="500">
        <ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow">
            <li class="m-menu__item @if(in_array($routing, ['admin.dashboard'])) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ route('admin.dashboard') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-text text-uppercase">{{ __('custom.permission.module.home') }}</span>
                </a>
            </li>

            @php($arr = ['admin.menus.index', 'admin.menus.create', 'admin.menus.edit',
            'admin.banners.index', 'admin.banners.create', 'admin.banners.edit',
            'admin.posts.index', 'admin.posts.create', 'admin.posts.edit'])
            <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="javascript:void(0);" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap"><span class="m-menu__link-text text-uppercase">Page</span></span>
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">
                                            Page
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </li>

                        @php($arr = ['admin.menus.index', 'admin.menus.create', 'admin.menus.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.menus.index') }}" class="m-menu__link">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.menu') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.posts.index', 'admin.posts.create', 'admin.posts.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.posts.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.post') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.banners.index', 'admin.banners.create', 'admin.banners.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true" >
                            <a href="{{ route('admin.banners.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.banner') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php($arr = ['admin.vision-mission.index', 'admin.vision-mission.create', 'admin.vision-mission.edit',
            'admin.positions.index', 'admin.positions.create', 'admin.positions.edit',
            'admin.board-directors.index', 'admin.board-directors.create', 'admin.board-directors.edit',
            'admin.core-values.index', 'admin.core-values.create', 'admin.core-values.edit',
            'admin.milestones.index', 'admin.milestones.create', 'admin.milestones.edit',
            'admin.carousels.index', 'admin.carousels.create', 'admin.carousels.edit'])
            <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="javascript:void(0);" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap"><span class="m-menu__link-text text-uppercase">{{ __('datametas.web.title.about-us') }}</span></span>
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">
                                            {{ __('datametas.web.title.about-us') }}
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </li>

                        @php($arr = ['admin.vision-mission.index', 'admin.vision-mission.create', 'admin.vision-mission.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.vision-mission.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.vision-mission') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.positions.index', 'admin.positions.create', 'admin.positions.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.positions.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.position') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.board-directors.index', 'admin.board-directors.create', 'admin.board-directors.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.board-directors.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.board-director') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.core-values.index', 'admin.core-values.create', 'admin.core-values.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.core-values.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.core-value') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.carousels.index', 'admin.carousels.create', 'admin.carousels.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.carousels.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.carousel') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.milestones.index', 'admin.milestones.create', 'admin.milestones.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.milestones.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.milestone') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php($arr = ['admin.categories.index', 'admin.categories.create', 'admin.categories.edit', 'admin.news.index', 'admin.news.create', 'admin.news.edit'])
            <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="javascript:void(0);" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap"><span class="m-menu__link-text text-uppercase">{{ __('datametas.web.title.news') }}</span></span>
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">
                                            {{ __('datametas.web.title.news') }}
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </li>

                        @php($arr = ['admin.categories.index', 'admin.categories.create', 'admin.categories.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.categories.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.category') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.news.index', 'admin.news.create', 'admin.news.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.news.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.news') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php($arr = ['admin.companies.index', 'admin.companies.create', 'admin.companies.edit',
            'admin.industries.index', 'admin.industries.create', 'admin.industries.edit',
            'admin.locations.index', 'admin.locations.create', 'admin.locations.edit',
            'admin.jobs.index', 'admin.jobs.create', 'admin.jobs.edit',
            'admin.job-levels.index', 'admin.job-levels.create', 'admin.job-levels.edit',
            'admin.job-types.index', 'admin.job-types.create', 'admin.job-types.edit',
            ])
            <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="javascript:void(0);" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap"><span class="m-menu__link-text text-uppercase">{{ __('datametas.web.title.careers') }}</span></span>
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">
                                            {{ __('datametas.web.title.careers') }}
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </li>

                        @php($arr = ['admin.companies.index', 'admin.companies.create', 'admin.companies.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.companies.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.company') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.industries.index', 'admin.industries.create', 'admin.industries.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.industries.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.industry') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.locations.index', 'admin.locations.create', 'admin.locations.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.locations.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.location') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.jobs.index', 'admin.jobs.create', 'admin.jobs.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.jobs.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.job') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.job-types.index', 'admin.job-types.create', 'admin.job-types.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.job-types.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.job-type') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.job-levels.index', 'admin.job-levels.create', 'admin.job-levels.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.job-levels.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.job-level') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php($arr = ['admin.partners.index', 'admin.partners.create', 'admin.partners.edit', 'admin.partners.destroy', 'admin.groups.index', 'admin.groups.create', 'admin.groups.edit'])
            <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="javascript:void(0);" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap"><span class="m-menu__link-text text-uppercase">{{ __('custom.permission.module.partner') }}</span></span>
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">
                                            {{ __('custom.permission.module.partner') }}
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </li>

                        @php($arr = ['admin.partners.index', 'admin.partners.create', 'admin.partners.edit', 'admin.partners.destroy'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.partners.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.partner') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.groups.index', 'admin.groups.create', 'admin.groups.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.groups.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.group') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php($arr = ['admin.global-presence.index', 'admin.global-presence.create', 'admin.global-presence.edit', 'admin.businesses.index', 'admin.businesses.create', 'admin.businesses.edit'])
            <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="javascript:void(0);" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap"><span class="m-menu__link-text text-uppercase">Data</span></span>
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">
                                            Data
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </li>

                        @php($arr = ['admin.global-presence.index', 'admin.global-presence.create', 'admin.global-presence.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.global-presence.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.global-presence') }}</span>
                            </a>
                        </li>

                        @php($arr = ['admin.businesses.index', 'admin.businesses.create', 'admin.businesses.edit'])
                        <li class="m-menu__item @if(in_array($routing, $arr)) m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('admin.businesses.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">{{ __('custom.permission.module.business') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="m-menu__item @if(in_array($routing, ['admin.applications.index'])) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ route('admin.applications.index') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-text text-uppercase">{{ __('custom.permission.module.application') }}</span>
                </a>
            </li>

            <li class="m-menu__item @if(in_array($routing, ['admin.contacts.index'])) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ route('admin.contacts.index') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-text text-uppercase">{{ __('custom.permission.module.contact') }}</span>
                </a>
            </li>

            <li class="m-menu__item @if(in_array($routing, ['admin.languages.index'])) m-menu__item--active @endif" aria-haspopup="true" >
                <a href="{{ route('admin.languages.index') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-text text-uppercase">{{ __('custom.permission.module.language') }}</span>
                </a>
            </li>

            <li class="m-menu__item @if(in_array($routing, ['admin.settings.edit'])) m-menu__item--active @endif" aria-haspopup="true" >
                <a href="{{ route('admin.settings.edit', ['lang' => \LaravelLocalization::getCurrentLocale()]) }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <span class="m-menu__link-text text-uppercase">{{ __('custom.permission.module.setting') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
