<template>
    <div class="h-screen bgImage">
        <div class="flex justify-center p-10">
            <h1 class="text-2xl font-bold text-white uppercase">Web Portal for Blood Bank in Negros Oriental Provincial Hospital</h1>
        </div>
        <div class="flex justify-center">
            <div class="w-2/6 border shadow-lg flex items-center h-96 justify-center bg-white">
                <div class="w-2/4">
                    <div class="flex justify-center w-full ">
                        <a-button key="submit"  @click="handleSubmit()"  type="primary" class="w-full mb-5">DONATE BLOOD</a-button>
                    </div>
                    <div class="flex justify-center">
                        <a-button key="submit" @click="this.$router.push('/findBlood')" type="primary" class="w-full">LOOKING FOR DONORS</a-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, h } from 'vue';
import { notification } from 'ant-design-vue';
export default defineComponent({
    data(){
        return{
            
        }
    },
    methods: {
        handleSubmit(){
            let existingObj = this;
            axios.get('/api/admin/checkDonatedBlood')
            .then(function (response) {
                if(response.data.length != 0){
                    notification.error({
                        message: 'Notification',
                        description: 'Based on the data inputs, you already Donated Blood',
                    });
                }else {
                    existingObj.$router.push('/donateBlood')
                }
            })
            .catch(function (error) {
            });
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

<style scoped>
.bgImage {
    background-image: url('/img/background.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    color: #FFFFFF;
}
</style>

