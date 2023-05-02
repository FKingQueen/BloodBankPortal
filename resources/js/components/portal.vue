<template>
    <div>
        <!-- Header -->
        <div class=" w-full flex items-center justify-between bg-gray-300 h-14  z-10">
          <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 ">
            <span class="hidden md:block ">PORTAL</span>
          </div>
          <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 ">
                <router-link to="/portal/home" class="text-black relative flex flex-row items-center h-12 focus:outline-none hover:text-black border-b-4 border-transparent hover:border-blue-500 p-6">
                  <span class="">HOME</span>
                </router-link>
                <router-link to="/portal/chatbox" class="text-black relative flex flex-row items-center h-12 focus:outline-none hover:text-black border-b-4 border-transparent hover:border-blue-500 p-6">
                  <span class="">CHATBOX</span>
                </router-link>
          </div>
          
          <div class="flex justify-between items-center   header-right">
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
        <div class="w-full border" >
            <router-view ></router-view>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { MailOutlined, AppstoreOutlined, SettingOutlined } from '@ant-design/icons-vue';
export default defineComponent({
  data() {
    return {
    
    };
  },
});
</script>


<style scoped>
.router-link-exact-active{
    /* background-color: rgb(156 163 175); */
    border-bottom: 4px solid rgb(59 130 246);
}

</style>