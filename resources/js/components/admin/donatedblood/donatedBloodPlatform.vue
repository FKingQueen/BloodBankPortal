    <template>
        <div class="p-2">
            <div class="m-5 bg-white shadow-inner shadow-lg rounded px-10 py-5">
                <div class="flex justify-center text-2xl mb-3">
                    Donated Blood Management
                </div>
                <div class="flex justify-evenly ">
                    <div class="w-2/6">
                        <Pie :data="this.data" :options="this.options" />
                    </div>
                    <div class="w-2/6">
                        <Pie :data="this.data1" :options="this.options1" />
                    </div>
                </div>
            </div>
        </div>
    </template>
<script>
import { notification } from 'ant-design-vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import { defineComponent, reactive, ref, toRefs } from 'vue';

import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Pie } from 'vue-chartjs'
// import * as chartConfig from './chartConfig.js'

ChartJS.register(ArcElement, Tooltip, Legend)

export default defineComponent({
    name: 'BarChart',
    components: {
    SearchOutlined,
    Loading,
    Pie
    },
    setup() {
        return{

        }
    },
    methods: {
    
    },
    data() {
        return {
            options: {
                responsive: true,
                maintainAspectRatio: true
            },
            data: {
                labels: ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],
                datasets: [
                    {
                    backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16', '#E46651', '#00D8FF', '#DD1B16', '#DD1B16'],
                    data: [40, 20, 80, 10, 20, 80, 10, 10]
                    }
                ]
            },
            options1: {
                responsive: true,
                maintainAspectRatio: false
            },
            data1: {
                labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
                datasets: [
                    {
                    backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
                    data: [40, 20, 80, 10]
                    }
                ]
            }
        }
    },
    async created(){
        axios.get('/api/admin/getBloodType')
        .then(function (response) {
            console.log(response.data);
        })
        .catch(function (error) {

        });
    },
    beforeRouteEnter(to, from, next) {
        if(window.Laravel.userType == 'User'){
            next({ path: from.path });
        }
        next();    
    }
    
})

</script>

<style>
    .demo-upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
    img.ant-image-preview-img { display: inline-block; } 
</style>