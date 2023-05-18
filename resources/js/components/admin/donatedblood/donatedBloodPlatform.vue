    <template>
        <div class="p-2">
            <div class="m-5 bg-white shadow-inner shadow-lg rounded px-10 py-5">
                <div class="flex justify-center text-2xl mb-3">
                    Donated Blood Management
                </div>
                <div class="flex justify-evenly mt-10">
                    <div class="flex items-center">
                        <h1>Quantity of Bloods Donated:</h1>
                    </div>
                    <div class="w-3/6">
                        <Pie v-if="isLoaded" :data="this.data" :options="this.options" />
                    </div>
                </div>
                <h1 class="text-left text-base mt-10 mb-5">Blood Bank Inventory</h1>

                <a-table v-if="isLoaded1" :data-source="this.donatedBlood.address" :columns="columns" size="small" class="shadow">
                    <template #headerCell="{ column }">
                    <template v-if="column.key === 'name'">
                        <span style="color: #1890ff">Name</span>
                    </template>
                    </template>
                    <template
                    #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }"
                    >
                    <div style="padding: 8px">
                        <a-input
                        ref="searchInput"
                        :placeholder="`Search ${column.dataIndex}`"
                        :value="selectedKeys[0]"
                        style="width: 188px; margin-bottom: 8px; display: block"
                        @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])"
                        @pressEnter="handleSearch(selectedKeys, confirm, column.dataIndex)"
                        />
                        <a-button
                        type="primary"
                        size="small"
                        style="width: 90px; margin-right: 8px"
                        @click="handleSearch(selectedKeys, confirm, column.dataIndex)"
                        >
                        <template #icon><SearchOutlined /></template>
                        Search
                        </a-button>
                        <a-button size="small" style="width: 90px" @click="handleReset(clearFilters)">
                        Reset
                        </a-button>
                    </div>
                    </template>
                    <template #customFilterIcon="{ filtered }">
                    <search-outlined :style="{ color: filtered ? '#108ee9' : undefined }" />
                    </template>
                    <template #bodyCell="{ text, column, record, index}">
                        <span v-if="searchText && searchedColumn === column.dataIndex">
                            <template
                            v-for="(fragment, i) in text
                                .toString()
                                .split(new RegExp(`(?<=${searchText})|(?=${searchText})`, 'i'))"
                            >
                            <mark
                                v-if="fragment.toLowerCase() === searchText.toLowerCase()"
                                :key="i"
                                class="highlight"
                            >
                                {{ fragment }}
                            </mark>
                            <template v-else>{{ fragment }}</template>
                            </template>
                        </span>
                        <template v-else-if="column.key === 'address'">
                            <p v-for="(item, key) in this.donatedBlood.address[index].slice(0,1)">
                                {{ item.address }}
                            </p>
                            <!-- {{ this.donatedBlood.address[index] }} -->
                        </template>
                        <template v-else-if="column.key === 'bloodType'">
                            <div  class="flex text-center">
                                <div v-for="(item, key) in this.bloodTypeCount[index]">
                                    {{ item.bloodType }} &nbsp
                                </div>
                            </div>
                            <!-- {{ this.donatedBlood.address[index] }} -->
                        </template>
                        <template v-else-if="column.key === 'quantity'">
                            <p>
                                {{ this.donatedBlood.address[index].length }}
                            </p> 
                        </template>

                    </template>

                </a-table>

            </div>
        </div>
    </template>
<script>

import { SearchOutlined } from '@ant-design/icons-vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import { defineComponent, reactive, ref, toRefs } from 'vue';

import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Pie } from 'vue-chartjs'
ChartJS.register(ArcElement, Tooltip, Legend)

export default defineComponent({

    components: {
    SearchOutlined,
    Loading,
    Pie
    },
    setup() {
        const state = reactive({
            searchText: '',
            searchedColumn: '',
        });
        const searchInput = ref();

        const columns = [
        {
            title: 'Address',
            dataIndex: 'address',
            key: 'address',
            customFilterDropdown: true,
            onFilter: (value, record) => record.address.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownVisibleChange: visible => {
            if (visible) {
                setTimeout(() => {
                searchInput.value.focus();
                }, 100);
            }
            },
            
        }, {
            title: 'Type of Blood',
            dataIndex: 'bloodType',
            key: 'bloodType',
            customFilterDropdown: true,
            onFilter: (value, record) => record.bloodType.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownVisibleChange: visible => {
            if (visible) {
                setTimeout(() => {
                searchInput.value.focus();
                }, 100);
            }
            },
        }, {
            title: 'Quantity',
            dataIndex: 'quantity',
            key: 'quantity',
        }];

        const handleSearch = (selectedKeys, confirm, dataIndex) => {
        confirm();
        state.searchText = selectedKeys[0];
        state.searchedColumn = dataIndex;
        };

        const handleReset = clearFilters => {
        clearFilters({
            confirm: true,
        });
        state.searchText = '';
        };
        return{
            columns,
            handleSearch,
            handleReset,
            searchInput,
            ...toRefs(state),
            options: {
                responsive: true,
                maintainAspectRatio: false
            },
            data: {
                labels: [],
                datasets: [
                    {
                    backgroundColor: ['#ff6961', '#ffb480', '#f8f38d', '#42d6a4', '#08cad1', '#59adf6', '#9d94ff', '#c780e8'],
                    data: []
                    }
                ]
            },
            bloodType: {
                data: "",
                label: []
            },
            isLoaded: ref(false),
            isLoaded1: ref(false),
            donatedBlood: {
                data: "",
                count: [],
                address: [],
            },
            bloodTypeCount: []
        }
    },
    methods: {

    },
    data() {
        return {

            addresses: [],
        }
    },
    async created(){
        let existingObj = this;
        await axios.get('/api/admin/getBloodType')
        .then(function (response) {
            
            existingObj.bloodType.data = response.data.bloodType
            existingObj.bloodType.label = response.data.labels
            for(let i = 0; i < 7; i++){
                if(existingObj.bloodType.data[i] == 0){
                    existingObj.bloodType.data.splice(i,1);
                    existingObj.bloodType.label.splice(i,1);
                    i--;
                }
            }
            existingObj.data.labels = existingObj.bloodType.label
            for(let i = 0; i < existingObj.bloodType.data.length; i++){
                existingObj.data.datasets[0].data.push(existingObj.bloodType.data[i])
            }

            console.log();
            existingObj.isLoaded = true
        })
        .catch(function (error) {
        });

        await axios.get('/api/admin/getDonatedB')
        .then(function (response) {
            existingObj.donatedBlood.data = response.data.quantity
            existingObj.donatedBlood.count = response.data.quantityCount
            existingObj.donatedBlood.address = response.data.address
            existingObj.bloodTypeCount = response.data.sample

            // for(let i = 0; i < existingObj.bloodTypeAddress.length; i++){
            //     for(let k = 0; k < existingObj.bloodTypeAddress[i].length; k++){
            //         console.log(existingObj.bloodTypeAddress[i][k].bloodType);
            //         if (keys.indexOf(key) === -1) {
            //             keys.push(key);
            //             output.push(post);
            //         }
            //     }
            // }

            console.log( existingObj.donatedBlood.data);
            existingObj.isLoaded1 = true
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