<!--- Sidemenu -->
<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" >Menu</li>

        <li>
            <a href="{{ route('home') }}" class="waves-effect">
                <i class="bx bx-home-circle"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if(auth()->user()->role->name === config('constants.roles.haist_admin'))
            <li>
                <a href="{{ route('categories.index') }}" class="waves-effect">
                    <i class="bx bx-box"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li>
                <a href="{{ route('symptoms.index') }}" class="waves-effect">
                    <i class="fa fa-virus"></i>
                    <span>Symptoms</span>
                </a>
            </li>
            <li>
                <a href="{{ route('facilities.index') }}" class="waves-effect">
                    <i class="bx bx-building"></i>
                    <span>Facilities</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admins.index') }}" class="waves-effect">
                    <i class="bx bx-user-circle"></i>
                    <span>Admins</span>
                </a>
            </li>
            <li>
                <a href="{{ route('diseases.index') }}" class="waves-effect">
                    <i class="fa fa-stethoscope"></i>
                    <span>Disease</span>
                </a>
            </li>
            <li>
                <a href="{{ route('criteria.index') }}" class="waves-effect">
                    <i class="fa fa-stethoscope"></i>
                    <span>Disease Criteria</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tests.index') }}" class="waves-effect">
                    <i class="fa fa-stethoscope"></i>
                    <span>Tests</span>
                </a>
            </li>
        @elseif(auth()->user()->role->name === config('constants.roles.admin'))
            <li>
                <a href="{{ route('home.compare-facilities') }}" class="waves-effect">
                    <i class="bx bx-box"></i>
                    <span>Compare Facilities</span>
                </a>
            </li>
            <li>
                <a href="{{ route('managers.index') }}" class="waves-effect">
                    <i class="bx bx-box"></i>
                    <span>Managers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('nurses.index') }}" class="waves-effect">
                    <i class="bx bx-box"></i>
                    <span>Nurses</span>
                </a>
            </li>
        @elseif(auth()->user()->role->name === config('constants.roles.manager'))
            <li>
                <a href="{{ route('doctors.index') }}" class="waves-effect">
                    <i class="bx bx-heart"></i>
                    <span>Doctors</span>
                </a>
            </li>
            <li>
                <a href="{{ route('residents.index') }}" class="waves-effect">
                    <i class="bx bx-user"></i>
                    <span>Residents</span>
                </a>
            </li>
            <li>
                <a href="{{ route('assessments.index') }}" class="waves-effect">
                    <i class="bx bx-box"></i>
                    <span>Assessments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('assessment-tests.index') }}" class="waves-effect">
                    <i class="bx bx-box"></i>
                    <span>Tests</span>
                </a>
            </li>
        @endif

    </ul>
</div>
<!-- Sidebar -->
