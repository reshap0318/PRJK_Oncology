import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { Tooltip } from 'bootstrap'
import App from './App.vue'

import router from './router'
import ElementPlus from 'element-plus'
import i18n from '@/core/plugins/i18n'

//imports for app initialization
import { initInlineSvg } from '@/core/plugins/inline-svg'
import { initKtIcon } from '@/core/plugins/keenthemes'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(ElementPlus)

initInlineSvg(app)
initKtIcon(app)

app.use(i18n)

app.directive('tooltip', (el) => {
    new Tooltip(el)
})

app.mount('#app')
