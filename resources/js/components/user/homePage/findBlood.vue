    <template>
        <div class="h-screen bgImage">
            <div class="flex justify-center p-10">
                <h1 class="text-2xl font-bold text-white uppercase">Web Portal for Blood Bank in Negros Oriental Provincial Hospital</h1>
            </div>
            <div class="flex justify-center">
                <h1 class="text-lg font-base text-white">Looking for Blood</h1>
            </div>
            <div class="flex justify-center">
                <div class="w-3/6 border shadow-lg bg-white">
                    <div class="flex justify-center ">    
                        <div class="w-2/4 py-5">
                            <Form ref="formValidate" :model="formValidate" :rules="ruleValidate">
                                <FormItem label="Address" prop="address">
                                    <Select v-model="formValidate.address" placeholder="Select your Municipality/City">
                                        <Option value="Amlan">Amlan</Option>
                                        <Option value="Ayungon">Ayungon</Option>
                                        <Option value="Bacong">Bacong</Option>
                                        <Option value="Bais">Bais</Option>
                                        <Option value="Bais">Bais</Option>
                                        <Option value="Bayawan">Bayawan</Option>
                                        <Option value="Bindoy">Bindoy</Option>
                                        <Option value="Canlaon">Canlaon</Option>
                                        <Option value="Dauin">Dauin</Option>
                                        <Option value="Dumaguete">Dumaguete</Option>
                                        <Option value="Guihulngan">Guihulngan</Option>
                                        <Option value="Jimalalud-">Jimalalud</Option>
                                        <Option value="La Libertad">La Libertad</Option>
                                        <Option value="Mabinay">Mabinay</Option>
                                        <Option value="Manjuyod">Manjuyod</Option>
                                        <Option value="Pamplona">Pamplona</Option>
                                        <Option value="Santa Catalina">Santa Catalina</Option>
                                        <Option value="Siaton">Siaton</Option>
                                        <Option value="Sibulan">Sibulan</Option>
                                        <Option value="Tanjay">Tanjay</Option>
                                        <Option value="Tayasan">Tayasan</Option>
                                        <Option value="Valencia">Valencia</Option>
                                        <Option value="Vallehermoso">Vallehermoso</Option>
                                        <Option value="Zamboanguita">Zamboanguita</Option>
                                    </Select>
                                </FormItem>
                                <FormItem label="Type of Blood" prop="bloodType">
                                    <Select v-model="formValidate.bloodType" placeholder="Select Blood Type">
                                        <Option value="A+">A+</Option>
                                        <Option value="A-">A-</Option>
                                        <Option value="B+">B+</Option>
                                        <Option value="B-">B-</Option>
                                        <Option value="O+">O+</Option>
                                        <Option value="O-">O-</Option>
                                        <Option value="AB+">AB+</Option>
                                        <Option value="AB-">AB-</Option>
                                    </Select>
                                </FormItem>
                            </Form>
                            <div class="flex justify-center w-full">
                                <a-button key="submit" type="primary" @click="handleSubmit('formValidate')" >Find Match</a-button>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mb-5 flex justify-center">
                        <div class="w-4/5">
                            <h1 v-if="isActiveResult" class="text-lg">Result:</h1>
                            <div v-if="isActive" class="text-center text-red-500 text-lg mt-2">
                                The chosen Area does not have any Blood Donation.
                            </div>
                            <div class="grid grid-cols-2  gap-4">
                                <div v-for='(donatedBlood, index) in donatedBloods' :key='donatedBlood.id' class="text-end border-2 p-2">
                                    <p class="mt-1 text-black">Address: <a-tag color="green">{{ donatedBlood.address }} {{ donatedBlood.id }}</a-tag> </p>
                                    <p class="mt-1 text-black">Blood Type:  <a-tag color="red">{{ donatedBlood.bloodType }}</a-tag> </p>
                                    <Button :size="buttonSize" v-on:click="chatNow(donatedBlood)" type="dashed" class="mt-1 mr-2">Chat Now!</Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <loading v-model:active="isLoading"
                 :is-full-page="true"/>
        </div>
    </template>


    <script>
    import { defineComponent, ref, onMounted, h } from 'vue';
    import { DownloadOutlined } from '@ant-design/icons-vue';
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/css/index.css';
    export default defineComponent({
        components: {
        DownloadOutlined,
        Loading
    },
    setup(){
        const isActive = ref(false);
        const isLoading = ref(false);
        const isActiveResult = ref(false);
        return{
            isActive,
            isActiveResult,
            isLoading
        }
    },
    data(){
        return{
            buttonSize: 'small'
            ,
            formValidate: {
                bloodType: '',
                address: '',
            },
            ruleValidate: {
                bloodType: [
                    { required: true, message: 'The Blood Type cannot be empty', trigger: 'blur' }
                ],
                address: [
                    { required: true, message: 'The Address cannot be empty', trigger: 'blur' }
                ]
            },
            donatedBloods: [],
            db: ""
        }
    },
    methods: {
        async handleSubmit (name) {
            let existingObj = this;
            await this.$refs[name].validate((valid) => {
                if (valid) {
                        axios.post(`/api/admin/getDonatedBlood`, this.formValidate)
                        .then(function (response) {
                            existingObj.isActiveResult = true;
                            if(response.data == ''){
                                existingObj.isActive = true;
                            }
                            existingObj.donatedBloods = response.data
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                }
                
            })
        },
        chatNow(donatedBlood){
            let existingObj = this;
            existingObj.db = donatedBlood
            existingObj.isLoading = true
            axios.post(`/api/admin/chatNow`, existingObj.db)
            .then(function (response) {
                window.Laravel.currentRoom = response.data;
                existingObj.isLoading = false
                existingObj.$router.push({path: '/chatbox/'})
            })
            .catch(function (error) {
                existingObj.isLoading = false
                console.log(error);
            });
        },
    },
    created(){
        this.token = window.Laravel.csrfToken;
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

