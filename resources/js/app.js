import {createApp} from 'vue';

require('./bootstrap');


import App from './App.vue';
import axios from 'axios';
import router from './router';
import Vue from 'vue';
import ViewUIPlus from 'view-ui-plus';
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';
import 'view-ui-plus/dist/styles/viewuiplus.css';


const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(ViewUIPlus);
app.use(router);
app.use(Antd);
app.mount('#app');