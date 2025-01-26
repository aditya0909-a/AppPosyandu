import mix from 'laravel-mix';

// Menentukan path sumber daya dan tujuan output
mix.setPublicPath('public');

// Mengkompilasi dan menggabungkan file JavaScript
mix.js('resources/js/app.js', 'public/js')
   .extract()  // Menggunakan extract untuk menggabungkan vendor ke file terpisah
   .vue()      // Jika menggunakan Vue.js (opsional)

// Mengkompilasi file SCSS menjadi CSS
mix.sass('resources/sass/app.scss', 'public/css')

// Menggabungkan dan meminimalkan file CSS
mix.styles([
    'resources/css/style1.css',
    'resources/css/style2.css'
], 'public/css/all.css')

// Menambahkan Autoprefixer untuk CSS
mix.options({
    postCss: [
        require('autoprefixer')
    ]
});

// Menambahkan versioning file untuk cache-busting
mix.version();

// Mengkompilasi dan memindahkan gambar (jika ada)
mix.copy('resources/images', 'public/images');

// Menambahkan file font (misalnya untuk icon fonts)
mix.copy('resources/fonts', 'public/fonts');

// Menyediakan source maps untuk debugging (opsional)
mix.sourceMaps();

// Menjalankan browser sync untuk auto-refresh saat pengembangan (opsional)
mix.browserSync('localhost');

// Menyertakan konfigurasi untuk file lain (misalnya untuk pengolahan file di dalam direktori lain)
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js')
        }
    }
});

// Untuk file lain seperti SVG, gambar, atau asset tambahan, Anda dapat menggunakan perintah seperti
mix.copy('resources/svg', 'public/svg');
