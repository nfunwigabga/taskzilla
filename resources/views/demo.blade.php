<!DOCTYPE html>
<html class="h-full bg-zinc-100 scroll-smooth antialiased" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Taskzilla</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="h-full bg-zinc-100 font-sans antialiased">
<div class="bg-white h-full">
    <main>
        <!-- Hero section -->
        <div class="overflow-hidden pt-8 sm:pt-12 lg:relative lg:py-48">
            <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-24 lg:px-8">
                <div>
                    <div class="bg-gray-800 inline-block rounded-lg p-2">
                        <img class="h-11 w-auto" src="/logo.png"
                             alt="Your Company">
                    </div>
                    <div class="mt-20">
                        <div>
                            <a href="#" class="inline-flex space-x-4">
                                <span class="rounded bg-gray-900 px-2.5 py-1 text-base font-semibold text-white">
                                    Powered by:
                                </span>
                                <span class="inline-flex items-center text-base font-bold space-x-4 text-rose-500">
                                    <span>Laravel 10</span>
                                    <span class="text-green-700"> Vue.js 3 </span>
                                    <span class="text-indigo-700">Inertia.js 1.0</span>
                                </span>
                            </a>
                        </div>
                        <div class="mt-6 sm:max-w-xl">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-500">
                                The Simple <span class="text-gray-700">Task Management Tool</span> for your team
                            </h1>
                            <p class="mt-6 text-xl text-gray-500">
                                It's simple and straight to the point! A Lite Version of Asana!
                            </p>
                        </div>
                        <div class="mt-12 sm:flex sm:w-full sm:max-w-lg">
                            <a href="/" target="_blank"
                               class="block w-full text-center rounded-md border border-transparent bg-rose-500 px-5 py-3 text-base font-medium text-white shadow hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 sm:px-10">
                                Visit the Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sm:mx-auto sm:max-w-3xl sm:px-6">
                <div class="py-12 sm:relative sm:mt-12 sm:py-16 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                    <div class="hidden sm:block">
                        <div class="absolute inset-y-0 left-1/2 w-screen rounded-l-3xl bg-gray-50 lg:left-80 lg:right-0 lg:w-full"></div>
                        <svg class="absolute top-8 right-1/2 -mr-3 lg:left-0 lg:m-0" width="404" height="392"
                             fill="none" viewBox="0 0 404 392">
                            <defs>
                                <pattern id="837c3e70-6c3a-44e6-8854-cc48c737b659" x="0" y="0" width="20" height="20"
                                         patternUnits="userSpaceOnUse">
                                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                </pattern>
                            </defs>
                            <rect width="404" height="392" fill="url(#837c3e70-6c3a-44e6-8854-cc48c737b659)" />
                        </svg>
                    </div>
                    <div class="relative -mr-40 pl-4 sm:mx-auto sm:max-w-3xl sm:px-0 lg:h-full lg:max-w-none lg:pl-12">
                        <img class="w-full rounded-md shadow-xl ring-1 ring-black ring-opacity-5 lg:h-full lg:w-auto lg:max-w-none"
                             src="/demoresources/OverviewDashboard.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
