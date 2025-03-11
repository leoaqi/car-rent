import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '../css/app.css'
import 'remixicon/fonts/remixicon.css'
import '@vuepic/vue-datepicker/dist/main.css'
import { formatDate,  formatCurrency, formatToIDR, onlyNumber} from './utils/format';
import { Toast } from './utils/toast';

createInertiaApp({
  title: title => `${title} - CMS Car Rent`,
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
    return pages[`./pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    const vueApp=  createApp({ render: () => h(App, props) })
      vueApp.use(plugin)
      vueApp.config.globalProperties.$formatDate = formatDate
      vueApp.config.globalProperties.$formatCurrency = formatCurrency
      vueApp.config.globalProperties.$formatToIDR = formatToIDR
      vueApp.config.globalProperties.$onlyNumber = onlyNumber
      vueApp.config.globalProperties.$Toast = Toast
      vueApp.mount(el)
      
  },
})