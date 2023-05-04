<template>
    <div>
        chatbox
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