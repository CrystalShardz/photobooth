/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import CircularCountDownTimer from "vue-circular-count-down-timer";

import Photobooth from './components/Photobooth';
Vue.use(CircularCountDownTimer);

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = new Vue({
                        el: '#app',
                    });
