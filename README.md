## ConnectFriend
ConnectFriend is a social networking site that allows users to communicate with other members, as well as share content and online media with those members.

## Cara Untuk Menjalankan Program ConnectFriend
1.  Jalankan program ConnectFriend dengan menggunakan perintah `npm install && npm run dev` dengan menggunakan command prompt.
2.  Setelah program berjalan, buka browser dan akses ke alamat localhost.
3.  Siapkan konfigurasi database MySQL di XAMPP, Laragon, dan sebagainya. Beri nama database misalnya `ConnectFriend` dan jalankan `php artisan migrate` setelah database berhasil dibuat.
4.  Jalankan perintah `php artisan db:seed` jika ingin menambahkan data bawaan ke dalam website `ConnectFriend`.

## Cara Menjalankan Fitur Live Chat
Jalankan perintah `php artisan queue:work` di command prompt.