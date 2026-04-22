<div id="sidebar" class="sidebar ">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-center m-0">Keylogic</h2>
                <div class="toggler">
                    <a href="javascript:void(0)" class="sidebar-hide d-xl-none d-block">
                        <i class="bi bi-x bi-middle"></i>
                    </a>
                </div>
            </div>
            <p class="mt-2 text-muted text-center fs-5">

                Welcome, <strong>{{ auth()->user()->name }}</strong>
            </p>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('admin/dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid"></i><span>Dashboard</span>
                    </a>
                </li>

                {{-- if (canAccess('category')) { --}}
                @if (auth()->user()->hasAccess('category'))
                    <li
                        class="sidebar-item has-sub {{ request()->is('admin/categories*') ? 'active submenu-open' : '' }}">
                        <a href="javascript:void(0)" class="sidebar-link">
                            <i class="bi bi-folder"></i><span>Category</span>
                        </a>
                        <ul class="submenu {{ request()->is('admin/categories*') ? 'active submenu-open' : '' }} ">
                            <li class="submenu-item {{ request()->is('admin/categories/create') ? 'active' : '' }}">
                                <a href="{{ url('admin/categories/create') }}">Add Category</a>
                            </li>
                            <li class="submenu-item {{ request()->is('admin/categories') ? 'active' : '' }}">
                                <a href="{{ url('admin/categories') }}">Categories</a>
                            </li>
                        </ul>

                    </li>
                @endif

                @if (auth()->user()->hasAccess('options'))
                    <li class="sidebar-item has-sub {{ request()->is('admin/options*') ? 'active submenu-open' : '' }}">
                        <a href="javascript:void(0)" class="sidebar-link">
                            <i class="bi bi-sliders"></i><span>Options</span>
                        </a>
                        <ul class="submenu  {{ request()->is('admin/options*') ? 'active submenu-open' : '' }}">
                            <li class="submenu-item {{ request()->is('admin/options/create') ? 'active' : '' }}">
                                <a href="{{ url('admin/options/create') }}">Add Option</a>
                            </li>
                            <li class="submenu-item {{ request()->is('admin/options') ? 'active' : '' }}">
                                <a href="{{ url('admin/options') }}">Options</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasAccess('attribute'))
                    <li
                        class="sidebar-item has-sub {{ request()->is('admin/attributes*') ? 'active submenu-open' : '' }}">

                        <a href="javascript:void(0)" class="sidebar-link">
                            <i class="bi bi-tags"></i><span>Attribute</span>
                        </a>

                        <ul class="submenu {{ request()->is('admin/attributes*') ? 'active submenu-open' : '' }}">

                            <li class="submenu-item {{ request()->is('admin/attributes/create') ? 'active' : '' }}">
                                <a href="{{ url('admin/attributes/create') }}">Add Attribute</a>
                            </li>

                            <li class="submenu-item {{ request()->is('admin/attributes') ? 'active' : '' }}">
                                <a href="{{ url('admin/attributes') }}">Attribute</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasAccess('products'))
                    <li
                        class="sidebar-item has-sub {{ request()->is('admin/products*') ? 'active submenu-open' : '' }}">
                        <a href="javascript:void(0) " class="sidebar-link">
                            <i class="bi bi-tags"></i><span>Product</span>
                        </a>
                        <ul class="submenu {{ request()->is('admin/products*') ? 'active submenu-open' : '' }}">
                            <li class="submenu-item {{ request()->is('admin/products/create') ? 'active' : '' }}">
                                <a href="{{ url('admin/products/create') }}">Add Product</a>
                            </li>
                            <li class="submenu-item {{ request()->is('admin/products') ? 'active' : '' }}">
                                <a href="{{ url('admin/products') }}">Products</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasAccess('coupons'))
                    <li
                        class="sidebar-item has-sub {{ request()->is('admin/coupons*') ? 'active submenu-open' : '' }}">
                        <a href="javascript:void(0) " class="sidebar-link">
                            <i class="bi bi-ticket-perforated"></i><span>Coupon</span>
                        </a>
                        <ul class="submenu {{ request()->is('admin/coupons*') ? 'active submenu-open' : '' }}">
                            <li class="submenu-item {{ request()->is('admin/coupons/create') ? 'active' : '' }}">
                                <a href="{{ url('admin/coupons/create') }}">Add Coupon</a>
                            </li>
                            <li class="submenu-item {{ request()->is('admin/coupons') ? 'active' : '' }}">
                                <a href="{{ url('admin/coupons') }}">Coupon</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasAccess('settings'))
                    <li
                        class="sidebar-item has-sub {{ request()->is('admin/settings*') ? 'active submenu-open' : '' }}">
                        <a href="javascript:void(0)" class="sidebar-link">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="submenu {{ request()->is('admin/settings*') ? 'active submenu-open' : '' }}">
                            <!-- Group Category -->
                            <li
                                class="submenu-item {{ request()->is('admin/settings/adminGroupCategories/create') ? 'active' : '' }}">
                                <a href="{{ url('admin/settings/adminGroupCategories/create') }}">Add Group
                                    Category</a>
                            </li>
                            <li
                                class="submenu-item {{ request()->is('admin/settings/adminGroupCategories') ? 'active' : '' }}">
                                <a href="{{ url('admin/settings/adminGroupCategories') }}">Admin Group Category</a>
                            </li>

                            <hr>

                            <!-- Admin Groups -->
                            <li
                                class="submenu-item {{ request()->is('admin/settings/adminGroups/create') ? 'active' : '' }}">
                                <a href="{{ url('admin/settings/adminGroups/create') }}">Add Admin Group</a>
                            </li>
                            <li class="submenu-item {{ request()->is('admin/settings/adminGroups') ? 'active' : '' }}">
                                <a href="{{ url('admin/settings/adminGroups') }}">Admin Groups</a>
                            </li>

                            <hr>

                            <!-- Admin Users -->
                            <li
                                class="submenu-item {{ request()->is('admin/settings/admins/create') ? 'active' : '' }}">
                                <a href="{{ url('admin/settings/admins/create') }}">Add Admin User</a>
                            </li>
                            <li class="submenu-item {{ request()->is('admin/settings/admins') ? 'active' : '' }}">
                                <a href="{{ url('admin/settings/admins') }}">Admin Users</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasAccess('orders'))
                    <li class="sidebar-item has-sub {{ request()->is('admin/orders*') ? 'active submenu-open' : '' }}">
                        <a href="javascript:void(0) " class="sidebar-link">
                            <i class="bi bi-clipboard-check"></i><span>Orders</span>
                        </a>
                        <ul class="submenu {{ request()->is('admin/orders*') ? 'active submenu-open' : '' }}">
                            <li class="submenu-item {{ request()->is('admin/orders') ? 'active' : '' }}">
                                <a href="{{ url('admin/orders') }}">Order</a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="sidebar-item">
                    <a href="{{ url('admin/logout') }}" class="sidebar-link"><i
                            class="bi bi-box-arrow-right"></i><span>Logout</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
