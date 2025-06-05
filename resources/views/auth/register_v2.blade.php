<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabease</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        body {
            background-image: url('../assets/ustp-cdo.png');
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0%;
            background-attachment: fixed;
            overflow: hidden;

        }
    </style>
</head>

<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 space-y-4 md:space-y-4 sm:p-8">
                    <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                        <img class="w-52 m-auto" src="/assets/Sample/syllabease.png" alt="syllabease a syllabus management system with table of specification">
                    </a>
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Create an account
                    </h1>
                    <form class="space-y-2 md:space-y-4" action="#">
                        <div>
                            <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@ustp.edu.ph" required="">
                        </div>
                        <div class="flex">
                            <div class="w-[50%] mr-1">
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Employee Number</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0123456789" required="">
                            </div>
                            <div class="w-[50%] ml-1">
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="09123456789" required="">
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-[50%] mr-1">
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Firstname</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required="">
                            </div>
                            <div class="w-[50%] ml-1">
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Lastname</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Doe" required="">
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-[50%] mr-1">
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Prefix</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Atty., Prof., Dr." required="">
                            </div>
                            <div class="w-[50%] ml-1">
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Suffix</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Jr., Sr., PhD., M.D.s" required="">
                            </div>
                        </div>
                        <div>
                            <label for="password" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        </div>
                        <button type="submit" class="w-full text-white bg-blue   hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create an account</button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Already have an account? <a href="{{ route('login') }}" class="font-medium text-yellow hover:underline dark:text-primary-500">Sign in</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>