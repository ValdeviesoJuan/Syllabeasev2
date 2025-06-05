<div style="width:500px; border-radius:0.5rem;">
    <div>
        <div style="margin: 2.5rem; padding-bottom: 2.5rem;">
        <div></div>
            <!-- <img src="{{ asset('assets/sample/syllabease.png') }}" alt="Header Image" style="width: 100%; margin-bottom: 1.5rem;"> -->
            <p style="font-weight: bold;">Dear {{$user->firstname}} {{$user->lastname}},</p>

            <p style="text-indent: 2rem;">I am pleased to inform you that you have been assigned to a new Bayanihan Team as a Leader for the school year {{ $bGroup->bg_school_year }}. Please log in to your account to see more details.</p>
            <p>Thank you for your continued dedication and service to the department.</p>

            <p style="margin-top: 1.5rem;">from,</p>
            <p>{{$chairperson->firstname}} {{$chairperson->lastname}}</p>
            <p>Chairperson, {{$department->department_name}}</p>
        </div>
    </div>
</div>