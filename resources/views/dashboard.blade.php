<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @livewireStyles
    <title>Todo-list</title>
</head>
<body>
    <div class="px-4 pt-[30px]">
        @livewire('pages.todo-list')
    </div>
    

    @stack('scripts')
</body>
</html>