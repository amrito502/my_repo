@php
    $currentRouteName = Route::currentRouteName();

    // echo  $currentRouteName;
@endphp

<aside id="leftsidebar" class="sidebar">
    {{-- <div class="user-info">
        <div class="info-container">
            <div class="name">{{ Auth::user()->name }}</div>
            <div class="email">{{ Auth::user()->email }}</div>
        </div>
    </div> --}}
    <div class="menu">
        <ul class="list">

            @php
                $userRole = Auth::user()->role;
            @endphp

            <li class="{{ $currentRouteName == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/images/icons/dashboard.png') }}" alt="">
                    <span>Dashboard</span>
                </a>
            </li>

            @if ($userRole == '1')
                <li class="{{ $currentRouteName == 'instructor.index' || $currentRouteName == 'instructor.create' || $currentRouteName == 'instructor.edit' ? 'active' : '' }}" : class="">
                    <a href="javascript:void(0);"
                        class="menu-toggle">
                        <img src="{{ asset('assets/images/icons/teacher.png') }}" alt="">
                        <span>Teachers</span>
                    </a>
                    <ul class="ml-menu" {{ $currentRouteName == 'instructor.index' || $currentRouteName == 'instructor.create' || $currentRouteName == 'instructor.edit' ? `style="display: block"` : '' }}>
                        <li class="{{ $currentRouteName == 'instructor.index' ? 'active' : '' }}"><a href="{{ route('instructor.index') }}">All Teachers</a></li>
                        <li class="{{ $currentRouteName == 'instructor.create' ? 'active' : '' }}"><a href="{{ route('instructor.create') }}">Add New</a></li>
                    </ul>
                </li>
            @endif

            <li class="{{ $currentRouteName == 'class.index' || $currentRouteName == 'class.create' || $currentRouteName == 'section.edit' ? 'active' : '' }}" : class="">
                <a href="javascript:void(0);" class="menu-toggle">
                    <img src="{{ asset('assets/images/icons/class.png') }}" alt="">
                    <span>Classes</span>
                </a>
                <ul class="ml-menu" {{ $currentRouteName == 'class.index' || $currentRouteName == 'class.create' || $currentRouteName == 'section.edit' ? `style="display: block"` : '' }}>
                    <li class="{{ $currentRouteName == 'class.index' ? 'active' : '' }}"><a href="{{ route('class.index') }}">All Classes</a></li>
                    @if($userRole == '1')
                    <li class="{{ $currentRouteName == 'class.create' ? 'active' : '' }}"><a href="{{ route('class.create') }}">Add New</a></li>
                    @endif
                </ul>
            </li>

            <li class="{{ $currentRouteName == 'section.index' || $currentRouteName == 'section.create' || $currentRouteName == 'section.edit' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <img src="{{ asset('assets/images/icons/section.png') }}" alt="">
                    <span>Branch</span>
                </a>
                <ul class="ml-menu" {{ $currentRouteName == 'section.index' || $currentRouteName == 'section.create' || $currentRouteName == 'section.edit' ? `style="display: block"` : '' }}>
                    <li class="{{ $currentRouteName == 'section.index' ? 'active' : '' }}"><a href="{{ route('section.index') }}">All Branch</a></li>
                    @if($userRole == '1')
                    <li class="{{ $currentRouteName == 'section.create' ? 'active' : '' }}"><a href="{{ route('section.create') }}">Add New</a></li>
                    @endif
                </ul>
            </li>


            <li class="{{ $currentRouteName == 'subject.index' || $currentRouteName == 'subject.create' || $currentRouteName == 'subject.edit' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <img src="{{ asset('assets/images/icons/subject.png') }}" alt="">
                    <span>Subjects</span>
                </a>
                <ul class="ml-menu" {{ $currentRouteName == 'subject.index' || $currentRouteName == 'subject.create' || $currentRouteName == 'subject.edit' ? `style="display: block"` : '' }}>
                    <li class="{{ $currentRouteName == 'subject.index' ? 'active' : '' }}"><a href="{{ route('subject.index') }}">All Subjects</a></li>
                    <li class="{{ $currentRouteName == 'subject.create' ? 'active' : '' }}"><a href="{{ route('subject.create') }}">Add New</a></li>
                </ul>
            </li>



            @if ($userRole == '1' || $userRole == '2')
                <li class="{{ $currentRouteName == 'student.index' || $currentRouteName == 'student.create' || $currentRouteName == 'student.edit' || $currentRouteName == 'student.view' ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <img src="{{ asset('assets/images/icons/students.png') }}" alt="">
                        <span>Students</span>
                    </a>
                    <ul class="ml-menu" {{ $currentRouteName == 'student.index' || $currentRouteName == 'student.create' || $currentRouteName == 'student.edit' ? `style="display: block"` : '' }}>
                        <li class="{{ $currentRouteName == 'student.index' ? 'active' : '' }}"><a href="{{ route('student.index') }}">All Students</a></li>
                        <li class="{{ $currentRouteName == 'student.create' ? 'active' : '' }}"><a href="{{ route('student.create') }}">Add New</a></li>
                    </ul>
                </li>
            @endif

            <li class="{{ $currentRouteName == 'attendance.index' || $currentRouteName == 'attendance.show' || $currentRouteName == 'attendance.store' || $currentRouteName == 'attendance.edit' ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <img src="{{ asset('assets/images/icons/attendance.png') }}" alt="">
                    <span>Attendance</span>
                </a>
                <ul class="ml-menu" {{ $currentRouteName == 'attendance.index' || $currentRouteName == 'attendance.show' || $currentRouteName == 'attendance.store' || $currentRouteName == 'attendance.edit' ? `style="display: block"` : '' }}>
                    <li class="{{ $currentRouteName == 'attendance.show' || $currentRouteName == 'attendance.edit' ? 'active' : '' }}"><a href="{{ route('attendance.show') }}">All Attendance</a></li>
                    <li class="{{ $currentRouteName == 'attendance.index' || $currentRouteName == 'attendance.store' ? 'active' : '' }}"><a href="{{ route('attendance.index') }}">Call The Roll</a></li>
                </ul>
            </li>

            <li class="{{ $currentRouteName == 'exam.index' || $currentRouteName == 'exam.create' || $currentRouteName == 'exam.mark' || $currentRouteName == 'exam.edit' || $currentRouteName == 'exam.view'  ? 'active' : '' }}"> <a href="javascript:void(0);"
                    class="menu-toggle"><img src="{{ asset('assets/images/icons/exam.png') }}" alt=""><span>Exam</span></a>
                <ul class="ml-menu" {{ $currentRouteName == 'exam.index' || $currentRouteName == 'exam.create' || $currentRouteName == 'exam.edit' || $currentRouteName == 'exam.mark' || $currentRouteName == 'exam.view' ? `style="display: block"` : '' }}>
                    <li class="{{ $currentRouteName == 'exam.index' || $currentRouteName == 'exam.edit' || $currentRouteName == 'exam.mark' || $currentRouteName == 'exam.view' ? 'active' : '' }}"><a href="{{ route('exam.index') }}">All Exam</a></li>
                    @if ($userRole == '1')
                    <li class="{{ $currentRouteName == 'exam.create' ? 'active' : '' }}"><a href="{{ route('exam.create') }}">Add New</a></li>
                    @endif
                    {{-- <li><a href="{{ route('exam.mark') }}">Mark</a></li> --}}
                </ul>
            </li>


            {{-- @can('view_role')
                <li class="{{ @$navUserParentActiveClass }} open" : class=""> <a href="javascript:void(0);"
                        class="menu-toggle"><i class="zmdi zmdi-pin-assistant"></i><span>Role & Permissions</span></a>
                    <ul class="ml-menu ">
                        <li><a href="{{ route('role.index') }}">Manage Role</a></li>
                        @can('add_role')
                            <li><a href="{{ route('role.create') }}">Add Role</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}

            @if ($userRole == '1')
            <li class="{{ $currentRouteName == 'user.index' || $currentRouteName == 'user.create' || $currentRouteName == 'user.edit' ? 'active' : '' }}"> <a href="javascript:void(0);"
                    class="menu-toggle"> <img src="{{ asset('assets/images/icons/users.png') }}" alt=""> <span>Users</span></a>
                <ul class="ml-menu" {{ $currentRouteName == 'user.index' || $currentRouteName == 'user.create' || $currentRouteName == 'user.edit' ? `style="display: block"` : '' }}>
                    <li class="{{ $currentRouteName == 'user.index' ? 'active' : '' }}"><a href="{{ route('user.index') }}">User Manage</a></li>

                    <li class="{{ $currentRouteName == 'user.create' ? 'active' : '' }}"><a href="{{ route('user.create') }}">User add</a></li>

                </ul>
            </li>
            @endif

            @if ($userRole == '1')
            <li class="{{ $currentRouteName == 'send-sms-form' || $currentRouteName == 'show-sms-history' ? 'active' : ''}}"> <a href="javascript:void(0);"
                    class="menu-toggle"> <img src="{{ asset('assets/images/icons/users.png') }}" alt=""> <span>SMS</span></a>
                <ul class="ml-menu" {{ $currentRouteName == 'send-sms-form' || $currentRouteName == 'show-sms-history' ? `style="display: block"` : '' }}>
                    <li class="{{ $currentRouteName == 'send-sms-form' ? 'active' : '' }}"><a href="{{ route('send-sms-form') }}">Send SMS</a></li>

                    <li class="{{ $currentRouteName == 'show-sms-history' ? 'active' : '' }}"><a href="{{ route('show-sms-history') }}">SMS Logs</a></li>

                </ul>
            </li>
            @endif

            {{-- @can('view_student_assgin')
                <li class="{{ @$leftAssginParentActiveClass }} open" : class=""> <a href="javascript:void(0);"
                        class="menu-toggle"><i class="zmdi zmdi-assignment-account"></i><span>Assgin</span></a>
                    <ul class="ml-menu ">
                        <li><a href="{{ route('assgin.index') }}">Assgin Manage</a></li>
                    </ul>
                </li>
            @endcan --}}

            {{-- <li class="{{ @$leftAttendanceParentActiveClass }} open" : class=""> <a href="javascript:void(0);"
                    class="menu-toggle"><i class="zmdi zmdi-pin-account"></i><span>Mark</span></a>
                <ul class="ml-menu ">
                    <li><a href="{{ route('admin.student.mark') }}">Show Mark</a></li>
                    <li><a href="{{ route('attendance.show') }}">Add Mark</a></li>
                    <li><a href="{{ route('attendance.show') }}">Mark List</a></li>
                </ul>

            </li> --}}

            <!-- <li> <a href="widgets.html"><i class="zmdi zmdi-delicious"></i><span>Widgets</span> </a> </li>
            <li><a href="mail-inbox.html"><i class="zmdi zmdi-email"></i><span>Inbox</span> </a></li>
            <li><a href="blog-dashboard.html"><i class="zmdi zmdi-blogger"></i><span>Blogger</span> </a></li>
            <ul class="ml-menu">
                <li> <a href="ec-dashboard.html">Dashboard</a></li>
                <li> <a href="ec-product.html">Product</a></li>
                <li> <a href="ec-product-List.html">Product List</a></li>
                <li> <a href="ec-product-detail.html">Product detail</a></li>
            </ul>
            </li> -->
        </ul>


    </div>
    <!-- #Menu -->
</aside>
