<template>
    <div class="bgImage h-screen">
        <div class="flex justify-center w-full pt-5 ">
            <div class="flex justify-center w-full rounded-lg">
                <div class="container mx-auto shadow-lg rounded-lg">
                    <!-- headaer -->
                    <div class="px-5 py-5 flex justify-between items-center bg-red-900  rounded-t-lg">
                        <div class="text-2xl text-white">Chat Box</div>
                    </div>
                    <!-- end header -->
                    <!-- Chatting -->
                    <div class="flex flex-row justify-between bg-white rounded-b-lg">
                        <!-- chat list -->
                        <div class="overflow-y-auto border-l border-r sm:w-64 bg-gray-900 border-gray-700">
                            <div v-for="(chatRoom, key, index) in this.chatRooms" :class="{ active: key === activeItem}" class="mt-2 space-y-4">
                                <button @click="changeCurrentRoom(key)" class=" flex items-center w-full px-5 py-2 transition-colors duration-200 hover:bg-gray-800 gap-x-2 focus:outline-none">
                                    <div class="relative">
                                        <img class="w-10 h-10 rounded-full" src="/img/user.png" alt="">  
                                        <span class="hidden top-0 left-7 absolute  w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                    </div>
                                    <div class="text-left rtl:text-right">
                                        <h1 class="text-sm font-medium capitalize text-white">{{ chatRoom.address }}</h1>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <!-- end chat list -->
                        <!-- message -->
                        <div class="w-full px-5 flex flex-col justify-between">
                            <div class="flex flex-col mt-5">
                                <div class="">
                                    <div class="flex-1 p:2 sm:p-6 justify-between flex flex-col  h-[45rem]">
                                        <div id="messages" class="flex flex-col flex-col-reverse  p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                                            <!-- Messages -->
                                                <div v-for="(message, key, index) in this.messages" class="chat-message">
                                                    <div v-if="this.userId != message.user_id" class="flex items-end">
                                                        <div class="flex flex-col space-y-2 text-xs max-w-xs my-1 order-2 items-start">
                                                        <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">{{ message.message }}</span></div>
                                                        </div>
                                                    </div>
                                                    <div v-if="this.userId == message.user_id" class="flex items-end justify-end">
                                                        <div class="flex flex-col space-y-2 text-xs max-w-xs my-1 order-1 items-end">
                                                        <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">{{ message.message }}</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- /Messages -->
                                        </div>
                                        <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
                                            <div class="relative flex">
                                                <input v-model="form.message" type="text" placeholder="Write your message!" class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 bg-gray-200 rounded-md py-3">
                                                <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                                                    <button type="button" @click="handleSubmit()"  class="inline-flex items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
                                                        <span class="font-bold">Send</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 ml-2 transform rotate-90">
                                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    
</template>

<script>
import { defineComponent, ref, onMounted, h } from 'vue';
export default defineComponent({
    data(){
        return{
            userId: '',
            activeItem: null,
            chatRooms: [],
            currentRoom: [],
            messages: [],
            users: [],
            form: {
                message: ''
            }
        }
    },
    watch: {
        currentRoom(){
            let existingObj = this;
            existingObj.connect();
        }
    },
    methods: {
        changeCurrentRoom(key){
            let existingObj = this
            existingObj.currentRoom = existingObj.chatRooms[key]
            this.activeItem = key;
        },
        connect(){
            let existingObj = this;
            if(existingObj.currentRoom.id){
                existingObj.getMessages();
                window.Echo.private("chat." + existingObj.currentRoom.id)
                .listen('NewChatMessage', (e) => {
                    existingObj.getMessages();
                })
            }
        },
        handleSubmit(){
            let existingObj = this;
            if(existingObj.form.message == ''){
                return;
            }


            axios.post(`/api/admin/room/`+ existingObj.currentRoom.id + `/message`, this.form)
            .then(function (response) {
                if( response.status == 201)
                {
                    existingObj.form.message = '';
                    existingObj.connect();
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        async getRooms(){
            let existingObj = this;
            await axios.get('/api/admin/rooms')
                .then(function (response) {
                    // SORT Data base in updated_at column
                    console.log(response.data);
                existingObj.chatRooms = response.data
                if(window.Laravel.currentRoom!=null)
                {
                    console.log(window.Laravel.currentRoom);
                    for(let i=0; i<=response.data.length; i++){
                        if(window.Laravel.currentRoom==response.data[i].id){
                            existingObj.currentRoom = response.data[i]
                            existingObj.activeItem = i;
                            return;
                        }
                    }
                } else {
                    existingObj.currentRoom = response.data[0]
                    existingObj.activeItem = 0;
                }
                })
                .catch(function (error) {
            });
        },
        getMessages(){
            let existingObj = this;
            axios.get(`/api/admin/room/`+ existingObj.currentRoom.id + `/messages`)
                .then(function (response) {
                existingObj.messages = response.data
                
                })
                .catch(function (error) {
                    console.log(error)
            });
        }
    },
    async created(){
        let existingObj = this;
        axios.get(`/api/admin/getUserId`)
            .then(function (response) {
            existingObj.userId = response.data
            })
            .catch(function (error) {
                console.log(error)
        });
        
        this.getRooms();
    },
    beforeRouteEnter(to, from, next) {
        if(window.Laravel.userType == 'Admin'){
            next({ path: from.path });
        }
        next();    
    }
})
</script>

<style scoped>
    .scrollbar-w-2::-webkit-scrollbar {
    width: 0.25rem;
    height: 0.25rem;
    }

    .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
    --bg-opacity: 1;
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--bg-opacity));
    }

    .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
    --bg-opacity: 1;
    background-color: #edf2f7;
    background-color: rgba(237, 242, 247, var(--bg-opacity));
    }

    .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
    border-radius: 0.25rem;
    }
</style>

<style scoped>
.bgImage {
    background-image: url('/img/background.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    color: #FFFFFF;
}
</style>

<style  scoped>
.active{
    /* background-color: rgb(156 163 175); */
    border-bottom: 4px solid rgb(59 130 246);
}
</style>


