<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Messages
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Chat with your healthcare providers.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">add</span>
                <span class="truncate">New Message</span>
            </button>
        </div>

        <!-- Chat Interface -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 h-[calc(100vh-200px)]">
            <!-- Conversations List -->
            <div class="lg:col-span-1 bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark overflow-hidden">
                <div class="p-4 border-b border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                        Conversations
                    </h2>
                </div>
                <div class="overflow-y-auto h-full">
                    @for($i = 0; $i < 5; $i++)
                    <div class="flex items-center gap-3 p-4 border-b border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark cursor-pointer">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPyLJw3e-STCG-Z_O80E32_v6PZpysy71S1oSZahWCaDPPQmvcgI2t0gUj2Zrs9mZc37Qkvjq-vINlPqEmVzUN_TA36pmlmevEoz2tgIGY5cI3MriGJn0lQxDKPb_26F2nPz6-be5413GVSx6e1MTVRDeDgpC9AXz4sPxw53iRSaKl4L-kNXkJUbxSJl3uRQ0yHwUqig5sZkkhDpfh1pOixCpqMsnux06f4TcFD80t8P87irVbR-BWMQobLI6VPC5xNX2hdY2Z0w");'>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-text-light-primary dark:text-text-dark-primary font-semibold truncate">
                                Dr. Evelyn Reed
                            </p>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm truncate">
                                Thanks for the update, I'll review...
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                2:30 PM
                            </p>
                            <div class="flex justify-end mt-1">
                                <span class="bg-primary text-white text-xs rounded-full size-5 flex items-center justify-center">
                                    3
                                </span>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Chat Area -->
            <div class="lg:col-span-3 flex flex-col bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark overflow-hidden">
                <!-- Chat Header -->
                <div class="flex items-center gap-3 p-4 border-b border-border-light dark:border-border-dark">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPyLJw3e-STCG-Z_O80E32_v6PZpysy71S1oSZahWCaDPPQmvcgI2t0gUj2Zrs9mZc37Qkvjq-vINlPqEmVzUN_TA36pmlmevEoz2tgIGY5cI3MriGJn0lQxDKPb_26F2nPz6-be5413GVSx6e1MTVRDeDgpC9AXz4sPxw53iRSaKl4L-kNXkJUbxSJl3uRQ0yHwUqig5sZkkhDpfh1pOixCpqMsnux06f4TcFD80t8P87irVbR-BWMQobLI6VPC5xNX2hdY2Z0w");'>
                    </div>
                    <div class="flex-1">
                        <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                            Dr. Evelyn Reed
                        </p>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                            Online - Last seen 2 min ago
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="flex items-center justify-center rounded-full size-9 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                            <span class="material-symbols-outlined">video_call</span>
                        </button>
                        <button class="flex items-center justify-center rounded-full size-9 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                            <span class="material-symbols-outlined">call</span>
                        </button>
                        <button class="flex items-center justify-center rounded-full size-9 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4">
                    <!-- Received Message -->
                    <div class="flex items-start gap-3">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-8"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPyLJw3e-STCG-Z_O80E32_v6PZpysy71S1oSZahWCaDPPQmvcgI2t0gUj2Zrs9mZc37Qkvjq-vINlPqEmVzUN_TA36pmlmevEoz2tgIGY5cI3MriGJn0lQxDKPb_26F2nPz6-be5413GVSx6e1MTVRDeDgpC9AXz4sPxw53iRSaKl4L-kNXkJUbxSJl3uRQ0yHwUqig5sZkkhDpfh1pOixCpqMsnux06f4TcFD80t8P87irVbR-BWMQobLI6VPC5xNX2hdY2Z0w");'>
                        </div>
                        <div class="bg-background-light dark:bg-background-dark rounded-lg p-3 max-w-[70%]">
                            <p class="text-text-light-primary dark:text-text-dark-primary text-sm">
                                Hello Maria, how have you been feeling since our last appointment?
                            </p>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">2:15 PM</p>
                        </div>
                    </div>

                    <!-- Sent Message -->
                    <div class="flex items-start gap-3 justify-end">
                        <div class="bg-primary rounded-lg p-3 max-w-[70%]">
                            <p class="text-white text-sm">
                                I've been feeling much better, thank you! The medication seems to be working well.
                            </p>
                            <p class="text-blue-100 text-xs mt-1">2:16 PM</p>
                        </div>
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-8"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBmoJ7zWljb-6oG8m3ruqHc_HJBrlj0SL-YJrRySRqzdiEOLUaC4dCutjq-IATLBJ9HMmYNf6wX0XVbROieBzLVfjzSdSqaXKckizUENhpVyCypmVQUW0n8qlyonn-6WFZ9tlfdZUcG8_apNL-YoCv5zsAIynHVuEwEdKaqpF_NkIePpngu2hMYNT7waE7Ws2B6J9kJxzmcYAicG_trQe760nCkKe6aJ8ZxBPc_6M_6D1J723zypAp2MjZW60fwqZoC_t-dxgyb0A");'>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="p-4 border-t border-border-light dark:border-border-dark">
                    <div class="flex items-center gap-3">
                        <button class="flex items-center justify-center rounded-full size-9 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                            <span class="material-symbols-outlined">add</span>
                        </button>
                        <div class="flex-1">
                            <input type="text" placeholder="Type your message..." class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <button class="flex items-center justify-center rounded-full size-9 bg-primary text-white">
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>