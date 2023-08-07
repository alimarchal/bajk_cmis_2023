<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="{{route('customer.create')}}" class="nav-link @if(request()->routeIs('customer.*')) active @endif ">
            Borrower Profile
        </a>
    </li>

    <li class="nav-item">
        <a href="javascript: void(0)" class="nav-link @if(request()->routeIs('guarantee.*')) active @endif  ">Personal Guarantee</a>
    </li>
    <li class="nav-item">
        <a href="javascript: void(0)" class="nav-link @if(request()->routeIs('otherGuarantee.*')) active @endif  ">Other Guarantee</a>
    </li>
    <li class="nav-item">
        <a href="javascript: void(0)" class="nav-link @if(request()->routeIs('insurance.*')) active @endif  ">Insurance</a>
    </li>

    <li class="nav-item">
        <a href="javascript: void(0)" class="nav-link @if(request()->routeIs('insuranceClaim.*')) active @endif  ">Claim Outstanding</a>
    </li>

    <li class="nav-item">
        <a href="javascript: void(0)" class="nav-link  @if(request()->routeIs('litigation.*')) active @endif  ">Litigation</a>
    </li>

    <li class="nav-item">
        <a href="javascript: void(0)" class="nav-link  @if(request()->routeIs('installment.*')) active @endif  ">Installment</a>
    </li>



    <li class="nav-item">
        <a href="javascript: void(0)" class="nav-link  @if(request()->routeIs('markUpDetails.*')) active @endif  ">Mark-up Details</a>
    </li>

    <li class="nav-item">
        <a href="javascript: void(0)" class="nav-link  @if(request()->routeIs('interest.*')) active @endif  ">Interest</a>
    </li>




</ul>
