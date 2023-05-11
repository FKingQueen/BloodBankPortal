<style>
  .sidebar:hover {
      width: 16rem;
  }
  @media only screen and (min-width: 768px) {
      .header-right {
          width: calc(100% - 16rem);
      }        
  }
</style>
<template>
  <div class="bgImage">
    <div v-if="isAdmin" class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased " style="background-color: rgb(245 247 249);">
      <div> 
        <!-- Header -->
        <div class="fixed w-full flex items-center justify-between h-14 text z-10">
          <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 h-14 bg-gray-300 border-none">
            <img class="w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden bg-gray-300" src="https://therminic2018.eu/wp-content/uploads/2018/07/dummy-avatar.jpg" />
            <span class="hidden md:block "> ADMIN ({{ this.userName }})</span>
          </div>
          <div class="flex justify-between items-center h-14 bg-gray-300 header-right">
            <ul class="justify-end flex w-full">
              <li>
                <a @click="logout()" href="#" class="flex items-center mr-4 text-black hover:text-gray-400 hidden lg:block">
                  <div class="flex">
                    <div>
                      <svg class="w-7 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </div>
                    <div>
                      Logout
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- ./Header -->
      
        <!-- Sidebar -->
        <div class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-gray-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
          <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
            <ul class="flex flex-col py-4 space-y-1">
              <li class="px-5 hidden md:block">
                <div class="flex flex-row items-center h-8">
                  <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Main</div>
                </div>
              </li>
              <li>
                <router-link to="/admin/userApprovalPlatform" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white hover:text-slate-300 border-b-4 border-transparent hover:border-blue-500 pr-6">
                  <span class="inline-flex justify-center items-center ml-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                  </span>
                  <span class="ml-2 text-sm tracking-wide truncate">User Approval Management</span>
                </router-link>
                <router-link to="/admin/userPlatform" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white hover:text-slate-300 border-b-4 border-transparent hover:border-blue-500 pr-6">
                  <span class="inline-flex justify-center items-center ml-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                  </span>
                  <span class="ml-2 text-sm tracking-wide truncate">User Management</span>
                </router-link>
              </li>
              <li>
                <a href="#" class="block lg:hidden relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white   hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                  <span class="inline-flex justify-center items-center ml-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                  </span>
                  <span class="ml-2 text-sm tracking-wide truncate">Logout</span>
                </a>
              </li>
            </ul>
            <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs">Copyright @2023</p>
          </div>
        </div>
        <!-- ./Sidebar -->
      </div>
      <div class="h-full ml-14 mt-14 mb-10 md:ml-64 bg" >
        <router-view ></router-view>
      </div>
    </div>
    <div v-if="isUser">
        <!-- Header -->
        <div class=" w-full flex items-center justify-between bg-gray-300 h-14  z-10">
          <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 ">
            <div>
              <img src="/img/bloodDrop.png" alt="" class="object-cover w-10 px-2">
            </div>
            <span class="hidden md:block ">PORTAL</span>
          </div>
          <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 ">
                <router-link to="/home" :class="{ active: activeItem}" class="text-black relative flex flex-row items-center h-12 focus:outline-none hover:text-black border-b-4 border-transparent hover:border-blue-500 p-6">
                  <span class="">HOME</span>
                </router-link>
                <router-link v-if="isRoom" to="/chatBox" class="text-black relative flex flex-row items-center h-12 focus:outline-none hover:text-black border-b-4 border-transparent hover:border-blue-500 p-6">
                  <span class="">CHATBOX</span>
                </router-link>
          </div>
          
          <div class="flex justify-between items-center   header-right">
            <ul class="justify-end flex w-full">
              <li>
                <a @click="logout()" class="flex items-center mr-4 text-black hover:text-gray-400 hidden lg:block">
                  <div class="flex">
                    <div>
                      {{ this.userName }}
                    </div>
                    <div>
                      <svg class="w-7 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- ./Header -->
        <div class="w-full">
            <router-view ></router-view>
        </div>
    </div>
  </div> 
    
  
</template>

<script>
import { defineComponent, reactive, onMounted, ref, toRefs } from 'vue';
export default defineComponent({
  setup(){
    const isAdmin = ref(false);
    const isUser = ref(false);
    const isRoom = ref(false);
    const activeItem = ref(false);
    return{
      isAdmin,
      isUser,
      userName: '',
      isRoom,
      activeItem,
    }
  },
  watch:{
    $route (to, from){
      let existingObj = this;
      if(to.path == "/donateBlood" ||  to.path == "/findBlood" ){
        existingObj.activeItem = true;
      }else {
        existingObj.activeItem = false;
      }
      axios.get('/api/admin/checkRooms')
      .then(function (response) {
        if(response.data != ""){
          existingObj.isRoom = true;
        }
      })
      .catch(function (error) {
      });
    }
  },
  methods: {
    async logout(){
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/api/logout')
        .then(response => {
          window.Laravel.isLoggedin = false
          window.Laravel.userType = ''
          this.$router.push({path: '/'})
        })
        .catch(function (error) {
            console.error(error);
        });
      }) 
    }
  },
  async created(){
    let existingObj = this;
    this.token = window.Laravel.csrfToken;
    axios.get('/api/admin/checkRooms')
    .then(function (response) {
      if(response.data != ""){
        existingObj.isRoom = true;
      }
    })
    .catch(function (error) {
    });
    await axios.get('/api/admin/getAuth')
      .then(function (response) {
        existingObj.isAdmin = response.data.userType === 'Admin' ? true:false
        existingObj.isUser = response.data.userType === 'User' ? true:false
        existingObj.userName = response.data.firstName
        
      })
      .catch(function (error) {
      });
  }
})
</script>


<style  scoped>
.router-link-exact-active{
    border-bottom: 4px solid rgb(59 130 246);
}

</style>

<style  scoped>
.active{
    border-bottom: 4px solid rgb(59 130 246);
}
</style>
