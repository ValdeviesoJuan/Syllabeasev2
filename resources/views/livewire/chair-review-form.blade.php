<div class="flex justify-center w-screen h-[600px] fixed overflow-y-auto rounded  mb-10">
    <div class="">
        <button wire:click="openComments" class="rounded bg-green2 text-green px-3 py-3">
            <div class="flex">
                <div class="mr-2">
                    <svg width="20px" height="20px" viewBox="0 -0.5 28 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                            <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-154.000000, -621.000000)" fill="#31a858">
                                <path d="M168,624.695 L179.2,641.99 L156.8,641.99 L168,624.695 L168,624.695 Z M156.014,643.995 L180.018,643.995 C182.375,643.995 182.296,642.608 181.628,641.574 L169.44,622.555 C168.882,621.771 167.22,621.703 166.56,622.555 L154.372,641.574 C153.768,642.703 153.687,643.995 156.014,643.995 L156.014,643.995 Z M181,645.998 L155,645.998 C154.448,645.998 154,646.446 154,646.999 C154,647.552 154.448,648 155,648 L181,648 C181.552,648 182,647.552 182,646.999 C182,646.446 181.552,645.998 181,645.998 L181,645.998 Z" id="open" sketch:type="MSShapeGroup">
                                </path>
                            </g>
                        </g>
                    </svg>
                </div>
                <span class="font-sans text">Open Syllabus Review Form</span>
            </div>
        </button>
    </div>
    @if($isOpen)
    <div id="" class="flex flex-col border  border-gray3 top-0 absolute bg-white bg-opacity-100  h-max rounded shadow-lg font-sans overflow-y-auto">
        <div class=" justify-center items-center min-h-[300px] mx-10 mb-10">
            <div class="flex justify-between mt-5">
                <div class="text-2xl font-semibold mb-5">
                    Syllabus Review Form
                </div>
                <div class="flex justify-center items-center rounded-full hover:bg-gray3 w-[25px] h-[25px]">
                    <button wire:click="closeComments">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#0F0F0F" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-2 grid-rows-2 mb-5">
                <div>
                    Course Code:
                </div>
                <div>
                    Sem and Year:
                </div>
                <div>
                    Descriptive Title:
                </div>
                <div>
                    Faculty:
                </div>
            </div>
            <div class="w-[900px] h-11/12 bg-white bg-white bg-opacity-100">
                <div>
                    <p>
                        <span class="font-semibold">Directions:</span> Check the column <span class="font-semibold">YES</span> if an indicator is observed in the syllabus and check column NO if otherwise. Provide clear and constructive remarks that would help improve the content and alignment of the syllabus.
                    </p>
                </div>
                <table id="review_form_table">
                    <form action="{{ route('chairperson.returnSyllabus', $syll_id) }}" method="POST">
                        @csrf
                        <thead>
                            <tr class="">
                                <th class="w-[600px]">Indicators</th>
                                <th class="w-[100px]">Yes/No</th>
                                <th class="w-[200px]">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr colspan-3 class="part">
                                <td class="font-semibold">PART I. BASIC SYLLABUS INFORMATION</td>
                            </tr>
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.0" name="srf_no[]" value="1">
                                <td>1. The syllabus follows the prescribed OBE syllabus format of the University and include the following:</td>
                                <td class="checkbox-cell"> <input  name="srf_yes_no[]"class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea name="srf_remarks[]" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 1.1  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.1" name="srf_no[]" value="1.1">
                                <td class="ones">• Name of the College/Campus is indicated below the University name/brand.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.1" name="srf_yes_no[]" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.1" name="srf_remarks[]" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 1.2  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.2" name = "srf_no[]" value="1.2">
                                <td class="ones">• Program, Course Title, Course Code and Unit Credits are specified in the syllabus.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.2" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.2" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 1.3  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.3" value="1.3">
                                <td class="ones">• Pre-requisites and co-requisites are indicated.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.3" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.3" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 1.4  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.4" value="1.4">
                                <td class="ones">• Semester, Academic Year, Schedule of Course, Building and Room Number are stipulated in the syllabus.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.4" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.4" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 1.5  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.5" value="1.5">
                                <td class="ones">• Contact details of the instructor such as the instructor’s name, email address OR mobile number (optional) are specified in the syllabus.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.5" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.5" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 1.6  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.6" value="1.6">
                                <td class="ones">• Instructor’s consultation schedules, oﬃce or consultation venue, oﬃce phone number is indicated in the syllabus.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.6" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.6" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 1.7  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.7" value="1.7">
                                <td class="ones">• The University’s Vision and Mission are indicated in the syllabus.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.7" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.7" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>

                            <!-- 2  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.8" value="2">
                                <td class="">2. The course description stipulates its relevance to the curriculum in general and provides an overview of the course content.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.8" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.8" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>

                            <tr class="part">
                                <td colspan="3" class="font-semibold">PART II. PROGRAM EDUCATIONAL OBJECTIVES (or General Outcomes for Gen Ed courses)</td>
                            </tr>
                            <!-- 3  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.9" value="3">
                                <td class="">3. The Approved Program Educational Objectives (PEO) and Program Outcomes (PO) are listed with alphabets in the syllabus (which will be referred to in the mapping of the course outcomes).</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.9" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.9" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>


                            <tr colspan-3 class="part">
                                <td class="font-semibold">PART III.</td>
                            </tr>
                            <!-- 4  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.10" value="4">
                                <td class="">4. The course outcomes are measurable and aligned with the course description and program outcomes.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.10" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.10" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 5  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.11" value="5">
                                <td class="">5. The course outcomes are mapped accordingly to the program outcomes/GELOs using the markers: i - introductory, e - enabling, and d - demonstrative.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.11" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.11" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>

                            <tr colspan-3 class="part">
                                <td class="font-semibold">PART IV.</td>
                            </tr>
                            <!-- 6  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.12" value="6">
                                <td class="">6. The course outline indicates the number of hours.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.12" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.12" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 7  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.13" value="7">
                                <td class="">7. Topics are assigned to intended learning outcomes (ILO).</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.13" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.13" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 8  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.14" value="8">
                                <td class="">8. Suggested readings are provided.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.14" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.14" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 9  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.15" value="9">
                                <td class="">9. The Teaching-Learning Activities (TLAs) are indicated in the outline.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.15" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.15" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 10  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.16" value="10">
                                <td class="">10. Assessment tools are indicated.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.16" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.16" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 11  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.17" value="11">
                                <td class="">11. Rubrics are attached for all outputs/requirements.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.17" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.17" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>
                            <!-- 12  -->
                            <tr class="">
                                <input type="hidden" wire:model="srf_no.18" value="12">
                                <td class="">12. The grading criteria are clearly stated in the syllabus.</td>
                                <td class="checkbox-cell"> <input wire:model="srf_yes_no.18" class="h-6 w-6" type="checkbox"></td>
                                <td class=""><textarea wire:model="srf_remarks.18" name="" id="" cols="30" rows="3"></textarea></td>
                            </tr>

                        </tbody>
                </table>
            </div>
            <!-- <form wire:submit.prevent="returnSyllabus" method="POST"> -->
            <input type="hidden" wire:model="syll_id">
            <div class="py-2 bg-pink text-red w-[150px] rounded flex justify-center items-center">
                <button class="pt-0.5" type="submit">
                    <div class="flex">
                        <svg width="25px" height="25px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.9998 8L6 14L12.9998 21" stroke="#fb6a5e" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 14H28.9938C35.8768 14 41.7221 19.6204 41.9904 26.5C42.2739 33.7696 36.2671 40 28.9938 40H11.9984" stroke="#fb6a5e" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div>
                            Return for Revision
                        </div>
                    </div>

                </button>
            </div>
            </form>
            <form wire:submit.prevent="duplicateSyllabus" method="POST">
                <input type="hidden" wire:model="syll_id">
                <div class="py-2 bg-green2 text-green w-[150px] rounded flex justify-center items-center">
                    <button class="" type="submit">
                        <div class="flex">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#31a858" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div>
                                Approve
                            </div>
                        </div>

                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>