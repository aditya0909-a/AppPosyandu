import Highcharts from 'highcharts';

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('chart-container');
    if (container) {
        Highcharts.chart('chart-container', {
            chart: { type: 'line' },
            title: { text: 'Grafik Contoh' },
            xAxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'] },
            yAxis: { title: { text: 'Nilai' } },
            series: [{ name: 'Data 1', data: [1, 3, 2, 4, 6, 5] }],
        });
    }
});
