import 'bootstrap/dist/css/bootstrap.css'; // Import Bootstrap CSS
import 'jquery'; // Import jQuery
import 'popper.js'; // Import Popper.js
import 'bootstrap/dist/js/bootstrap.js'; // Import Bootstrap JavaScript
import 'bootstrap/dist/js/bootstrap.bundle.js'; // Import Bootstrap JavaScript


import Vue from 'vue'
import App from './App.vue'


Vue.config.productionTip = false

new Vue({
  render: h => h(App), 

}).$mount('#app')
