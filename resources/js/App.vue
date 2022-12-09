<script lang="ts">
import { defineComponent, defineAsyncComponent } from 'vue';
import axios from 'axios';
import HeaderMain from './components/header-main.vue';
import HeaderSwiper from './components/header-swiper.vue';
import FooterMain from './components/footer-main.vue';
import 'focus-visible/dist/focus-visible.min.js';

const csrfNode = document.querySelector('meta[name="csrf-token"]');
if (csrfNode) {
    axios.defaults.headers.post['X-CSRF-Token'] = csrfNode.getAttribute('content') || '';
}

const App = defineComponent({
    name: 'App',
    components: {},
});
export default App;
</script>
