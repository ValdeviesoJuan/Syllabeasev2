<div class=" mx-auto sm:p-2 text-gray-100 m-10 bg-gray-100 mt-4">
    <div class="">
        <!-- Search Button  -->
        <input wire:model.live="search" class="form-control border w-80 border-sePrimary rounded p-1 bg-gray-200 px-2 -mt-[100px] mb-4" type="text" placeholder="Search...">
        <button wire:click="applyFilters"><svg width="15px" height="15px" class="w-[30px] -mb-[8px] ml-1 p-[2px] h-[30px] rounded bg-blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg></button>

        <!-- Filters  -->
        <div class="float-right -mt-[15px]">
            <select wire:model="roles_filters" class="form-control border w-80 border-sePrimary rounded p-1 bg-gray-200 px-2" name="roleFilter" id="roleFilter" placeholder="Year level">
                <option value="">Roles</option>
                @foreach ($roles as $role)
                    <option value="{{$role->role_id}}">{{$role->role_name}}</option>
                @endforeach
            </select>
            <button wire:click="applyFilters" class="bg-blue text-white p-1 mt-3 px-2 hover:drop-shadow-md rounded font-semibold">Apply Filters</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-none shadow-lg  p-6 text-2xs text-left whitespace-nowrap">
                <colgroup>
                    <col class="w-5">
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col class="w-5">
                </colgroup>
                <thead>
                    <tr class="bg-blue text-white">
                        <th class="p-3">ID</th>
                        <th class="p-3">Prefix</th>
                        <th class="p-3">First Name</th>
                        <th class="p-3">Last Name</th>
                        <th class="p-3">Suffix</th>
                        <th class="p-3">Phone</th>
                        <th class="p-3">Email</th>
                        <th class="p-3 m-auto text-center">Action</th>
                        <span class="sr-only text-align-center">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="border-none text-black divide-y divide-[#e5e7eb] bg-white ">
                    @foreach ($users as $user)
                    <tr class="hover:bg-gray4 dark:hover:bg-gray-600">
                        <td class=" px-3 dark:text-gray-400 font-bold">{{ $user->id }}</td>
                        <td class="px-3 py-2">
                            <p>{{ $user->prefix }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->firstname }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->lastname }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->suffix }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->phone }}</p>
                        </td>
                        <td class="px-3 py-2">
                            <p>{{ $user->email }}</p>
                        </td>
                        <td class="flex justify-center">
                            <div class="m-auto flex inline space-x-4">
                                <button type="button" class="-mt-1 text-green font-medium text-sm edit-btn hover:scale-110 rounded-full">
                                    Edit
                                    <span class="ml-1 fas fa-angle-down rounded w-10"></span>
                                </button>

                                <ul class="dropdown-menu absolute hidden bg-white rounded shadow-lg">
                                    <li class="px-1 py-1 hover:bg-blue rounded">
                                        <a href="{{ route('admin.edit', $user->id) }}" class="dropdown-item text-black  hover:text-white">
                                            Edit Details
                                        </a>
                                    </li>
                                    <li class="px-1 py-1 hover:bg-blue rounded">
                                        <a href="{{ route('admin.editRoles', $user->id) }}" class="dropdown-item text-black hover:bg-blue hover:text-white">
                                            Edit Roles
                                        </a>
                                    </li>
                                </ul>

                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="mt-3 text-red font-medium hover:text-white hover:scale-110 text-sm rounded-lg" type="submit">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                        
                    </tr>

                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 mb-1">
                <div class="flex justify-center">
                    <span class="text-gray-600 text-sm">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>
                </div>
                {{ $users->links() }} <!-- Pagination links -->
            </div>
        </div>
    </div>
</div>