<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                    داشبورد
                </p>
            </a>
        </li>
        @can('user-list')
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::segment(2) == 'users' ? 'active' : '' }}">
                    <i class="nav-icon fa fa-users"></i>
                    <p>
                        کاربران
                        {{--<span class="right badge badge-danger">جدید</span>--}}
                    </p>
                </a>
            </li>

        @endcan
        @can('role-list')
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-key"></i>
                    <p>
                        نقش ها و دسترسی ها
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                            <i class="fa fa-circle-o nav-icon"></i>
                            <p>مدیریت نقش ها</p>
                        </a>
                    </li>
                </ul>
            </li>


        @endcan

        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-book"></i>
                <p>
                    مدیریت محتوا
                    <i class="fa fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ Request::segment(2) == 'categories' ? 'active' : '' }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>گروه بندی</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ Request::segment(2) == 'sliders' ? 'active' : '' }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>اسلایدر</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.articles.index') }}" class="nav-link {{ Request::segment(2) == 'articles' ? 'active' : '' }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>مقاله</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>اخبار</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-plus-square-o"></i>
                <p>
                    بیشتر
                    <i class="fa fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ Request::segment(2) == 'contacts' ? 'active' : '' }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>پیام ها</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ Request::segment(2) == 'settings' ? 'active' : '' }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>تنظیمات</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/examples/blank.html" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>صفحه خالی</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="starter.html" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>صفحه شروع</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-header">متفاوت</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-file"></i>
                <p>مستندات</p>
            </a>
        </li>
        <li class="nav-header">برچسب‌ها</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-circle-o text-danger"></i>
                <p class="text">مهم</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-circle-o text-warning"></i>
                <p>هشدار</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-circle-o text-info"></i>
                <p>اطلاعات</p>
            </a>
        </li>
    </ul>
</nav>