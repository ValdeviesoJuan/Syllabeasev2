<form action="{{ route('bayanihanleader.storeCrq', $syll_id) }}" method="POST">
    @csrf
    <div class="m-5 mx-14">
        <textarea class="h-32" name="syll_course_requirements" id="myeditorinstance">Course Requirements</textarea>
    </div>
    <div class="flex justify-end">
        <button type="submit" class="bg-blue p-2 text-white rounded-lg m-5">Create Syllabus</button>
    </div>
</form>