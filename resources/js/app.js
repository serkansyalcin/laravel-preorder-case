import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axiosInstance from './lib/axios';
import { client } from 'laravel-precognition-vue';
import { createPinia } from 'pinia';
import useUser from './store/user';

client.use(axiosInstance)

const pinia = createPinia()
const app = createApp(App)

app.use(pinia)

const user = useUser()
user.fetchUser().finally(() => {
  app.use(router).mount('#app')
})
