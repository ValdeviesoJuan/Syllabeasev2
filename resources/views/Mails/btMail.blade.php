@vite('resources/css/app.css')
<div class="w-[500px] rounded-lg">
    <div>
        <div class="m-10 pb-10 ">
            <p class="text-semibold">Dear {{$user->firstname}} {{$user->lastname}},</p>

            <p class="indent-10">I am pleased to inform you that you have been assigned to a new Bayanihan Team as a Member for Academic Year {{ $bGroup->bg_school_year }}.</p>Please log in to your account to see more details.
            <p>

            <p>Thank you for your continued dedication and service to the department.</p>

            <p class="mt-10">from,</p>
            <p>{{$chairperson->firstname}} {{$chairperson->lastname}}</p>
            <p>Chairperson, {{$department->department_name}}</p>
        </div>
    </div>
</div>