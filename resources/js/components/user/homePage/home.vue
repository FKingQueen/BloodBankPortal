<template>
    <div>
        <div class="flex justify-center my-10">
            <h1 class="text-2xl font-bold">NEGROS ORIENTAL PROVINCIAL HOSPITAL BLOOD BANK PORTAL</h1>
        </div>
        <div class="flex justify-center">
            <div class="w-2/6 border shadow-lg flex items-center h-96 justify-center">
                <div class="w-2/4">
                    <div class="flex justify-center w-full ">
                        <a-button key="submit" @click="this.$router.push('/donateBlood')" type="primary" class="w-full mb-5">DONATE BLOOD</a-button>
                    </div>
                    <div class="flex justify-center">
                        <a-button key="submit" @click="this.$router.push('/findBlood')" type="primary" class="w-full">LOOKING FOR BLOOD</a-button>
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
            
        }
    },
    beforeRouteEnter(to, from, next) {
        if(window.Laravel.userType == 'Admin'){
            next({ path: from.path });
        }
        next();    
    }
})
</script>