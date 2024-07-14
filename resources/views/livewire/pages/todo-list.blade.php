<div>
    <div class="{{ $isDialogOpen | $isConnexionOpen ? 'filter blur-sm' : '' }} transition-all duration-300 min-h-screen">
        <div class="max-w-[600px] w-full mx-auto flex flex-col gap-6 items-start">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-end gap-1">
                    <img src="/logo.svg" alt="" class="w-[30px]">
                </div>
                <div class="relative" x-data="{ open: @entangle('isMenuOpen') }">
                    <button @click="open = !open" class="flex items-center">
                        <img src="{{auth()->user()->image}}" alt="Avatar" class="w-8 h-8 rounded-full">
                    </button>
                    <div class=" absolute flex gap-2 flex-col right-0 w-[100px] bg-white p-2 rounded-lg border border-solid border-gray-200 shadow-md" x-show="open" @click.away="$wire.closeMenu()">
                        <button class="text-[14px] py-[6px] w-full hover:bg-gray-100 rounded-md ">Settings</button>
                        <button class="text-[14px] py-[6px] w-full hover:bg-gray-100 rounded-md" wire:click="logout">Logout</button>
                    </div>
                </div>
                
            </div>
            
            <hr class="w-full" />
            <div class="flex justify-between items-center w-full">
                <button class="flex gap-2 items-center" wire:click="openDialog">
                    <div class="w-[18px] h-[18px] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 30 30">
                            <path d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M20,16h-4v4 c0,0.553-0.448,1-1,1s-1-0.447-1-1v-4h-4c-0.552,0-1-0.447-1-1s0.448-1,1-1h4v-4c0-0.553,0.448-1,1-1s1,0.447,1,1v4h4 c0.552,0,1,0.447,1,1S20.552,16,20,16z"></path>
                        </svg>
                    </div> 
                    <div class="text-[14px] font-medium">New Task</div>
                </button>
                <input class="h-[36px] max-w-[200px] w-full bg-gray-50 border border-solid border-gray-100 rounded-md px-3 focus:outline-gray-200" type="text" placeholder="search tasks..." wire:model.debounce.300ms="searchTerm">
            </div>
            <hr class="w-full" />
            @if($tasks->isEmpty())
            <div class="w-full flex flex-col items-center gap-4 justify-center py-8 mx-auto">
                <img src="/error-image.svg" alt="" class="w-[300px] h-auto">
                <p class="text-[16px] text-center max-w-[300px]">No tasks available, Enjoy your day</p>
            </div>
                
            @else
                <div class="flex flex-col gap-2 w-full">
                    @foreach($tasks as $task)
                        <div class="flex flex-col gap-1 p-4 border border-solid border-stone-300 rounded-lg w-full">
                            <div class="flex items-center justify-center justify-between">
                                <div class="flex items-center gap-2">
                                    <input type="radio" wire:click='toggleTaskStatus({{$task->id}})' >
                                    <h2 class="text-[16px] font-semibold">{{ $task->title }}</h2>
                                </div>
                                <div class="flex items-center gap-5">
                                    <div class="flex items-center justify-center cursor-pointer" wire:click='deleteTask({{$task->id}})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                                            <path d="M21 6.73C20.98 6.73 20.95 6.73 20.92 6.73C15.63 6.2 10.35 6 5.12 6.53L3.08 6.73C2.66 6.77 2.29 6.47 2.25 6.05C2.21 5.63 2.51 5.27 2.92 5.23L4.96 5.03C10.28 4.49 15.67 4.7 21.07 5.23C21.48 5.27 21.78 5.64 21.74 6.05C21.71 6.44 21.38 6.73 21 6.73Z" fill="#292D32"/>
                                            <path d="M8.5 5.72C8.46 5.72 8.42 5.72 8.37 5.71C7.97 5.64 7.69 5.25 7.76 4.85L7.98 3.54C8.14 2.58 8.36 1.25 10.69 1.25H13.31C15.65 1.25 15.87 2.63 16.02 3.55L16.24 4.85C16.31 5.26 16.03 5.65 15.63 5.71C15.22 5.78 14.83 5.5 14.77 5.1L14.55 3.8C14.41 2.93 14.38 2.76 13.32 2.76H10.7C9.64 2.76 9.62 2.9 9.47 3.79L9.24 5.09C9.18 5.46 8.86 5.72 8.5 5.72Z" fill="#292D32"/>
                                            <path d="M15.21 22.75H8.79C5.3 22.75 5.16 20.82 5.05 19.26L4.4 9.19C4.37 8.78 4.69 8.42 5.1 8.39C5.52 8.37 5.87 8.68 5.9 9.09L6.55 19.16C6.66 20.68 6.7 21.25 8.79 21.25H15.21C17.31 21.25 17.35 20.68 17.45 19.16L18.1 9.09C18.13 8.68 18.49 8.37 18.9 8.39C19.31 8.42 19.63 8.77 19.6 9.19L18.95 19.26C18.84 20.82 18.7 22.75 15.21 22.75Z" fill="#292D32"/>
                                            <path d="M13.66 17.25H10.33C9.92 17.25 9.58 16.91 9.58 16.5C9.58 16.09 9.92 15.75 10.33 15.75H13.66C14.07 15.75 14.41 16.09 14.41 16.5C14.41 16.91 14.07 17.25 13.66 17.25Z" fill="#292D32"/>
                                            <path d="M14.5 13.25H9.5C9.09 13.25 8.75 12.91 8.75 12.5C8.75 12.09 9.09 11.75 9.5 11.75H14.5C14.91 11.75 15.25 12.09 15.25 12.5C15.25 12.91 14.91 13.25 14.5 13.25Z" fill="#292D32"/>
                                        </svg>
                                    </div>
                                    <div class="cursor-pointer" wire:click='editTask({{ $task->id }})' >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                                            <path d="M15 22.75H9C3.57 22.75 1.25 20.43 1.25 15V9C1.25 3.57 3.57 1.25 9 1.25H11C11.41 1.25 11.75 1.59 11.75 2C11.75 2.41 11.41 2.75 11 2.75H9C4.39 2.75 2.75 4.39 2.75 9V15C2.75 19.61 4.39 21.25 9 21.25H15C19.61 21.25 21.25 19.61 21.25 15V13C21.25 12.59 21.59 12.25 22 12.25C22.41 12.25 22.75 12.59 22.75 13V15C22.75 20.43 20.43 22.75 15 22.75Z" fill="#292D32"/>
                                            <path d="M8.5 17.69C7.89 17.69 7.33 17.47 6.92 17.07C6.43 16.58 6.22 15.87 6.33 15.12L6.76 12.11C6.84 11.53 7.22 10.78 7.63 10.37L15.51 2.49C17.5 0.5 19.52 0.5 21.51 2.49C22.6 3.58 23.09 4.69 22.99 5.8C22.9 6.7 22.42 7.58 21.51 8.48L13.63 16.36C13.22 16.77 12.47 17.15 11.89 17.23L8.88 17.66C8.75 17.69 8.62 17.69 8.5 17.69ZM16.57 3.55L8.69 11.43C8.5 11.62 8.28 12.06 8.24 12.32L7.81 15.33C7.77 15.62 7.83 15.86 7.98 16.01C8.13 16.16 8.37 16.22 8.66 16.18L11.67 15.75C11.93 15.71 12.38 15.49 12.56 15.3L20.44 7.42C21.09 6.77 21.43 6.19 21.48 5.65C21.54 5 21.2 4.31 20.44 3.54C18.84 1.94 17.74 2.39 16.57 3.55Z" fill="#292D32"/>
                                            <path d="M19.85 9.83C19.78 9.83 19.71 9.82 19.65 9.8C17.02 9.06 14.93 6.97 14.19 4.34C14.08 3.94 14.31 3.53 14.71 3.41C15.11 3.3 15.52 3.53 15.63 3.93C16.23 6.06 17.92 7.75 20.05 8.35C20.45 8.46 20.68 8.88 20.57 9.28C20.48 9.62 20.18 9.83 19.85 9.83Z" fill="#292D32"/>
                                        </svg>
                                    </div>
                                </div>
                                
                            </div>
                            <div>
                                @if($task->description != NULL)<p class="ml-[23px] text-[14px]">{{ $task->description }}</p>
                                @else <p class="ml-[23px] text-[14px] text-stone-500">No description available</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if($isDialogOpen)
        <div class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="rounded-lg px-4 py-6 bg-white flex flex-col gap-3 max-w-[350px] w-full" wire:click.stop>
                <h2 class="text-[18px] font-semibold">
                    @if($isEditing)Update Task
                    @else Add task
                    @endif
                </h2>
                <form wire:submit.prevent="addTask" class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <label for="title">Title</label>
                        <input type="text" id="title" class="h-[40px] border border-solid border-stone-300 rounded-md pl-3 focus:outline-none" name="title" wire:model="title">
                        @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="3" class="resize-none border border-solid border-stone-300 rounded-md px-3 focus:outline-none pt-3" wire:model="description"></textarea>
                        @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-2 mt-[10px]">
                        <button type="submit" class="px-3 py-[8px] text-[14px] text-white rounded-md bg-[#977EEF]">
                            @if($isEditing) Update Task 
                            @else Add Task 
                            @endif    
                        </button>
                        <button type="button" class="px-3 py-[8px] text-[14px] text-black rounded-md bg-[#F3DF9D]" wire:click="closeDialog">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if($isConnexionOpen)
        <div class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="rounded-lg px-4 py-6 bg-white flex flex-col gap-6 max-w-[270px] w-full" wire:click.stop>
                <div class="flex flex-col gap-1">
                    <h2 class="text-[18px] font-semibold">Hey There! 👋</h2>
                    <p class="text-[14px] text-stone-500">Great to have you here!</p>
                </div>
                
                <div class="flex flex-col gap-2 w-full">
                    <button 
                        class="py-[8px] border border-solid border-grey-100 hover:bg-blue-600 hover:text-white rounded-md flex items-center gap-2 justify-center"
                        wire:click="redirectToProvider('google')"
                    > 
                        <p>SignIn with Gmail</p> 
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="18" height="18" viewBox="0 0 48 48">
                                <path fill="#4caf50" d="M45,16.2l-5,2.75l-5,4.75L35,40h7c1.657,0,3-1.343,3-3V16.2z"></path><path fill="#1e88e5" d="M3,16.2l3.614,1.71L13,23.7V40H6c-1.657,0-3-1.343-3-3V16.2z"></path><polygon fill="#e53935" points="35,11.2 24,19.45 13,11.2 12,17 13,23.7 24,31.95 35,23.7 36,17"></polygon><path fill="#c62828" d="M3,12.298V16.2l10,7.5V11.2L9.876,8.859C9.132,8.301,8.228,8,7.298,8h0C4.924,8,3,9.924,3,12.298z"></path><path fill="#fbc02d" d="M45,12.298V16.2l-10,7.5V11.2l3.124-2.341C38.868,8.301,39.772,8,40.702,8h0 C43.076,8,45,9.924,45,12.298z"></path>
                            </svg>
                        </div>
                    </button>
                    <button class="py-[8px] border border-solid border-grey-100 hover:bg-blue-600 hover:text-white rounded-md flex items-center gap-2 justify-center">
                        <p>SignIn with Github</p>
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="18" height="18" viewBox="0 0 30 30">
                                <path d="M15,3C8.373,3,3,8.373,3,15c0,5.623,3.872,10.328,9.092,11.63C12.036,26.468,12,26.28,12,26.047v-2.051 c-0.487,0-1.303,0-1.508,0c-0.821,0-1.551-0.353-1.905-1.009c-0.393-0.729-0.461-1.844-1.435-2.526 c-0.289-0.227-0.069-0.486,0.264-0.451c0.615,0.174,1.125,0.596,1.605,1.222c0.478,0.627,0.703,0.769,1.596,0.769 c0.433,0,1.081-0.025,1.691-0.121c0.328-0.833,0.895-1.6,1.588-1.962c-3.996-0.411-5.903-2.399-5.903-5.098 c0-1.162,0.495-2.286,1.336-3.233C9.053,10.647,8.706,8.73,9.435,8c1.798,0,2.885,1.166,3.146,1.481C13.477,9.174,14.461,9,15.495,9 c1.036,0,2.024,0.174,2.922,0.483C18.675,9.17,19.763,8,21.565,8c0.732,0.731,0.381,2.656,0.102,3.594 c0.836,0.945,1.328,2.066,1.328,3.226c0,2.697-1.904,4.684-5.894,5.097C18.199,20.49,19,22.1,19,23.313v2.734 c0,0.104-0.023,0.179-0.035,0.268C23.641,24.676,27,20.236,27,15C27,8.373,21.627,3,15,3z"></path>
                            </svg>
                        </div>
                    </button>
                </div>
                <p class="text-center text-[14px]">By signin, you agree to the GrowthBook Terms of services and privacy policy</p>
            </div>
        </div>
    @endif
    
</div>