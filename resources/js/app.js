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
// import VueGoogleMaps from '@fawmi/vue-google-maps'


const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(ViewUIPlus);
// app.use(VueGoogleMaps, {
//     load: {
//         key: 'AIzaSyBqrwTHtdIIy2XFwP3GkVGaMqtEfjjwJuY',
//         libraries: 'places',
//     }
// });
app.use(router);
app.use(Antd);
app.mount('#app');