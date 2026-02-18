<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>じぶん管理</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body class="flex font-sans">

        <!-- サイドバー -->
        <div class="sidebar w-[200px] bg-[#A3E4E4] p-5 h-screen box-border">
            <h2 class="logo text-xl font-bold">じぶん管理</h2>

            <nav class="menu flex flex-col gap-2.5">
                <a href="{{ route('home') }}" class="menu-item flex items-center gap-3 px-[14px] py-3 rounded-lg text-[15px] cursor-pointer transition {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-column"></i>
                    ホーム
                </a>

                <a href="{{ route('record') }}" class="menu-item flex items-center gap-3 px-[14px] py-3 rounded-lg text-[15px] cursor-pointer transition {{ request()->routeIs('record') ? 'active' : '' }}">
                    <i class="fa-solid fa-align-justify"></i>
                    記録
                </a>
            </nav>
        </div>

        <!-- メイン表示エリア -->
        <div class="main flex-1 h-screen p-[30px] box-border overflow-hidden flex flex-col" id="app">
            @yield('content')
        </div>
    </body>
</html>
