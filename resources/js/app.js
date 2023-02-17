import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css'
//import 'jquery/dist/jquery.min'
//import 'popper.js/dist/popper.min'
import 'bootstrap/dist/js/bootstrap.min'
import {createApp} from 'vue'

import App from './App.vue'
import PrimeVue from 'primevue/config';
import ToastService from "primevue/toastservice";
import 'primeicons/primeicons.css';
import "primeicons/primeicons.css";
import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";

const app = createApp(App);

app.use(PrimeVue)
app.use(ToastService)
app.mount("#app");