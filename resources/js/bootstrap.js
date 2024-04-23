import _ from 'lodash';
import * as bootstrap from 'bootstrap';
import axios from 'axios';
import swal from 'sweetalert2';
import jquery from 'jquery';
import 'datatables.net-bs5';

window.$ = jquery;
window._ = _;
window.swal = swal;
window.axios = axios;
window.bootstrap = bootstrap;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; //ajax

const csrf_token = document.head.querySelector('meta[name="csrf-token"]');
if(csrf_token){
    window.csrf_token = csrf_token.content;
}else{
    console.error(
        'CSRF Token Not Found'
    )
}
