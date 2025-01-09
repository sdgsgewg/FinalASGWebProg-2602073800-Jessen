## ConnectFriend
ConnectFriend is a social networking site that allows users to communicate with other members, as well as share content and online media with those members.

## Cara Untuk Menjalankan Program ConnectFriend
1.  Jalankan program ConnectFriend dengan menggunakan perintah `npm install && npm run dev` dengan menggunakan command prompt.
2.  Setelah program berjalan, buka browser dan akses ke alamat localhost.
3.  Siapkan konfigurasi database MySQL di XAMPP, Laragon, dan sebagainya. Beri nama database misalnya `ConnectFriend` dan jalankan `php artisan migrate` setelah database berhasil dibuat.
4.  Jalankan perintah `php artisan db:seed` jika ingin menambahkan data bawaan ke dalam website `ConnectFriend`.

## Cara untuk men-generate random image menggunakan PEXELS API
1.  Kunjungi `https://www.pexels.com/api/` dan buat akun baru di `Pexels` untuk mendapatkan API Key.
2.  Kemudian tambahkan informasi tersebut ke dalam file .env dengan konfigurasi di bawah ini:
    PEXELS_API_KEY=your_api_key
3.  Maka random image akan bisa di-generate setelah konfigurasi di atas telah dilakukan.

## Cara Menjalankan Fitur Live Chat
1.  Kunjungi `https://pusher.com/` dan buat akun baru di `Pusher` untuk mendapatkan App Keys (app_id, key, secret, dan cluster).
2.  Kemudian tambahkan informasi tersebut ke dalam file .env dengan konfigurasi di bawah ini:
    BROADCAST_DRIVER=pusher
    PUSHER_APP_ID=your_app_id
    PUSHER_APP_KEY=your_app_key
    PUSHER_APP_SECRET=your_app_secret
    PUSHER_APP_CLUSTER=your_app_cluster
3.  Jalankan perintah `php artisan queue:work` di command prompt untuk memulai fitur live chat.
