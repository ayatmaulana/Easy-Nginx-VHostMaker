#Nginx VHost Maker v0.12 
 
 
 
####Simplify Your Life :) 
<br> 
##Deskripsi 
Tool ini baru hanya untuk ***Linux Debian Familly *** support PHP 5.6 FPM, dan hanya untuk ***Development*** bukan untuk *Production*. 
 
Test sukses pada Ubuntu 14.04. 
<br> 
##Persiapan 
* [x] Linux Debian,Ubuntu,etc **(Debian Fams)** 
* [x] ***Nginx*** dan ***PHP5.6-FPM *** 
* [x] ***CLI ONLY*** 
 
<br> 
##Cara menggunakan 
 
 
+ Clone Repository ini. 
+ Tambahkan Server Name pada */etc/hosts* 
>contoh 
```conf 
  127.0.0.1       example-server.dev 
``` 
+ Kemudian Edit file  *php.ini* 
```ini 
  cgi.fix_pathinfo = 0; 
``` 
+ Siapkan Path  
> contoh */home/ayatmaulana/example* 
+ kemudian jalankan file **easyNginx.php** 
```zsj 
  php easyNginx.php 
``` 
[![nginx-ss.png](https://s17.postimg.org/qefwmrr1b/nginx_ss.png)](https://postimg.org/image/b5pz8zxcr/)
            
+ Isi *Server *, *Port* dan *Path* 
+ Setelah *success* coba akses *server name* yang tadi buat pada *Web Browser* 
 
 
___ 
<br> 
<br> 
 **Note** : agar lebih mudah dalam penggunaan.. pindahkan file **easyNginx.php** ke `/usr/local/bin` kemudia edit chmodnya menjadi `executable`, lalu bat alias pada `/home/yourname/.bashrc` berikut formatnya. 
 
```bash 
  alias easynginx="php /usr/local/bin/easyNginx.php"; 
``` 
hanya tinggal mengetikan `easynginx`+ `enter` pada terminal. 
 
<br> 
<br> 
 
 
##Thanks to 
+ Allah SWT 
+  
 \ No newline at end of file 
nambah color and baner
