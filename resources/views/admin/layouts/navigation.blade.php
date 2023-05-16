<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{(Route::currentRouteName() == 'dashboard') ? 'active' : ''}}">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>
    @if (Auth::user()->role == 'Super Admin')
    <!-- Super Admin Panel -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Super Admin Panel</span>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'default.setting' || Route::currentRouteName() == 'mail.setting' || Route::currentRouteName() == 'sms.setting') ? 'active open' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-dock-top"></i>
            <div data-i18n="Account Settings">Settings</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'default.setting') ? 'active' : ''}}">
                <a href="{{ route('default.setting') }}" class="menu-link">
                    <div data-i18n="Default Setting">Default Setting</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'mail.setting') ? 'active' : ''}}">
                <a href="{{ route('mail.setting') }}" class="menu-link">
                    <div data-i18n="Mail Setting">Mail Setting</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'sms.setting') ? 'active' : ''}}">
                <a href="{{ route('sms.setting') }}" class="menu-link">
                    <div data-i18n="Sms Setting">Sms Setting</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'stock.report' || Route::currentRouteName() == 'expense.report' || Route::currentRouteName() == 'purchase.report' || Route::currentRouteName() == 'selling.report') ? 'active open' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
            <div data-i18n="Report">Report</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'stock.report') ? 'active' : ''}}">
            <a href="{{ route('stock.report') }}" class="menu-link">
                <div data-i18n="Stock Report">Stock Report</div>
            </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'expense.report') ? 'active' : ''}}">
            <a href="{{ route('expense.report') }}" class="menu-link">
                <div data-i18n="Expense Report">Expense Report</div>
            </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'purchase.report') ? 'active' : ''}}">
            <a href="{{ route('purchase.report') }}" class="menu-link">
                <div data-i18n="Purchase Report">Purchase Report</div>
            </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'selling.report') ? 'active' : ''}}">
            <a href="{{ route('selling.report') }}" class="menu-link">
                <div data-i18n="Selling Report">Selling Report</div>
            </a>
            </li>
        </ul>
    </li>
    @endif
    @if (Auth::user()->role != 'Manager')
    <!-- Admin Panel -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Admin Panel</span>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'all.administrator') ? 'active open' : ''}}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
            <div data-i18n="Administrator">Administrator</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
            <a href="{{ route('register') }}" class="menu-link">
                <div data-i18n="Register">Register</div>
            </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'all.administrator') ? 'active' : ''}}">
            <a href="{{ route('all.administrator') }}" class="menu-link">
                <div data-i18n="All Administrator">All Administrator</div>
            </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'all.contact.message') ? 'active' : ''}}">
        <a href="{{ route('all.contact.message') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="All Contact Message">All Contact Message</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'expense-category.index') ? 'active' : ''}}">
        <a href="{{ route('expense-category.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Expense Category">Expense Category</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'staff-designation.index') ? 'active' : ''}}">
        <a href="{{ route('staff-designation.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Staff Designation">Staff Designation</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'branch.index') ? 'active' : ''}}">
        <a href="{{ route('branch.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Branch">Branch</div>
        </a>
    </li>
    @endif
    <!-- Branch Panel -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Branch Panel</span>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'staff.index' || Route::currentRouteName() == 'staff.salary') ? 'active open' : ''}}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-box"></i>
            <div data-i18n="Staff Interface">Staff Interface</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'staff.index') ? 'active' : ''}}">
                <a href="{{ route('staff.index') }}" class="menu-link">
                    <div data-i18n="Staff List">Staff List</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'staff.salary') ? 'active' : ''}}">
                <a href="{{ route('staff.salary') }}" class="menu-link">
                    <div data-i18n="Staff Salary">Staff Salary</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'supplier.index') ? 'active' : ''}}">
        <a href="{{ route('supplier.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Supplier">Supplier</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'customer.index') ? 'active' : ''}}">
        <a href="{{ route('customer.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Customer">Customer</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'expense.index') ? 'active' : ''}}">
        <a href="{{ route('expense.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Expense">Expense</div>
        </a>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'category.index' || Route::currentRouteName() == 'brand.index' || Route::currentRouteName() == 'unit.index' || Route::currentRouteName() == 'product.index') ? 'active open' : ''}}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-box"></i>
            <div data-i18n="Product Interface">Product Interface</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'category.index') ? 'active' : ''}}">
                <a href="{{ route('category.index') }}" class="menu-link">
                    <div data-i18n="Category">Category</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'brand.index') ? 'active' : ''}}">
                <a href="{{ route('brand.index') }}" class="menu-link">
                    <div data-i18n="Brand">Brand</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'unit.index') ? 'active' : ''}}">
                <a href="{{ route('unit.index') }}" class="menu-link">
                    <div data-i18n="Unit">Unit</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'product.index') ? 'active' : ''}}">
                <a href="{{ route('product.index') }}" class="menu-link">
                    <div data-i18n="Product">Product</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'purchase.product' || Route::currentRouteName() == 'purchase.list') ? 'active open' : ''}}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-box"></i>
            <div data-i18n="Purchase Interface">Purchase Interface</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'purchase.product') ? 'active' : ''}}">
                <a href="{{ route('purchase.product') }}" class="menu-link">
                    <div data-i18n="Purchase Product">Purchase Product</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'purchase.list') ? 'active' : ''}}">
                <a href="{{ route('purchase.list') }}" class="menu-link">
                    <div data-i18n="Purchase List">Purchase List</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'selling.product' || Route::currentRouteName() == 'selling.list') ? 'active open' : ''}}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-box"></i>
            <div data-i18n="Selling Interface">Selling Interface</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{(Route::currentRouteName() == 'selling.product') ? 'active' : ''}}">
                <a href="{{ route('selling.product') }}" class="menu-link">
                    <div data-i18n="Selling Product">Selling Product</div>
                </a>
            </li>
            <li class="menu-item {{(Route::currentRouteName() == 'selling.list') ? 'active' : ''}}">
                <a href="{{ route('selling.list') }}" class="menu-link">
                    <div data-i18n="Selling List">Selling List</div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item {{(Route::currentRouteName() == 'stock.products') ? 'active' : ''}}">
        <a href="{{ route('stock.products') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Stock Products">Stock Products</div>
        </a>
    </li>
</ul>
