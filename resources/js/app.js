import './bootstrap';
import Alpine from 'alpinejs'
import Highcharts from 'highcharts';
import Vue from 'vue';
window.Alpine = Alpine
 
new Vue({
    el: '#app',
});

Alpine.start()

// Contoh untuk membuat grafik
document.addEventListener('DOMContentLoaded', () => {
    Highcharts.chart('chart-container', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Grafik Contoh'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
        },
        yAxis: {
            title: {
                text: 'Nilai'
            }
        },
        series: [{
            name: 'Data 1',
            data: [1, 3, 2, 4, 6, 5]
        }]
    });
});

