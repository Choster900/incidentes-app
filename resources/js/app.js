/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';

import VueSweetalert2 from 'vue-sweetalert2';

//importaciones de primevue
import PrimeVue from 'primevue/config' 

import Button from "primevue/button";
import AutoComplete from 'primevue/autocomplete';
import Calendar from 'primevue/calendar';
import Checkbox from 'primevue/checkbox';
import ColorPicker from 'primevue/colorpicker';
import Dropdown from 'primevue/dropdown';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputMask from 'primevue/inputmask';
import InputNumber from 'primevue/inputnumber';
import InputSwitch from 'primevue/inputswitch';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Password from 'primevue/password';
import RadioButton from 'primevue/radiobutton';
import Textarea from 'primevue/textarea';
import SplitButton from 'primevue/splitbutton';
import Toolbar from 'primevue/toolbar';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';
import Dialog from 'primevue/dialog';
import FileUpload from 'primevue/fileupload';
import Carousel from 'primevue/carousel';

import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';



/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);
import DepartamentoComponent from './components/DepartamentoComponent.vue';
app.component('departamento-component', DepartamentoComponent);
import RolComponent from './components/RolComponent.vue';
app.component('rol-component', RolComponent);
import IncidenteComponent from './components/IncidenteComponent.vue';
app.component('incidente-component', IncidenteComponent);
import PermisoComponent from './components/PermisoComponent.vue';
app.component('permiso-component', PermisoComponent);
//Administracion usuarios
import UsuarioComponent from './components/UsuarioComponent.vue';
app.component('usuario-component', UsuarioComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */



/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

//definiendo variables globales
app.config.globalProperties.axios = axios;


app.use(ToastService);
//agregamos los componentes de PrimeVue
app.component('Button', Button);
app.component('AutoComplete', AutoComplete);
app.component('Calendar', Calendar);
app.component('Checkbox', Checkbox);
app.component('Colorpicker', ColorPicker );
app.component('Dropdown', Dropdown);
app.component('IconField', IconField);
app.component('InputIcon', InputIcon);
app.component('InputMask', InputMask);
app.component('InputNumber', InputNumber);
app.component('InputSwitch', InputSwitch);
app.component('InputText', InputText);
app.component('MultiSelect', MultiSelect);
app.component('Password', Password);
app.component('RadioButton', RadioButton);
app.component('Textarea', Textarea);
app.component('SplitButton', SplitButton);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('ColumnGroup', ColumnGroup);
app.component('Row', Row);
app.component('Toolbar', Toolbar);
app.component('Dialog', Dialog);
app.component('Toast', Toast);
app.component('FileUpload', FileUpload);
app.component('Carousel', Carousel);

app.use(VueSweetalert2);
app.use(PrimeVue);

app.mount('#app');
