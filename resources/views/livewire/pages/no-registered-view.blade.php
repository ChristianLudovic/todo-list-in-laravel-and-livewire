<div>
    <div>
        <div class="{{$isConnexionOpens ? 'filter blur-sm' : '' }} transition-all duration-300 min-h-screen">
            <div class="max-w-[600px] w-full mx-auto flex flex-col gap-6 items-start">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-end gap-1">
                        <img src="/logo.svg" alt="" class="w-[30px]">
                    </div>
                    <button class="text-[14px] font-medium" wire:click='openConnexion'>SignIn</button>
                </div>
                
                <hr class="w-full" />
                <div class="flex justify-between items-center w-full">
                    <button class="flex gap-2 items-center" wire:click='openConnexion'>
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
                <div class="w-full flex flex-col items-center gap-4 justify-center py-8 mx-auto">
                    <img src="/error-image.svg" alt="" class="w-[300px] h-auto">
                    <p class="text-[16px] text-center max-w-[270px]">No tasks available, <button wire:click='openConnexion' class="underline">signIn</button> to see or add tasks</p>
                </div>
            </div>
        </div>
        @if($isConnexionOpens)
            <div class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
                <div class="rounded-lg px-4 py-6 bg-white flex flex-col gap-6 max-w-[350px] w-full" wire:click.stop>
                    <div class="flex flex-col gap-1">
                        <h2 class="text-[18px] font-semibold">Hey There! 👋</h2>
                        <p class="text-[14px] text-stone-500">Great to have you here!</p>
                    </div>
                    
                    <div class="flex flex-col gap-2 w-full">
                        <button 
                            class="py-[8px] border border-solid border-grey-100 hover:bg-[#977EEF] hover:text-white rounded-md flex items-center gap-2 justify-center"
                            wire:click="redirectToProvider('google')"
                        > 
                            <p>SignIn with Gmail</p> 
                            <div class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="18" height="18" viewBox="0 0 48 48">
                                    <path fill="#4caf50" d="M45,16.2l-5,2.75l-5,4.75L35,40h7c1.657,0,3-1.343,3-3V16.2z"></path><path fill="#1e88e5" d="M3,16.2l3.614,1.71L13,23.7V40H6c-1.657,0-3-1.343-3-3V16.2z"></path><polygon fill="#e53935" points="35,11.2 24,19.45 13,11.2 12,17 13,23.7 24,31.95 35,23.7 36,17"></polygon><path fill="#c62828" d="M3,12.298V16.2l10,7.5V11.2L9.876,8.859C9.132,8.301,8.228,8,7.298,8h0C4.924,8,3,9.924,3,12.298z"></path><path fill="#fbc02d" d="M45,12.298V16.2l-10,7.5V11.2l3.124-2.341C38.868,8.301,39.772,8,40.702,8h0 C43.076,8,45,9.924,45,12.298z"></path>
                                </svg>
                            </div>
                        </button>
                        <button class="py-[8px] border border-solid border-grey-100 hover:bg-[#977EEF] hover:text-white rounded-md flex items-center gap-2 justify-center">
                            <p>SignIn with Github</p>
                            <div class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="18" height="18" viewBox="0 0 30 30">
                                    <path d="M15,3C8.373,3,3,8.373,3,15c0,5.623,3.872,10.328,9.092,11.63C12.036,26.468,12,26.28,12,26.047v-2.051 c-0.487,0-1.303,0-1.508,0c-0.821,0-1.551-0.353-1.905-1.009c-0.393-0.729-0.461-1.844-1.435-2.526 c-0.289-0.227-0.069-0.486,0.264-0.451c0.615,0.174,1.125,0.596,1.605,1.222c0.478,0.627,0.703,0.769,1.596,0.769 c0.433,0,1.081-0.025,1.691-0.121c0.328-0.833,0.895-1.6,1.588-1.962c-3.996-0.411-5.903-2.399-5.903-5.098 c0-1.162,0.495-2.286,1.336-3.233C9.053,10.647,8.706,8.73,9.435,8c1.798,0,2.885,1.166,3.146,1.481C13.477,9.174,14.461,9,15.495,9 c1.036,0,2.024,0.174,2.922,0.483C18.675,9.17,19.763,8,21.565,8c0.732,0.731,0.381,2.656,0.102,3.594 c0.836,0.945,1.328,2.066,1.328,3.226c0,2.697-1.904,4.684-5.894,5.097C18.199,20.49,19,22.1,19,23.313v2.734 c0,0.104-0.023,0.179-0.035,0.268C23.641,24.676,27,20.236,27,15C27,8.373,21.627,3,15,3z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <p class="text-center text-[12px]">By signin, you agree to the GrowthBook <a href="#" class="underline">Terms of services</a> and <a href="#" class="underline">privacy policy</a></p>
                </div>
            </div>
        @endif
    </div>
</div>

