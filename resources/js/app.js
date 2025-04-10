import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '../css/app.css'
import 'floating-vue/dist/style.css'
import 'remixicon/fonts/remixicon.css'
import '@vuepic/vue-datepicker/dist/main.css'
import { formatDate,  formatCurrency, formatToIDR, onlyNumber} from './utils/format';
import { Toast } from './utils/toast';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Antd from 'ant-design-vue';
import FloatingVue from 'floating-vue'

createInertiaApp({
  title: title => `${title} - Car Rent`,
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
    return pages[`./pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    const vueApp=  createApp({ render: () => h(App, props) })
      vueApp.use(plugin)
      vueApp.use(Antd)
      vueApp.use(FloatingVue)
      vueApp.component('VueDatePicker', VueDatePicker)
      vueApp.config.globalProperties.$formatDate = formatDate
      vueApp.config.globalProperties.$formatCurrency = formatCurrency
      vueApp.config.globalProperties.$formatToIDR = formatToIDR
      vueApp.config.globalProperties.$onlyNumber = onlyNumber
      vueApp.config.globalProperties.$Toast = Toast
      vueApp.mount(el)
      
  },
})